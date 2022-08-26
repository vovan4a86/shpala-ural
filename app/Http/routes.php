<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//$cities = \Fanky\Admin\Models\City::select('alias')->get()->implode('alias', '|');
//Route::pattern('city', $cities);
Route::pattern('alias', '([A-Za-z0-9\-\/_]+)');
Route::pattern('id', '([0-9]+)');
Route::get('robots.txt', 'PageController@robots')->name('robots');
Route::group(['prefix' => 'ajax', 'as' => 'ajax.'], function () {
	Route::post('feedback', 'AjaxController@postFeedback')->name('feedback');
	Route::post('callback', 'AjaxController@postCallback')->name('callback');
	Route::post('writeback', 'AjaxController@postWriteback')->name('writeback');
	Route::post('reserv', 'AjaxController@postReserv')->name('reserv');
	Route::post('reserv-item', 'AjaxController@postReservItem')->name('reserv-item');
	Route::post('add-review', 'AjaxController@postAddReview')->name('add-review');
});
$root_catalogs = \Fanky\Admin\Models\Catalog::public()->whereParentId(0)->pluck('alias')
	->implode('|');
Route::pattern('root_catalogs', $root_catalogs);
Route::group(['middleware' => ['redirects']], function() {
	Route::get('/', 'WelcomeController@index')->name('main');

	Route::any('news', 'NewsController@index')->name('news');
	Route::get('news/{name}', ['as' => 'news.item', 'uses' => 'NewsController@item']);
//	Route::any('reviews', 'PageController@reviews')->name('reviews');
//	Route::any('actions', 'PageController@deals')->name('deals');
//	Route::any('actions/{name}', 'PageController@deal')->name('deal');
//	Route::any('photos', 'PageController@photos')->name('photos');
//	Route::any('catalog', ['as' => 'catalog.index', 'uses' => 'CatalogController@index']);
	Route::any('{root_catalogs}/{alias?}', 'CatalogController@view')
		->name('catalog.view');

	Route::any('{alias}', ['as' => 'default', 'uses' => 'PageController@page'])
		->where('alias', '([A-Za-z0-9\-\/_]+)');
});
