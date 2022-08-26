<?php namespace App\Http\Controllers;

use Fanky\Admin\Models\Catalog;
use Fanky\Admin\Models\Cottage;
use Fanky\Admin\Models\MaterialImage;
use Fanky\Admin\Models\Page;
use Fanky\Admin\Models\Product;
use Fanky\Admin\Models\Room;
use Fanky\Admin\Settings;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use SEOMeta;
use View;
use Request;

class CatalogController extends Controller {

    public function index() {
        $page = Page::getByPath(['catalog']);
        if(!$page) return abort(404);
        $bread = $page->bread();
        SEOMeta::setTitle($page->title);
        SEOMeta::setDescription($page->description);
        SEOMeta::setKeywords($page->keywords);

        return view('catalog.index', [
            'name'  => $page->name,
            'bread' => $bread,
        ]);
    }

	public function view($alias) {
		$path = explode('/', $alias);
		/* проверка на продукт в категории */
		$product = null;
		$end = array_pop($path);
		$category = Catalog::getByPath($path);
		if ($category && $category->published) {
			$product = Product::whereAlias($end)
				->public()
				->whereCatalogId($category->id)->first();
		}
			array_push($path, $end);

			return $this->category($path + [$end]);

	}

	public function category($path) {
		/** @var Catalog $category */
		$category = Catalog::getByPath($path);
		if (!$category || !$category->published) abort(404, 'Страница не найдена');
		$bread = $category->getBread();
		$children = $category->public_children;
		$products = $category->products()->get();
		$images = $category->images()->orderBy('order')->get();

		$features = $category->features()->get();
		$features_header = $category->features_header;
		$feat_before_slider = $category->feat_before_slider;

		$parent = $category->parent()->get();

		$gosts = $category->getPublicChildren();
		$gosts_array = [];

		foreach ($gosts as $gost) {
			$products = Product::where('catalog_id', '=', $gost->id)->public()->get();
			$gosts_array[$gost->name] = $products;
		}

		//обработка ajax-обращений, в routes добавить POST метод(!)
		if (request()->ajax()) {
			$view_products = [];
			foreach ($products as $product) {
				//добавляем новые элементы
				$view_products[] = view('components.cards-item', [
					'item' => $product,
				])->render();
			}

			return [
				//items как и в interface.js->$('.cards').append(json.items);
				'items'      => $view_products,
				'paginate' => view('paginations.category_links_limit', ['paginator' => $products])->render()
			];
		}
		//конец обработки ajax-обращений

		SEOMeta::setTitle($category->title);
		SEOMeta::setDescription($category->description);
		SEOMeta::setKeywords($category->keywords);

		return view('catalog.category', [
			'bread' => $bread,
			'category' => $category,
			'children' => $children,
			'images' => $images ?? null,
			'h1' => $category->getH1(),
			'products' => $products,
			'features' => $features,
			'features_header' => $features_header ?? null,
			'feat_before_slider' => $feat_before_slider,
			'gosts_array' => $gosts_array,
		]);
	}

    public function product(Product $product) {
        if(Request::ajax()) {
            return view('catalog.product_fastview', [
                'product' => $product
            ]);
        }
        $bread = $product->getBread();
        View::share('bread', $bread);
//		$related = $product->related()->public()->with('catalog')->get();
        SEOMeta::setTitle($product->title);
        SEOMeta::setDescription($product->description);
        SEOMeta::setKeywords($product->keywords);

        return view('catalog.product', [
            'product' => $product,
            //			'related'     => $related,
            'name'    => $product->name,
        ]);
    }
}
