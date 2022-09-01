<?php namespace Fanky\Admin\Controllers;

use Fanky\Admin\Models\CatalogFeature;
use Fanky\Admin\Models\CatalogImage;
use Fanky\Admin\Models\Cottage;
use Fanky\Admin\Models\CottageImage;
use Fanky\Admin\Models\Room;
use Fanky\Admin\Models\RoomImage;
use Request;
use Settings;
use Validator;
use Text;
use DB;
use Image;
use Thumb;
use Fanky\Admin\Models\Catalog;
use Fanky\Admin\Models\Product;
use Fanky\Admin\Models\ProductImage;

class AdminCatalogController extends AdminController {

	public function getIndex() {
		$catalogs = Catalog::orderBy('order')->get();

		return view('admin::catalog.main', ['catalogs' => $catalogs]);
	}

	public function postProducts($catalog_id) {
		$catalog = Catalog::findOrFail($catalog_id);
//		if (in_array($catalog->alias, $catalog::$cottage_aliases)) {
//			$products = $catalog->cottages()->orderBy('order')->get();
//
//			return view('admin::catalog.cottages', ['catalog' => $catalog, 'products' => $products]);
//		}
//		if (in_array($catalog->alias, $catalog::$room_aliases)) {
//			$products = $catalog->rooms()->orderBy('order')->get();
//
//			return view('admin::catalog.rooms', ['catalog' => $catalog, 'products' => $products]);
//		}
		$products = $catalog->products()->orderBy('order')->get();

		return view('admin::catalog.products', ['catalog' => $catalog, 'products' => $products]);
	}

	public function getProducts($catalog_id) {
		$catalogs = Catalog::orderBy('order')->get();

		return view('admin::catalog.main', ['catalogs' => $catalogs, 'content' => $this->postProducts($catalog_id)]);
	}

	public function postCatalogEdit($id = null) {
		if (!$id || !($catalog = Catalog::findOrFail($id))) {
			$catalog = new Catalog;
			$catalog->parent_id = Request::input('parent');
			$catalog->published = 1;
		}
		$catalogs = $this->getCatalogRecurse();
		$addtional_catalogs = $catalog->addtional_catalogs;
		$items = CatalogFeature::all()->where('catalog_id', '=', $id);

		return view('admin::catalog.catalog_edit', [
			'catalog' => $catalog,
			'catalogs' => $catalogs,
			'addtional_catalogs' => $addtional_catalogs,
			'items' => $items,
		]);
	}

	public function getCatalogEdit($id = null) {
		$catalogs = Catalog::orderBy('order')->get();
		$items = CatalogFeature::where('catalog_id', '=', $id);

		return view('admin::catalog.main', ['catalogs' => $catalogs, 'content' => $this->postCatalogEdit($id), 'items' => $items]);
	}

	public function postCatalogSave() {
		$id = Request::input('id');
		$data = Request::except(['id', 'image', 'additional_catalog']);
		$image = Request::file('image');
		if (!array_get($data, 'published')) $data['published'] = 0;
		if (!array_get($data, 'on_main')) $data['on_main'] = 0;
		if (!array_get($data, 'feat_before_slider')) $data['feat_before_slider'] = 0;
		if (!array_get($data, 'alias')) $data['alias'] = Text::translit($data['name']);
		if (!array_get($data, 'title')) $data['title'] = $data['name'];
		if (!array_get($data, 'h1')) $data['h1'] = $data['name'];
		$additional_catalogs = array_filter(array_unique(Request::get('additional_catalog', [])));
		// валидация данных
		$validator = Validator::make(
			$data,[
				'name' => 'required',
			]);
		if ($validator->fails()) {
			return ['errors' => $validator->messages()];
		}
		// Загружаем изображение
		if ($image) {
			$file_name = Catalog::uploadImage($image);
			$data['image'] = $file_name;
		}
		// сохраняем страницу
		$catalog = Catalog::find($id);
		$redirect = false;
		if (!$catalog) {
			$data['order'] = Catalog::where('parent_id', $data['parent_id'])->max('order') + 1;
			$catalog = Catalog::create($data);
			$redirect = true;
		} else {
			if ($catalog->image && isset($data['image'])) {
				$catalog->deleteImage();
			}
			$catalog->update($data);
		}
		$catalog->addtional_catalogs()->sync($additional_catalogs);
		if ($redirect) {
			return ['redirect' => route('admin.catalog.catalogEdit', [$catalog->id])];
		} else {
			return ['success' => true, 'msg' => 'Изменения сохранены'];
		}

	}

	public function postCatalogReorder() {
		// изменеие родителя
		$id = Request::input('id');
		$parent = Request::input('parent');
		DB::table('catalogs')->where('id', $id)->update(array('parent_id' => $parent));
		// сортировка
		$sorted = Request::input('sorted', []);
		foreach ($sorted as $order => $id) {
			DB::table('catalogs')->where('id', $id)->update(array('order' => $order));
		}

		return ['success' => true];
	}

	public function postCatalogDelete($id) {
		$catalog = Catalog::findOrFail($id);
		$catalog->delete();

		return ['success' => true];
	}

	public function postProductEdit($id = null) {
		if (!$id || !($product = Product::findOrFail($id))) {
			$product = new Product;
			$product->catalog_id = Request::input('catalog');
			$product->published = 1;
		}
		$catalogs = Catalog::orderBy('order')->get();

		return view('admin::catalog.product_edit', ['product' => $product, 'catalogs' => $catalogs]);
	}

	public function getProductEdit($id = null) {
		$catalogs = Catalog::orderBy('order')->get();

		return view('admin::catalog.main', ['catalogs' => $catalogs, 'content' => $this->postProductEdit($id)]);
	}

	public function postProductSave() {
		$id = Request::input('id');
		$data = Request::except(['id']);
		if (!array_get($data, 'published')) $data['published'] = 0;
		if (!array_get($data, 'alias')) $data['alias'] = Text::translit($data['name']);
		if (!array_get($data, 'title')) $data['title'] = $data['name'];
		if (!array_get($data, 'h1')) $data['h1'] = $data['name'];

		// валидация данных
		$validator = Validator::make($data, [
			'name' => 'required',
		]);
		if ($validator->fails()) {
			return ['errors' => $validator->messages()];
		}

		// сохраняем страницу
		$product = Product::find($id);
		if (!$product) {
			$data['order'] = Product::where('catalog_id', $data['catalog_id'])->max('order') + 1;
			$product = Product::create($data);

			return ['redirect' => route('admin.catalog.productEdit', [$product->id])];
		} else {
			$product->update($data);
		}

		return ['success' => true, 'msg' => 'Изменения сохранены'];
	}

	public function postProductReorder() {
		$sorted = Request::input('sorted', []);
		foreach ($sorted as $order => $id) {
			DB::table('products')->where('id', $id)->update(array('order' => $order));
		}

		return ['success' => true];
	}

	public function postUpdateOrder($id) {
		$order = Request::get('order');
		Product::whereId($id)->update(['order' => $order]);

		return ['success' => true];
	}

	public function postProductDelete($id) {
		$product = Product::findOrFail($id);
		foreach ($product->images as $item) {
			$item->deleteImage();
			$item->delete();
		}
		$product->delete();

		return ['success' => true];
	}

	public function postProductImageUpload($product_id) {
		$product = Product::findOrFail($product_id);
		$images = Request::file('images');
		$items = [];
		if ($images) foreach ($images as $image) {
			$file_name = ProductImage::uploadImage($image, true);
			$order = ProductImage::where('product_id', $product_id)->max('order') + 1;
			$item = ProductImage::create(['product_id' => $product_id, 'image' => $file_name, 'order' => $order]);
			$items[] = $item;
		}

		$html = '';
		foreach ($items as $item) {
			$html .= view('admin::catalog.product_image', ['image' => $item, 'active' => '']);
		}

		return ['html' => $html];;
	}

	public function postProductImageOrder() {
		$sorted = Request::input('sorted', []);
		foreach ($sorted as $order => $id) {
			ProductImage::whereId($id)->update(['order' => $order]);
		}

		return ['success' => true];
	}

	public function postProductImageDelete($id) {
		$item = ProductImage::findOrFail($id);
		$item->deleteImage();
		$item->delete();

		return ['success' => true];
	}

	public function getGetCatalogs($id = 0) {
		$catalogs = Catalog::whereParentId($id)->orderBy('order')->get();
		$result = [];
		foreach ($catalogs as $catalog) {
			$has_children = ($catalog->children()->count()) ? true : false;
			$result[] = [
				'id' => $catalog->id,
				'text' => $catalog->name,
				'children' => $has_children,
				'icon' => ($catalog->published) ? 'fa fa-eye text-green' : 'fa fa-eye-slash text-muted',
			];
		}

		return $result;
	}

	private function getCatalogRecurse($parent_id = 0, $lvl = 0) {
		$result = [];
		$pages = Catalog::whereParentId($parent_id)->orderBy('order')->get();
		foreach ($pages as $page) {
			$result[$page->id] = str_repeat('&mdash;', $lvl) . $page->name;
			$result = $result + $this->getCatalogRecurse($page->id, $lvl + 1);
		}

		return $result;
	}

	public function postCatalogImageUpload($product_id) {
		Catalog::findOrFail($product_id);
		$images = Request::file('images');
		$items = [];
		if ($images) foreach ($images as $image) {
			$file_name = CatalogImage::uploadImage($image, false);
			$order = CatalogImage::where('catalog_id', $product_id)->max('order') + 1;
			$item = CatalogImage::create(['catalog_id' => $product_id, 'image' => $file_name, 'order' => $order]);
			$items[] = $item;
		}

		$html = '';
		foreach ($items as $item) {
			$html .= view('admin::catalog.catalog_image', ['image' => $item, 'active' => '']);
		}

		return ['html' => $html];
	}

	public function postCatalogImageOrder() {
		$sorted = Request::input('sorted', []);
		foreach ($sorted as $order => $id) {
			CatalogImage::whereId($id)->update(['order' => $order]);
		}

		return ['success' => true];
	}

	public function postCatalogImageDelete($id) {
		$item = CatalogImage::findOrFail($id);
		$item->deleteImage();
		$item->delete();

		return ['success' => true];
	}

	public function addFeature($catalog_id) {
	    $data['catalog_id'] = $catalog_id;
	    $item = CatalogFeature::create($data);
		return view('admin::features.edit', ['item' => $item]);
	}

    public function editFeature($id) {
        $item = CatalogFeature::find($id);
        return view('admin::features.edit', ['item' => $item]);
    }

	public function saveFeature() {
		$id = Request::input('id');
		$catalog_id = Request::input('catalog_id');
		$data = Request::only(['text']);
		$image = Request::file('image');

		// валидация данных
		$validator = Validator::make($data, ['text' => 'required']);
		if ($validator->fails()) {
			return ['errors' => $validator->messages()];
		}

		// Загружаем изображение
		if ($image) {
			$file_name = CatalogFeature::uploadIcoImage($image);
			$data['image'] = $file_name;
		}

		// сохраняем страницу
		$article = CatalogFeature::find($id);
		$redirect = false;

		if (!$article) {
            $data['catalog_id'] = $catalog_id;
            $article = CatalogFeature::create($data);
			$redirect = true;
            return ['redirect' => route('admin.catalog.catalogEdit', ['id' => $catalog_id])];
		} else {
			if ($article->image && isset($data['image'])) {
				$article->deleteImage();
			}
			$article->update($data);
            return ['redirect' => route('admin.catalog.catalogEdit', [$article->catalog_id])];
        }
	}

	public function delFeature($id) {
		$feature = CatalogFeature::findOrFail($id);
		$feature->delete();
		return ['success' => true];
	}


    public function delFeatureImage($id) {
        $item = CatalogFeature::find($id);
        if(!$item) return ['error' => 'image_not_found'];

        $item->update(['image' => null]);

        return ['redirect' => route('admin.catalog.addFeature', ['id' => $item->id])];
//        return ['success' => true];
    }

}
