<?php namespace Fanky\Admin\Models;

use App\Traits\HasImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Thumb;

class CatalogFeature extends Model {
	use HasImage;
	protected $table = 'catalog_features';
	protected $fillable = ['catalog_id', 'image', 'text', 'order'];

	public $timestamps = false;

	const UPLOAD_URL = '/uploads/catalogs/features/';

	public static $thumbs = [
		1 => '40x40', //admin
	];

	public static function uploadIcoImage($image, $add_watermark = false) {
		$file_name = md5(uniqid(rand(), true)) . '_' . time() . '.' . Str::lower($image->getClientOriginalExtension());
		$image->move(public_path(self::UPLOAD_URL), $file_name);
//		$image = Image::make(public_path(self::UPLOAD_URL . $file_name))
//			->resize(1920, 1080, function ($constraint) {
//				$constraint->aspectRatio();
//				$constraint->upsize();
//			});
//		if($add_watermark){
//			$image = SiteHelper::addWatermark($image);
//		}
//		$image->save(null, Settings::get('image_quality', 100));
//		Thumb::make(self::UPLOAD_URL . $file_name, self::$thumbs);
		return $file_name;
	}
}
