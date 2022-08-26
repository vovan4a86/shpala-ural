<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 06.11.2015
 * Time: 12:32
 */

namespace App;
use Fanky\Admin\Models\Catalog as Catalog;
use Fanky\Admin\Models\Collection as Collection;
use Cache;
use Fanky\Admin\Models\Domain\DomainPage;
use Fanky\Admin\Models\Hardware;
use Fanky\Admin\Models\HardwareCategory;
use Fanky\Admin\Models\IndustryCategory;
use Fanky\Admin\Models\Page;
use Fanky\Admin\Models\Partner;
use Fanky\Admin\Models\Provider;
use Fanky\Admin\Models\Publication;
use Fanky\Admin\Models\Redirect;
use Fanky\Admin\Models\Product;
use Fanky\Admin\Models\News;
use App\Sitemap as Sitemap;
use Fanky\Admin\Models\Site;
use Fanky\Admin\Models\SoftwareCategory;
use Fanky\Admin\Models\Solution;
use Fanky\Admin\Models\Technology;
use Fanky\Admin\Models\Vacancy;
use Html;
use Illuminate\Database\Eloquent\Model;
use Image;
use Response;

class SiteHelper {
	public static $monthRu = [
		'January'   => 'Января',
		'February'  => 'Февраля',
		'March'     => 'Марта',
		'April'     => 'Апреля',
		'May'       => 'Мая',
		'June'      => 'Июня',
		'July'      => 'Июля',
		'August'    => 'Августа',
		'September' => 'Сентября',
		'October'   => 'Октября',
		'November'  => 'Ноября',
		'December'  => 'Декабря'
	];

	public static $monthRu2 = [
		'January'   => 'Январь',
		'February'  => 'Февраль',
		'March'     => 'Март',
		'April'     => 'Апрель',
		'May'       => 'Май',
		'June'      => 'Июнь',
		'July'      => 'Июль',
		'August'    => 'Август',
		'September' => 'Сентябрь',
		'October'   => 'Октябрь',
		'November'  => 'Ноябрь',
		'December'  => 'Декабрь'
	];
	public static $weekdayRu = [
		'Monday'    => 'Понедельник',
		'Tuesday'   => 'Вторник',
		'Wednesday' => 'Среда',
		'Thursday'  => 'Четверг',
		'Friday'    => 'Пятница',
		'Saturday'  => 'Суббота',
		'Sunday'    => 'Воскресенье',
	];

	/**
	 * Функция возвращает окончание для множественного числа слова на основании числа и массива окончаний
	 * @param  $number Integer Число на основе которого нужно сформировать окончание
	 * @param  $endingArray  Array Массив слов или окончаний для чисел (1, 4, 5),
	 *         например array('яблоко', 'яблока', 'яблок')
	 * @return String
	 */
	public static function getNumEnding($number, $endingArray)
	{
		$number = $number % 100;
		if ($number>=11 && $number<=19) {
			$ending=$endingArray[2];
		}
		else {
			$i = $number % 10;
			switch ($i)
			{
				case (1): $ending = $endingArray[0]; break;
				case (2):
				case (3):
				case (4): $ending = $endingArray[1]; break;
				default: $ending=$endingArray[2];
			}
		}
		return $ending;
	}

	public static function getRedirects($from = null){
		$redirects = Cache::get('redirects', []);
		if(!$redirects){
			$redirects_arr = Redirect::all(['from','to','code']);
			foreach($redirects_arr as $item){
				$redirects[$item->from] = $item;
			}
			Cache::add('redirects', $redirects, 1);
		}
		if(!is_null($from)){
			return isset($redirects[$from])? $redirects[$from]: null;
		} else {
			return $redirects;
		}
	}

	private static function recurseAddCatalog(&$map, Model $model, $parent_id = 0){
		$catalogs = $model::whereParentId($parent_id)->wherePublished(1)->get();
		foreach ($catalogs as $catalog) {
			$map->add_url($catalog->url);
			$products = $catalog->items()->wherePublished(1)->get();
			foreach ($products as $product) {
				$map->add_url($catalog->url . '/' . $product->alias);
			}
			self::recurseAddCatalog($map, $model, $catalog->id);
		}
	}

	public static function generateSitemap(){
		self::mainSitemap();
	}

	private static function mainSitemap(){
		$map = new Sitemap('');

		//страницы
		$pages = Page::wherePublished(1)->get();
		foreach ($pages as $page) {
			$map->add_url($page->url);
		}

		$news = News::wherePublished(1)->get();
		foreach($news as $n){
			$map->add_url($n->url);
		}

		$map->save();
		if (\App::isLocal()) {
			$status = 200;
			$header['Content-Type'] = 'application/xml';

			return Response::make($map->get_raw(), $status, $header);
		}
	}

	private static function recurseAddPage(&$map, $parent, $site){
		foreach ($parent->getPublicChildren() as $child){
			$map->add_url($child->url);
			if($child->alias == 'news'){
				self::domainNews($map, $site);
			}
			self::recurseAddPage($map, $child, $site);
		}
	}

	private static function domainNews(&$map, $site){
		$news = News::whereSiteId($site->id)->whereDomainPublished(1)->get();
		foreach ($news as $item){
			$map->add_url($site->url . '/news/' . $item->alias);
		}
	}

	/**
	 * @param \Swift_Message $message
	 */
	public static function signMessage(&$message) {
//		$privateKey = file_get_contents(base_path('dkim.key'));
//		$signer = new \Swift_Signers_DKIMSigner($privateKey, 'metallresurs.ru', 'mail');
//		$signer->ignoreHeader('Return-Path');
//		$message->attachSigner($signer);
	}

	/**
	 * @param     $src
	 * @param     $path
	 * @param int $attempts
	 *
	 * @return string
	 */
	public static function uploadImage($src, $path, $attempts = 1) {
		$upload_path = public_path('uploads' . DIRECTORY_SEPARATOR .
			$path . DIRECTORY_SEPARATOR);
		$ext = pathinfo($src, PATHINFO_EXTENSION);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $src);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.1) Gecko/2008070208');
		//curl_setopt($ch, CURLOPT_PROXY, "$proxy");

		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

		$data = curl_exec($ch);
		$info = curl_getinfo($ch);
		curl_close($ch);

		if ($info['http_code'] == 200 && $data) {
			$name = md5(uniqid(rand(), true)) . '.' . $ext;
			$file = $upload_path . $name;
			@file_put_contents($file, $data);

			return $name;
		} elseif ($attempts++ <= 5) return self::uploadImage($src, $path, $attempts + 1);
		else {
			return '';
		}
	}

	public static function parse_size($size) {
		$unit = preg_replace('/[^bkmgtpezy]/i', '', $size); // Remove the non-unit characters from the size.
		$size = preg_replace('/[^0-9\.]/', '', $size); // Remove the non-numeric characters from the size.
		if ($unit) {
			// Find the position of the unit in the ordered string which is the power of magnitude to multiply a kilobyte by.
			return round($size * pow(1024, stripos('bkmgtpezy', $unit[0])));
		} else {
			return round($size);
		}
	}

	public static function fileUploadMaxSize() {


		static $max_size = -1;

		if ($max_size < 0) {
			// Start with post_max_size.
			$max_size = self::parse_size(ini_get('post_max_size'));

			// If upload_max_size is less, then reduce. Except if upload_max_size is
			// zero, which indicates no limit.
			$upload_max = self::parse_size(ini_get('upload_max_filesize'));
			if ($upload_max > 0 && $upload_max < $max_size) {
				$max_size = $upload_max;
			}
		}

		return $max_size;
	}

	public static function resize_image($file, array $attributes = null, $size = null, $path_only = false, $crop = false) {
		try{
			$base = url('/');
			$file = str_replace($base, '', $file);
			if ($size) {
				$file_info = pathinfo($file);
				$new_path = $file_info['dirname'] . '/' . $size . '/';
				$new_path_full = public_path($file_info['dirname'] . '/' . $size . '/');
				if (!is_dir($new_path_full)) {
					mkdir($new_path_full, 0755, true);
				}
				$resized_file = $new_path . $file_info['basename'];
				if (!is_file(public_path($resized_file))) {
					$image = Image::make(public_path($file));
					$size = explode('x', $size);
					$width = array_get($size, 0);
					$height = array_get($size, 1);
					if ($crop) {
						$image->fit($width, $height);
					} else {
						$image->resize($width, $height, function ($constraint) {
							$constraint->aspectRatio();
							$constraint->upsize();
						});
					}
					$image->save(public_path( $resized_file));
				}
				$file = $resized_file;
			}

			if (strpos($file, '://') === false) {
				// Add the base URL
				$file = url($file);
			}
			if ($path_only === true) {
				return $file;
			}
			// Add the image link
			$attributes['src'] = $file;

			return Html::image($file, null, $attributes);
		} catch (\Exception $e){
			return '';
		}
	}

	public static $category_ids = [];
	/**
	 * @param int $parent_id
	 * @param \DOMElement $categories
	 * @param \DOMDocument $doc
	 */
	public static function recurseXmlAddCatalog($parent_id, &$categories, &$doc) {
		$cats = HardwareCategory::whereParentId($parent_id)->public()->orderBy('order')->get();
		foreach ($cats as $cat) {
			$category = $doc->createElement('category', htmlspecialchars(trim($cat->name)));
			$category->setAttribute('id', $cat->id);
			if ($cat->parent_id) {
				$category->setAttribute('parentId', $cat->parent_id);
			}
			$categories->appendChild($category);
			self::$category_ids[] = $cat->id;
			self::recurseXmlAddCatalog($cat->id, $categories, $doc);
		}
	}

	public static function generateHardwareXml() {
		try {
			$implementation = new \DOMImplementation();
			$dtd = $implementation->createDocumentType('yml_catalog', null, 'shops.dtd');

			$doc = $implementation->createDocument('', '', $dtd);
			$doc->encoding = 'UTF-8';
			$yml_catalog = $doc->createElement('yml_catalog');
			$yml_catalog = $doc->appendChild($yml_catalog);
			$yml_catalog->setAttribute('date', date('Y-m-d H:i'));
			$shop = $doc->createElement('shop');
			$yml_catalog->appendChild($shop);
			$name = $doc->createElement('name', 'datakrat');
			$company = $doc->createElement('company', 'Датакрат');
			$url = $doc->createElement('url', url('/'));
			$shop->appendChild($name);
			$shop->appendChild($company);
			$shop->appendChild($url);
			$currencies = $doc->createElement('currencies');
			$currency = $doc->createElement('currency');
			$currency->setAttribute('id', 'RUR');
			$currency->setAttribute('rate', '1');
			$currencies->appendChild($currency);
			$shop->appendChild($currencies);
			$categories = $doc->createElement('categories');
//			$cats = Catalog::wherePublished(1)->get();
			self::recurseXmlAddCatalog(0, $categories, $doc);

			$shop->appendChild($categories);

			$offers = $doc->createElement('offers');
			$products = Hardware::whereIn('category_id', self::$category_ids)
				->public()->get();
			/** @var Hardware $product */
			foreach ($products as $product) {
				$offer = $doc->createElement('offer');
				$offer->setAttribute('id', $product->id);
				//$offer->setAttribute('type', 'vendor.model');
				$offer->setAttribute('available', 'true');

				$url = $doc->createElement('url', $product->url);
				$price = $doc->createElement('price', $product->price);

				$currency = $doc->createElement('currencyId', 'RUR');
				$category = $doc->createElement('categoryId', $product->category_id);
				//$vendor = $doc->createElement('vendor', 'Russia');
				$name = $doc->createElement('name', htmlspecialchars(trim(($product->name))));
				$description_text = htmlspecialchars(strip_tags($product->getDescription()));
				$description_text .= '. Более подробная информация <a href="'.$product->url.'">на сайте</a>';
				$description = $doc->createElement('description', $description_text);

				$offer->appendChild($url);
				$offer->appendChild($price);

				$offer->appendChild($currency);
				$offer->appendChild($category);
				if ($image_src = $product->image_src) {
					$image = $doc->createElement('picture', $image_src);
					$offer->appendChild($image);
				}

				//$offer->appendChild($vendor);
				$offer->appendChild($name);
				//$offer->appendChild($delivery);
				if ($description) $offer->appendChild($description);

				//$offer->appendChild($param);
				$offers->appendChild($offer);
			}
			$shop->appendChild($offers);

			$path = public_path('hardware.xml');
			$fh = fopen($path, 'w+');
			fwrite($fh, $doc->saveXML());
			fclose($fh);

			return true;
		} catch (\Exception $e) {
			dd($e);
			echo $e->getMessage() . "\n" . $e->getLine();

			return false;
		}
	}

	public static function getEmail($text) {
		$matches = null;
		preg_match('/[\'\\"]mailto:([-a-z0-9_@\\.]+)[\'\\"]/', $text, $matches);
		return trim(array_get($matches, 1));
	}
}
