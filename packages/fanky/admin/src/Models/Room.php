<?php namespace Fanky\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Thumb;
use Carbon\Carbon;

class Room extends ProductBaseModel {
	protected $guarded = ['id'];

	const UPLOAD_URL = '/uploads/rooms/';
	public static $thumbs = [
		1 => '295x221',
	];

	public function images() {
		return $this->hasMany(RoomImage::class, 'room_id');
	}

	public function getHotel() {
		return Catalog::find($this->root_id);
	}

	public function addtional_catalogs() {
		return $this->belongsToMany(Catalog::class);
	}
}
