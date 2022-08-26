<?php namespace App\Http\Controllers;

use App;
use Fanky\Admin\Models\Page;
use Fanky\Admin\Models\Publication;
use Fanky\Admin\Models\PublicationTag;
use Request;
use SEOMeta;
use Settings;
use View;

class PublicationController extends Controller {
	public $bread = [];
	protected $news_page;

	public function __construct() {
		$this->news_page = Page::whereAlias('pubs')
			->get()
			->first();
		$this->bread[] = [
			'url'  => $this->news_page->url,
			'name' => $this->news_page->name
		];
	}

	public function index() {
		$page = $this->news_page;
		if (!$page)
			abort(404, 'Страница не найдена');
		$bread = $this->bread;
		$items = Publication::orderBy('date', 'desc')
			->public();
		$items = $items->paginate(Settings::get('news_per_page'));

		if ($p = Request::get('page')) {
			$page->title .= ' - Страница № ' . $p;
			$page->h1 .= ' - Страница № ' . $p;
			$page->description .= ' - Страница № ' . $p;
		}
		if (count(Request::query())) {
			SEOMeta::setCanonical($this->news_page->url);
		}
		SEOMeta::setTitle($page->title);
		SEOMeta::setDescription($page->description);
		SEOMeta::setKeywords($page->keywords);

		return view('pages.deals', [
			'items'           => $items,
			'h1'              => $page->h1,
			'name'            => $page->name,
			'text'            => $page->text,
			'bread'           => $bread,
		]);
	}

	public function item($alias) {
		$item = Publication::whereAlias($alias)->public()->first();
		if (!$item) abort(404);
		$bread = $this->bread;
		$bread[] = [
			'url'  => $item->url,
			'name' => $item->name
		];

		SEOMeta::setTitle($item->title);
		SEOMeta::setDescription($item->description);
		SEOMeta::setKeywords($item->keywords);
		return view('pages.text', [
			'item'        => $item,
			'h1'          => $item->name,
			'name'        => $item->name,
			'text'        => $item->text,
			'bread'       => $bread,
		]);
	}
}
