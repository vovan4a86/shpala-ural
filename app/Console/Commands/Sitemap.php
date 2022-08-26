<?php namespace App\Console\Commands;

use App\SiteHelper;
use Illuminate\Console\Command;
use Mail;

class Sitemap extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $signature = 'sitemap';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Display an inspiring quote';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle() {
		SiteHelper::generateSitemap();
	}

}
