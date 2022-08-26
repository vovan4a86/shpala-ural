<?php namespace App\Console\Commands;

use Fanky\Admin\Models\CatalogImage;
use Fanky\Admin\Models\CottageImage;
use Fanky\Admin\Models\GalleryItem;
use Fanky\Admin\Models\RoomImage;
use Illuminate\Console\Command;
use Image;
use SiteHelper;

class ApplyWatermark extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'apply-watermark';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle() {
		$this->info('apply-watermark to CottageImage');
		$images = CottageImage::query()->get();
		$this->info('count images: ' . count($images));
		foreach ($images as $image){
			$file = public_path(CottageImage::UPLOAD_URL . $image->image);
			if(is_file($file)){
				$object = Image::make($file);
				$object = SiteHelper::addWatermark($object);
				$object->save();
			}
		}
		$this->info('apply-watermark to RoomImage');
		$images = RoomImage::query()->get();
		$this->info('count images: ' . count($images));
		foreach ($images as $image){
			$file = public_path(RoomImage::UPLOAD_URL . $image->image);
			if(is_file($file)){
				$object = Image::make($file);
				$object = SiteHelper::addWatermark($object);
				$object->save();
			}
		}
		$this->info('apply-watermark to CatalogImage');
		$images = CatalogImage::query()->get();
		$this->info('count images: ' . count($images));
		foreach ($images as $image){
			$file = public_path(CatalogImage::UPLOAD_URL . $image->image);
			if(is_file($file)){
				$object = Image::make($file);
				$object = SiteHelper::addWatermark($object);
				$object->save();
			}
		}
		$this->info('apply-watermark to GalleryItem');
		$images = GalleryItem::query()->whereIn('gallery_id', [3,4])->get();
		$this->info('count images: ' . count($images));
		foreach ($images as $image){
			$file = public_path(GalleryItem::UPLOAD_URL . $image->image);
			if(is_file($file)){
				$object = Image::make($file);
				$object = SiteHelper::addWatermark($object);
				$object->save();
			}
		}
	}

}
