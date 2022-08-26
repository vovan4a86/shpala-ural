<?php namespace Fanky\Admin\Models;

use App\Traits\HasImage;
use Illuminate\Database\Eloquent\Model;
use Thumb;

class RoomImage extends Model {
	use HasImage;
	protected $fillable = ['room_id', 'image', 'order'];

	public $timestamps = false;

	const UPLOAD_URL = '/uploads/rooms/';

	public static $thumbs = [
		1 => '295x221|fit', //admin cottage_list
		2 => '137x102|fit', //thumb_list
		3 => '472x269|fit', //room list
	];
}
