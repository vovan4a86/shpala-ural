<?php namespace App\Http\Controllers;

use App;
use Fanky\Admin\Models\Catalog;
use Fanky\Admin\Models\Deal;
use Fanky\Admin\Models\GalleryItem;
use Fanky\Admin\Models\Page;
use Fanky\Admin\Models\Product;
use Fanky\Admin\Models\Review;
use Fanky\Admin\Settings;
use Request;
use SEOMeta;
use View;

class PageController extends Controller {

	public function page($alias) {
		$path = explode('/', $alias);
		$page = Page::getByPath($path);
		if (!$page) abort(404, 'Страница не найдена');
		$lastModifed = $page->getLastModify();
		if ($response = $this->checkLastmodify($lastModifed)) {
			return $response;
		}
		$bread = [];

		foreach ($page->getParents(true) as $p) {
			$bread[] = [
				'url'  => $p->url,
				'name' => $p->name
			];
		}
		$children = $page->getPublicChildren();
		$view = 'pages.text';

		$prices = []; //массив для вывода на странице Цены
		if($page->id == 5) {
			$price_categories = Catalog::where('parent_id', '=', 0)->get();

			foreach ($price_categories as $cat) {
				$gosts = $cat->getPublicChildren();

				foreach ($gosts as $gost) {
					$products = Product::where('catalog_id', '=', $gost->id)->get();
					$prices[$cat->name][$gost->name] = $products;
				}
			}
		}

		if (view()->exists('pages.unique.' . $page->alias)) {
			$view = 'pages.unique.' . $page->alias;
		}

		$page->h1 = $page->getH1();
		SEOMeta::setTitle($page->title);
		SEOMeta::setDescription($page->description);
		SEOMeta::setKeywords($page->keywords);
		$page->ogGenerate();

		return response()->view($view, [
			'page'     => $page,
			'h1'       => $page->h1,
			'text'     => $page->text,
			'bread'    => $page->getBread(),
			'children' => $children,
			'prices' => $prices ?? null
		])->setLastModified($lastModifed);
	}

	public function robots() {
		$robots = new App\Robots();
		if (App::isLocal()) {
			$robots->addUserAgent('*');
			$robots->addDisallow('/');
		} else {
			$robots->addUserAgent('*');
			$robots->addDisallow('/admin');
			$robots->addDisallow('/ajax');
			$robots->addCleanParam([
				'page',
				'hotel',
				'place',
				'category',
				'attachment_id',
			]);
		}

		$robots->addHost(url('/'));
		$robots->addSitemap(url('sitemap.xml'));

		$response = response($robots->generate())
			->header('Content-Type', 'text/plain; charset=UTF-8');
		$response->header('Content-Length', strlen($response->getOriginalContent()));

		return $response;
	}

	public function reviews() {
		$page = Page::getByPath(['reviews']);
		if (!$page) abort(404);
		$page->h1 = $page->getH1();
		if ($p = Request::get('page')) {
			$page->title .= ' - Страница № ' . $p;
			$page->h1 .= ' - Страница № ' . $p;
			$page->description .= ' - Страница № ' . $p;
		}
		if (count(Request::query())) {
			SEOMeta::setCanonical($page->url);
		}
		$items = Review::query()->public()->orderBy('date', 'desc')
			->paginate(Settings::get('news_per_page'));

		SEOMeta::setTitle($page->title);
		SEOMeta::setDescription($page->description);
		SEOMeta::setKeywords($page->keywords);

		return view('pages.reviews', [
			'items' => $items,
			'h1'    => $page->h1,
			'text'  => $page->text,
			'bread' => $page->getBread()
		]);

	}

	public function deals() {
		$page = Page::getByPath(['actions']);
		if (!$page) abort(404);
		$page->h1 = $page->getH1();
		if ($p = Request::get('page')) {
			$page->title .= ' - Страница № ' . $p;
			$page->h1 .= ' - Страница № ' . $p;
			$page->description .= ' - Страница № ' . $p;
		}
		if (count(Request::query())) {
			SEOMeta::setCanonical($page->url);
		}
		$items = Deal::query()->public()->orderBy('date', 'desc')
			->paginate(Settings::get('news_per_page'));

		SEOMeta::setTitle($page->title);
		SEOMeta::setDescription($page->description);
		SEOMeta::setKeywords($page->keywords);

		return view('pages.deals', [
			'items' => $items,
			'h1'    => $page->h1,
			'text'  => $page->text,
			'bread' => $page->getBread()
		]);
	}

	public function photos() {
		$page = Page::getByPath(['photos']);
		if (!$page) abort(404);
		$page->h1 = $page->getH1();
		if ($p = Request::get('page')) {
			$page->title .= ' - Страница № ' . $p;
			$page->h1 .= ' - Страница № ' . $p;
			$page->description .= ' - Страница № ' . $p;
		}
		if (count(Request::query())) {
			SEOMeta::setCanonical($page->url);
		}
		$items = GalleryItem::whereGalleryId(4)->orderBy('order')
			->paginate(Settings::get('photo_per_page'));

		SEOMeta::setTitle($page->title);
		SEOMeta::setDescription($page->description);
		SEOMeta::setKeywords($page->keywords);

		return view('pages.photos', [
			'items' => $items,
			'h1'    => $page->h1,
			'text'  => $page->text,
			'bread' => $page->getBread()
		]);
	}

	public function deal($alias) {
		$page = Page::getByPath(['actions']);
		if (!$page) abort(404);

		$deal = Deal::whereAlias($alias)->public()->first();
		if (!$deal) abort(404);
		$bread = $page->getBread();
		$bread[] = [
			'name' => $deal->name,
			'url'  => $deal->url,
		];
		SEOMeta::setTitle($deal->title);
		SEOMeta::setDescription($deal->description);
		SEOMeta::setKeywords($deal->keywords);

		return view('pages.text', [
			'h1'    => $deal->name,
			'name'  => $deal->name,
			'text'  => $deal->text,
			'bread' => $bread
		]);
	}
}
