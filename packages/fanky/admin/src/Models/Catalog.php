<?php namespace Fanky\Admin\Models;

use App\Traits\HasImage;
use Cache;
use Illuminate\Database\Eloquent\Model;
use Thumb;
use URL;
use Carbon\Carbon;

/**
 * Fanky\Admin\Models\Catalog
 *
 * @property int                                                                         $id
 * @property int                                                                         $parent_id
 * @property string                                                                      $name
 * @property string|null                                                                 $text_prev
 * @property string|null                                                                 $text_after
 * @property string                                                                      $class
 * @property string                                                                      $alias
 * @property string                                                                      $title
 * @property string                                                                      $keywords
 * @property string                                                                      $description
 * @property int                                                                         $order
 * @property int                                                                         $published
 * @property int                                                                         $on_main
 * @property \Carbon\Carbon|null                                                         $created_at
 * @property \Carbon\Carbon|null                                                         $updated_at
 * @property string|null                                                                 $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Fanky\Admin\Models\Catalog[] $children
 * @property-read mixed                                                                  $image_src
 * @property-read mixed                                                                  $is_active
 * @property-read mixed                                                                  $url
 * @property-read \Fanky\Admin\Models\Catalog                                            $parent
 * @property-read \Illuminate\Database\Eloquent\Collection|\Fanky\Admin\Models\Product[] $products
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Catalog mainMenu()
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Catalog onMain()
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Catalog public ()
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Catalog whereAlias($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Catalog whereClass($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Catalog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Catalog whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Catalog whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Catalog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Catalog whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Catalog whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Catalog whereOnMain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Catalog whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Catalog whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Catalog wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Catalog whereTextAfter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Catalog whereTextPrev($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Catalog whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Catalog whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null                                                                 $price_name
 * @property string                                                                      $h1
 * @property string                                                                      $og_title
 * @property string                                                                      $og_description
 * @property string|null                                                                 $image
 * @property int|null                                                                    $product_count
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Catalog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Catalog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Catalog query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Catalog whereH1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Catalog whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Catalog whereOgDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Catalog whereOgTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Catalog wherePriceName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Catalog whereProductCount($value)
 */
class Catalog extends Model {
	use HasImage;
	protected $table = 'catalogs';
	protected $_parents = [];
	private $_url;

	#protected $fillable = ['parent_id', 'name', 'text_prev', 'text_after', 'alias', 'title', 'keywords', 'description', 'order', 'published', 'on_main'];
	protected $guarded = ['id'];

	protected $casts = [
		'settings' => 'array',
	];

	const UPLOAD_URL = '/uploads/catalogs/';

	public static $thumbs = [
		1 => '156x110', //admin
		2 => '472x269|fit', //index otel
	];

	public function parent() {
		return $this->belongsTo('Fanky\Admin\Models\Catalog', 'parent_id');
	}

	public function children() {
		return $this->hasMany('Fanky\Admin\Models\Catalog', 'parent_id');
	}

	public function products() {
		return $this->hasMany('Fanky\Admin\Models\Product', 'catalog_id');
	}

	public function addtional_catalogs() {
		return $this->belongsToMany(Catalog::class, 'catalog_catalog', 'catalog_id','pivot_catalog_id');
	}

	public function addtional_child() {
		return $this->belongsToMany(Catalog::class, 'catalog_catalog', 'pivot_catalog_id', 'catalog_id');
	}

	public function images() {
		return $this->hasMany(CatalogImage::class, 'catalog_id');
	}

	public function features() {
		return $this->hasMany(CatalogFeature::class, 'catalog_id');
	}

	public function scopePublic($query) {
		return $query->where('published', 1);
	}

	public function scopeOnMain($query) {
		return $query->where('on_main', 1);
	}

	public function scopeOnMenu($query) {
		return $query->where('hide_on_menu', 0);
	}

	public function scopeMainMenu($query) {
		return $query->public()->where('parent_id', 0)->orderBy('order');
	}
	public function getPublicChildren() {
		return $this->children()->public()->orderBy('order')->get();
	}
	public function getUrlAttribute() {
		if ($this->_url) return $this->_url;

		$path = [$this->alias];
		if (!count($this->_parents)) {
			$this->getParents();
		}
		foreach ($this->_parents as $parent) {
			$path[] = $parent->alias;
		}
		$path = implode('/', array_reverse($path));
		$this->_url = route('default', ['alias' => $path]);

		return $this->_url;
	}

	public function getUrl() {
		return $this->url;
	}

	public function getIsActiveAttribute() {
		//берем или весь или часть адреса, для родительских страниц
		$url = substr(URL::current(), 0, strlen($this->getUrlAttribute()));

		return ($url == $this->getUrlAttribute());
	}

	public function siblings() {
		return self::whereParentId($this->parent_id);
	}

	public function getParents($with_self = false, $reverse = false) {
		$p = $this;
		$parents = [];
		if ($with_self) $parents[] = $p;
		if (!count($this->_parents) && $this->parent_id > 0) {
			$catalogs = self::getCatalogs();
			while ($p && $p->parent_id > 0) {
				$p = @$catalogs[$p->parent_id];
				$this->_parents[] = $p;
			}
		}
		$parents = array_merge($parents, $this->_parents);
		if ($reverse) {
			$parents = array_reverse($parents);
		}

		return $parents;
	}

	public static function getCatalogs() {
		$catalogs = Cache::get('catalogs', []);
		if (!$catalogs) {
			$catalog_arr = Catalog::all(['id', 'parent_id', 'name', 'alias', 'published']);
			foreach ($catalog_arr as $item) {
				$catalogs[$item->id] = $item;
			}
			Cache::add('catalogs', $catalogs, 1);
		}

		return $catalogs;
	}

	/**
	 * @param string[] $path
	 *
	 * @return Catalog|null
	 */
	public static function getByPath($path) {
		$parent_id = 0;
		$catalog = null;

		/* проверка по пути */
		foreach ($path as $alias) {
			$catalog = Catalog::whereAlias($alias)
				->whereParentId($parent_id)
				->public()
				->get(['id', 'alias', 'parent_id'])
				->first();
			if ($catalog === null) {
				return null;
			}
			$parent_id = $catalog->id;
		}

		if ($catalog && $catalog->id > 0) {
			return Catalog::find($catalog->id);
		} else {
			return null;
		}
	}

	public function getBread() {
		$bread = [];
		$bread[] = [
			'name' => $this->name,
			'url'  => $this->url,
		];
		$catalog = $this;
		while ($catalog = $catalog->parent) {
			$bread[] = [
				'name' => $catalog->name,
				'url'  => $catalog->url,
			];
		}

		return array_reverse($bread, true);
	}

	public function delete() {
		foreach ($this->children as $product) {
			$product->delete();
		}
		foreach ($this->products as $product) {
			$product->delete();
		}

		parent::delete();
	}

	public static function getCatalogsRecurse($parent_id = 0, $lvl = 0, $only_public = true) {
		$result = [];
		$pages = self::whereParentId($parent_id)->orderBy('order');
		if ($only_public) {
			$pages->public();
		}
		$pages = $pages->get();
		foreach ($pages as $page) {
			$result[$page->id] = str_repeat('&nbsp;', $lvl * 3) . $page->name;
			$children = self::getCatalogsRecurse($page->id, $lvl + 1, $only_public);
			$result = $result + $children;
		}

		return $result;
	}

	/**
	 * @return Carbon
	 */
	public function getLastModify() {
		$catalog_ids = array_keys(self::getCatalogsRecurse($this->id));
		$catalog_ids[] = $this->id;
		$lastModifed_product = Product::query()->whereIn('catalog_id', $catalog_ids)
			->public()->max('updated_at');
		$lastModifed_catalog = self::whereIn('id', $catalog_ids)->max('updated_at');
		$lastModifed = $lastModifed_product->gt($lastModifed_catalog) ? $lastModifed_product : $lastModifed_catalog;
		if (!$lastModifed) {
			$page = Page::getByPath(['catalog']);
			$lastModifed = ($page) ? $page->updated_at : Carbon::now('Asia/Yekaterinburg');
		} else {
			$lastModifed = Carbon::createFromFormat("Y-m-d H:i:s", $lastModifed, 'Asia/Yekaterinburg');
		}

		return $lastModifed;
	}

	public function getH1() {
		return $this->h1 ? $this->h1: $this->name;
	}

	public function getChildren() {
		return $this->children()->public()->onMenu()->orderBy('order')->get();
	}

	public function getFilter() {
		if(in_array($this->alias, self::$cottage_aliases)){
			return $this->getFilterCottages();
		} elseif(in_array($this->alias, self::$room_aliases)){
			return $this->getFilterRooms();
		} else{
			return $this->getFilterOther();
		}
		return [];
	}

	public function getRoot() {
		$parents = $this->getParents(true);
		$end = end($parents);
		return self::find($end->id);

	}
}
