<?php namespace App\Http\Controllers;

use Cache;
use Carbon\Carbon;
use Fanky\Admin\Models\Catalog;
use Fanky\Admin\Models\Deal;
use Fanky\Admin\Models\GalleryItem;
use Fanky\Admin\Models\News;
use Fanky\Admin\Models\Page;
use Fanky\Admin\Models\Product;
use Fanky\Admin\Models\Review;
use Request;
use SEOMeta;

class WelcomeController extends Controller {

	public function index() {
		$page = Page::find(1);

		SEOMeta::setTitle($page->title);
		SEOMeta::setDescription($page->description);
		SEOMeta::setKeywords($page->keywords);
		$page->ogGenerate();
		$lastModify = Carbon::now()->subHour(1);
		if ($response = $this->checkLastmodify($lastModify)) {
			return $response;
		}

		$shpala_url = Catalog::find(1)->getUrl();
		$opora_url = Catalog::find(1)->getUrl();

		$shpalas = Catalog::find(5)->products()->public()->get();
		$oporas = Catalog::find(6)->products()->public()->get();

		if(count(Request::query())){
			SEOMeta::setCanonical(url('/'));
		}

		return response()->view('pages.index', [
			'page'        => $page,
			'text'        => $page->text,
			'h1'          => $page->getH1(),
			'shpalas' 		=> $shpalas,
			'oporas' 		=> $oporas,
			'shpala_url' => $shpala_url,
			'opora_url' => $opora_url,
		])->setLastModified();
	}
}
