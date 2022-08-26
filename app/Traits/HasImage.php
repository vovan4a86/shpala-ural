<?php namespace App\Traits;
use Illuminate\Support\Str;
use Image;
use Settings;
use SiteHelper;
use Thumb;

/**
 * Created by PhpStorm.
 * User: aleks
 * Date: 19.12.2017
 * Time: 11:09
 */


trait HasImage{
	public $image_field = 'image';

	public function deleteImage($thumbs = null, $upload_url = null) {
		if(!$this->{$this->image_field}) return;
		if(!$thumbs){
			$thumbs = self::$thumbs;
		}
		if(!$upload_url){
			$upload_url = self::UPLOAD_URL;
		}

		foreach ($thumbs as $thumb => $size){
			$t = Thumb::url($upload_url . $this->{$this->image_field}, $thumb);
			@unlink(public_path($t));
		}
		@unlink(public_path($upload_url . $this->{$this->image_field}));
	}

	public function getImageSrcAttribute() {
		return $this->{$this->image_field} ? url(self::UPLOAD_URL . $this->{$this->image_field}) : null;
	}
	public function thumb($thumb) {
		if (!$this->{$this->image_field}) {
			return null;
		} else {
			$file = public_path(self::UPLOAD_URL . $this->{$this->image_field});
			$file = str_replace(['\\\\', '//'], DIRECTORY_SEPARATOR, $file);
			$file = str_replace(['\\', '/'], DIRECTORY_SEPARATOR, $file);

			if (!is_file(public_path(Thumb::url(self::UPLOAD_URL . $this->{$this->image_field}, $thumb)))) {
				if (!is_file($file))
					return null; //нет исходного файла
				//создание миниатюры
				Thumb::make(self::UPLOAD_URL . $this->{$this->image_field}, self::$thumbs);

			}

			return url(Thumb::url(self::UPLOAD_URL . $this->{$this->image_field}, $thumb));
		};
	}

	/**
	 * @param \Illuminate\Http\UploadedFile $image
	 * @param bool                          $add_watermark
	 *
	 * @return string
	 */
	public static function uploadImage($image, $add_watermark = false) {
		$file_name = md5(uniqid(rand(), true)) . '_' . time() . '.' . Str::lower($image->getClientOriginalExtension());
		$image->move(public_path(self::UPLOAD_URL), $file_name);
		$image = Image::make(public_path(self::UPLOAD_URL . $file_name))
			->resize(1920, 1080, function ($constraint) {
				$constraint->aspectRatio();
				$constraint->upsize();
			});
		if($add_watermark){
			$image = SiteHelper::addWatermark($image);
		}
		$image->save(null, Settings::get('image_quality', 100));
		Thumb::make(self::UPLOAD_URL . $file_name, self::$thumbs);
		return $file_name;
	}
}