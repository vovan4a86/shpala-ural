<?php namespace Fanky\Admin\Models;

use App\Traits\HasImage;
use Illuminate\Database\Eloquent\Model;
use Thumb;

class CottageImage extends Model {
	use HasImage;
	protected $fillable = ['cottage_id', 'image', 'order'];

	public $timestamps = false;

	const UPLOAD_URL = '/uploads/cottages/';

	public static $thumbs = [
		1 => '295x221', //admin cottage_list
		2 => '137x102', //thumb_list
		3 => '472x269|fit', //room list
	];
}
