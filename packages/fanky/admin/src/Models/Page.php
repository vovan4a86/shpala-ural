<?php namespace Fanky\Admin\Models;

use App\Traits\HasImage;
use App\Traits\OgGenerate;
use Cache;
use DB;
use Illuminate\Database\Eloquent\Model;
use SiteHelper;
use URL;
use Carbon\Carbon;

/**
 * Fanky\Admin\Models\Page
 *
 * @property int $id
 * @property int|null $old_id
 * @property int $parent_id
 * @property string $name
 * @property string|null $h1
 * @property string|null $image
 * @property string|null $og_title
 * @property string|null $og_description
 * @property string|null $text
 * @property string $alias
 * @property string|null $title
 * @property string|null $keywords
 * @property string|null $description
 * @property int $order
 * @property int $published
 * @property int $system
 * @property int $main_menu
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Fanky\Admin\Models\Page[] $children
 * @property-read \Illuminate\Database\Eloquent\Collection|\Fanky\Admin\Models\Gallery[] $galleries
 * @property-read mixed $additional_classes
 * @property-read mixed $image_src
 * @property-read mixed $is_active
 * @property-read mixed $url
 * @property-read \Fanky\Admin\Models\Page $parent
 * @property-read \Illuminate\Database\Eloquent\Collection|\Fanky\Admin\Models\SettingGroup[] $settingGroups
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Page main()
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Page newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Page newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Page public()
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Page query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Page subMenu()
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Page whereAlias($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Page whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Page whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Page whereH1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Page whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Page whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Page whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Page whereMainMenu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Page whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Page whereOgDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Page whereOgTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Page whereOldId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Page whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Page whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Page wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Page whereSystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Page whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Page whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Page whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Page extends Model {
	use HasImage, OgGenerate;
	const UPLOAD_URL = '/uploads/pages/';

	public static $thumbs = [
		1 => 'x100', //admin
	];

	protected $_parents = [];
	private $_url;
	public static $excludeRegionId = [ //страницы без региональности
		26, //reviews
		27, //news
	];
	public static $excludeRegionAlias = [ //страницы без региональности
		'reviews',
		'news',
	];

	//региональность пока только для каталога
	private $regionPage = [
		'24', //catalog
		'9' //contacts
	];

	public static $regionAliases = [
		'catalog', 'contacts'
	];

	protected $guarded = ['id'];

	public function parent() {
		return $this->belongsTo(self::class, 'parent_id');
	}

	public function children() {
		return $this->hasMany(self::class, 'parent_id');
	}

	public function settingGroups() {
		return $this->hasMany(SettingGroup::class, 'page_id');
	}

	public function galleries() {
		return $this->hasMany(Gallery::class, 'page_id');
	}

	public function scopePublic($query) {
		return $query->where('published', 1);
	}

	public function scopeMain($query) {
		return $query->where('parent_id', 1);
	}

	public function scopeSubMenu($query) {
		return $query->where('parent_id', $this->id)->public()->orderBy('order');
	}

	public function getUrl() {
		return $this->url;
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

//		$current_city = SiteHelper::getCurrentCity();
//		if ($current_city && !in_array($this->id, self::$excludeRegionId)) {
//			$path = $current_city->alias . '/' . ltrim($path, '/');
//		}
		$this->_url = route('default', ['alias' => $path]);

		return $this->_url;
	}

	public function getIsActiveAttribute() {
		//берем или весь или часть адреса, для родительских страниц
		//исключение страница каталога
//		if ($this->alias == 'catalog') {
//			$url = URL::current();
//		} else {
//			$url = substr(URL::current(), 0, strlen($this->getUrlAttribute()));
//		}
		$url = URL::current();

		return ($url == $this->getUrlAttribute());
	}

	public function getChildrenWithCount(){
		return self::getChildrenWithCountByParent($this->id);
	}

	public function getChildren() {
		return $this->children()->public()->orderBy('order')->get();
	}

	public static function getChildrenWithCountByParent($parent_id){
		return Page::query()
			->leftJoin('pages as p1', function ($join){
				$join->on('pages.id', '=', 'p1.parent_id')
					->on('p1.published', '=', DB::raw('1'));
			})
			->where('pages.published', 1)
			->where('pages.parent_id', $parent_id)
			->groupBy('pages.id')
			->orderBy('pages.order')
			->get([
				'pages.*',
				DB::raw('count(p1.id) as children_count')]);
	}

	/**
	 * Братья/сестры
	 *
	 * @return mixed
	 */
	public function siblings() {
		return self::whereParentId($this->parent_id);
	}

	/**
	 * @param string[] $path
	 *
	 * @return Page
	 */
	public static function getByPath($path) {
		$parent_id = 1;
		$page = null;

		/* проверка по пути */
		foreach ($path as $alias) {
			$page = Page::whereAlias($alias)
				->whereParentId($parent_id)
				->public()
				->get(['id', 'alias', 'parent_id'])
				->first();
			if ($page === null) {
				return null;
			}
			$parent_id = $page->id;
		}

		if ($page && $page->id > 0) {
			return Page::find($page->id);
		} else {
			return null;
		}
	}

	/**
	 * @param bool $with_self
	 * @param bool $reverse
	 *
	 * @return array
	 */
	public function getParents($with_self = false, $reverse = false) {
		$p = $this;
		$parents = [];
		if ($with_self) $parents[] = $p;
		if (!count($this->_parents) && $this->parent_id > 1) {
			while ($p && $p->parent_id > 1) {
				$p = self::getPages($p->parent_id); // Page::find($p->parent_id, ['id','parent_id','name','alias','published']);
				$this->_parents[] = $p;
			}
		}
		$parents = array_merge($parents, $this->_parents);
		if ($reverse) {
			$parents = array_reverse($parents);
		}

		return $parents;
	}

	public static function getPages($id = null) {
		$pages = Cache::get('pages', []);
		if (!$pages) {
			$pages_arr = Page::all(['id', 'name', 'alias', 'published', 'parent_id']);
			foreach ($pages_arr as $item) {
				$pages[$item->id] = $item;
			}
			Cache::add('pages', $pages, 1);
		}
		if ($id) {
			return (isset($pages[$id])) ? $pages[$id] : null;
		} else {
			return $pages;
		}
	}

	public function getBread() {
		$bread = [];
		$bread[] = [
			'name' => $this->name,
			'url' => $this->url,
		];
		$page = $this;
		while ($page = $page->parent && $page->parent_id > 1) {
			$bread[] = [
				'name' => $page->name,
				'url' => $page->url,
			];
		}

		return array_reverse($bread, true);
	}

	public function getH1() {
		return $this->h1 ? $this->h1: $this->name;
	}

	/**
	 * @return Page
	 */
	public function root() {
		$parents = $this->getParents(true);

		return end($parents);
	}

	public function getPublicChildren() {
		return $this->children()->public()->orderBy('order')->get();
	}

	public function getAdditionalClassesAttribute() {
		return array_get(self::$page_classes, $this->id);
	}

	public function delete() {
		$this->deleteImage();
		foreach ($this->children as $child) {
			$child->delete();
		}

		parent::delete();
	}

	/**
	 * @return Carbon
	 */
	public function getLastModify() {
		return $this->updated_at;
	}
}
