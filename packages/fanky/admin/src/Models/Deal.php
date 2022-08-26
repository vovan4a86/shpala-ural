<?php namespace Fanky\Admin\Models;

use App\Traits\HasImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use SiteHelper;
use Thumb;
use Carbon\Carbon;

class Deal extends Model {
	use HasImage;
//	protected $fillable = ['name', 'image', 'published', 'date', 'announce', 'text', 'alias', 'title', 'keywords', 'description'];
	protected $guarded = ['id'];

	const UPLOAD_URL = '/uploads/deal/';
	public static $thumbs = [
		1 => '150x100', //admin
		2 => '400x290|fit', //index_page
		3 => '472x290|fit', //deal_page
	];

	public function scopePublic($query) {
		return $query->where('published', 1);
	}

	public function getUrlAttribute($value) {
		return route('deal', ['name' => $this->alias]);
	}

	public function dateFormat($format = 'd.m.Y') {
		if (!$this->date) return null;
		$date =  date($format, strtotime($this->date));
		$date = str_replace(array_keys(SiteHelper::$monthRu),
			SiteHelper::$monthRu, $date);

		return $date;
	}

	public static function last($count = 2) {
		$items = self::orderBy('date', 'desc')->public()->limit($count)->get();

		return $items;
	}

	/**
	 * @return Carbon
	 */
	public function getLastModify() {
		return $this->updated_at;
	}
}
