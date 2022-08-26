<?php namespace Fanky\Admin\Models;

use App\Traits\HasImage;
use Illuminate\Database\Eloquent\Model;
use Thumb;

class CatalogImage extends Model {
	use HasImage;
	protected $fillable = ['catalog_id', 'image', 'order'];

	public $timestamps = false;

	const UPLOAD_URL = '/uploads/catalogs/';

	public static $thumbs = [
		1 => '150x100', //admin
		2 => '609x457', //relax list
	];
}
