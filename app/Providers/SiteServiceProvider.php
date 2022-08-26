<?php namespace App\Providers;

use Cache;
use DB;
use Fanky\Admin\Models\Catalog;
use Illuminate\Support\ServiceProvider;
use Fanky\Admin\Models\Page;
use Illuminate\View\View as IllumView;
use View;

class SiteServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot() {
		// пререндер для шаблона
		View::composer(['template'], function (IllumView $view) {
			$mob_pages = Page::where('parent_id', '=', 1)->public()->get();
			$mob_menu = [];
			$i = 0;
			foreach ($mob_pages as $page) {
				$mob_menu[$i]['name'] = $page->name;
				$mob_menu[$i]['link'] = $page->getUrl();
				$i++;
			}

			$top_menu = Page::query()->public()
								->orderBy('order')
                ->whereOnMenu(1)
								->get();
			$main_menu = Page::query()->public()
								->orderBy('order')
								->whereOnMenuBottom(1)->get();
			$footer_menu = Page::query()->public()
								->orderBy('order')
								->whereOnFooterMenu(1)->get();

			$view->with([
				'top_menu'  => $top_menu,
				'main_menu'  => $main_menu,
				'footer_menu'  => $footer_menu,
				'mob_menu' => $mob_menu
			]);
		});

		View::composer(['layout_2col'], function (IllumView $view) {
			$hotels = Catalog::query()
				->leftJoin('catalogs as p1', function ($join) {
					$join->on('catalogs.id', '=', 'p1.parent_id')
						->on('p1.published', '=', DB::raw('1'))
						->on('p1.hide_on_menu', '=', DB::raw('0'));
				})
				->where('catalogs.published', 1)
				->where('catalogs.parent_id', 0)
				->where('catalogs.hide_on_menu', 0)
				->whereIn('catalogs.id', Catalog::$oteli_ids)
				->groupBy('catalogs.id')
				->orderBy('catalogs.order')
				->get([
					'catalogs.*',
					DB::raw('count(p1.id) as children_count')]);
			$services = Catalog::query()
				->leftJoin('catalogs as p1', function ($join) {
					$join->on('catalogs.id', '=', 'p1.parent_id')
						->on('p1.published', '=', DB::raw('1'))
						->on('p1.hide_on_menu', '=', DB::raw('0'));
				})
				->where('catalogs.published', 1)
				->where('catalogs.parent_id', 0)
				->where('catalogs.hide_on_menu', 0)
				->whereNotIn('catalogs.id', Catalog::$oteli_ids)
				->groupBy('catalogs.id')
				->orderBy('catalogs.order')
				->get([
					'catalogs.*',
					DB::raw('count(p1.id) as children_count')]);
			$view->with([
				'hotels'   => $hotels,
				'services' => $services
			]);

		});
	}
}
