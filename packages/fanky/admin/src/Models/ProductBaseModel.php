<?php namespace Fanky\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Thumb;
use Carbon\Carbon;

abstract class ProductBaseModel extends Model {
	protected $_parents = [];
//	protected $fillable = ['catalog_id', 'name', 'text', 'price', 'image', 'alias', 'title', 'keywords', 'description', 'order', 'published'];
	protected $guarded = ['id'];

	const UPLOAD_URL = '/uploads/rooms/';
	private $_url;

	public static $thumbs = [
		1 => '295x221',
	];
	abstract function images();

	public static function boot() {
		self::saving(function (self $model) {
			$model->updateRootId();
		});

		parent::boot();
	}

	public function catalog() {
		return $this->belongsTo(Catalog::class, 'catalog_id');
	}

	public function scopePublic($query) {
		return $query->where('published', 1);
	}

	public function getImageAttribute() {
		if ($image = $this->images()->orderBy('order')->first()) {
			return $image;
		} else {
			return null;
		}
	}

	public function getImageSrcAttribute() {
		$image = $this->getImageAttribute();

		return ($image) ? $image->src : null;
	}

	public function thumb($thumb) {
		$image = $this->getImageAttribute();

		return ($image) ? $image->thumb($thumb) : null;
	}

	public function getUrlAttribute() {
		if(!$this->_url){
			$this->_url = $this->catalog->url . '/' . $this->id;
		}

		return $this->_url;
	}

	public function getParents($with_self = false, $reverse = false) {
		$parents = [];
		if ($with_self) $parents[] = $this;
		$catalogs = Catalog::getCatalogs();
		if (!count($this->_parents)) {
			$p = $catalogs[$this->catalog_id];
			$this->_parents[] = $p;
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

	public function delete() {
		foreach ($this->images as $image) {
			$image->delete();
		}

		parent::delete();
	}

	/**
	 * @return Carbon
	 */
	public function getLastModify() {
		return $this->updated_at;
	}

	public function getBread() {
		$bread = $this->catalog->getBread();
		$bread[] = [
			'url'  => $this->url,
			'name' => $this->name
		];

		return $bread;
	}

	public function getH1() {
		return $this->h1 ? $this->h1: $this->name;
	}

	public function getHotel() {
		return Catalog::find($this->root_id);
	}

	public function updateRootId() {
		$parents = $this->getParents();
		if (count($parents)) {
			$root = end($parents);
			$this->root_id = $root->id;
		};
	}
}
