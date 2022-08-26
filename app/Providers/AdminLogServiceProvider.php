<?php namespace App\Providers;

use Fanky\Admin\Models\AdminLog;
use Fanky\Admin\Models\Athlete;
use Fanky\Admin\Models\AthleteTeam;
use Fanky\Admin\Models\Discipline;
use Fanky\Admin\Models\News;
use Fanky\Admin\Models\NewsCategory;
use Fanky\Admin\Models\Page;
use Fanky\Admin\Models\Sport;
use Fanky\Admin\Models\Team;
use Illuminate\Support\ServiceProvider;

class AdminLogServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot() {

		News::created(function($obj){
			AdminLog::add('Создана новая новость: ' . $obj->name);
		});

		News::updated(function($obj){
			AdminLog::add('Обновлена новость: ' . $obj->name);
		});

		News::deleting(function($obj){
			AdminLog::add('Удалена новость: ' . $obj->name);
		});

		Page::created(function($obj){
			AdminLog::add('Создана новая страница: ' . $obj->name);
		});

		Page::updated(function($obj){
			AdminLog::add('Отредактирована страница: ' . $obj->name);
		});

		Page::deleting(function($obj){
			AdminLog::add('Удалена страница: ' . $obj->name);
		});
	}

	/**
	 * Register any application services.
	 *
	 * This service provider is a great spot to register your various container
	 * bindings with the application. As you can see, we are registering our
	 * "Registrar" implementation here. You can add your own bindings too!
	 *
	 * @return void
	 */
	public function register() {
	}

}
