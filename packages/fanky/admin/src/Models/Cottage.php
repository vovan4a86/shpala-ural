<?php namespace Fanky\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Thumb;
use Carbon\Carbon;

class Cottage extends ProductBaseModel {

	protected $guarded = ['id'];

	const UPLOAD_URL = '/uploads/cottages/';
	public static $thumbs = [
		1 => '295x221',
	];

	public function images() {
		return $this->hasMany(CottageImage::class, 'cottage_id');
	}

	public function getHotel() {
		return Catalog::find($this->root_id);
	}

	public function addtional_catalogs() {
		return $this->belongsToMany(Catalog::class);
	}
}
