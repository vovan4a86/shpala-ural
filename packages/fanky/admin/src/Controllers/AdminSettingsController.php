<?php namespace Fanky\Admin\Controllers;

use Fanky\Admin\Settings;
use Request;
use Validator;
use Text;
use DB;
use Fanky\Admin\Models\Setting;
use Fanky\Admin\Models\SettingGroup;
use Image;

class AdminSettingsController extends AdminController {

	public static $image_array = ['jpg', 'jpeg', 'png', 'gif', 'bmp'];

	public function getIndex() {
		// $s = Setting::find(98);
		// $s->params = ['fields' => [
		// 	'img' => ['type' => 3, 'title' => 'Изображение'],
		// 	'name' => ['type' => 0, 'title' => 'Название'],
		// 	'width' => ['type' => 0, 'title' => 'Ширина'],
		// 	'height' => ['type' => 0, 'title' => 'Высота'],
		// 	'price1' => ['type' => 0, 'title' => 'Цена Стандарт'],
		// 	'price2' => ['type' => 0, 'title' => 'Цена Элитный'],
		// 	'price3' => ['type' => 0, 'title' => 'Цена Эконом'],
		// ]];
		// $s->save();

		$groups = SettingGroup::where('page_id', 0)->orderBy('order', 'asc')->get();
		$group = isset($groups[0]) ? $groups[0] : new SettingGroup;
		$settings = $group->settings()->orderBy('order')->get();

		return view('admin::settings.main', ['groups' => $groups, 'group' => $group, 'settings' => $settings]);
	}

	public function getGroupItems($id) {
		$group = SettingGroup::find($id);
		$groups = SettingGroup::where('page_id', 0)->orderBy('order', 'asc')->get();
		$settings = $group->settings()->orderBy('order')->get();

		return view('admin::settings.main', ['groups' => $groups, 'group' => $group, 'settings' => $settings]);
	}

	public function postGroupSave() {
		$id = Request::input('id');
		$data = Request::only(['name']);

		// сохраняем группу
		$group = SettingGroup::find($id);
		if (!$group) {
			$group = SettingGroup::create($data);
		} else {
			$group->update($data);
		}

		return ['success' => true, 'view' => view('admin::settings.group_row', ['group' => $group, 'active' => new SettingGroup])->render()];
	}

	public function postGroupDelete($id) {
		$group = SettingGroup::find($id);
		DB::table('settings')->where('group_id', $id)->delete();
		$group->delete();

		return ['success' => true];
	}

	public function postClearValue($id) {
		$setting = Setting::findOrFail($id);
		@unlink(base_path() . $setting::UPLOAD_PATH . $setting->value);
		$setting->value = '';
		$setting->save();

		return ['success' => true];
	}

	public function anyEditSetting($id = null) {
		if (!$id || !$setting = Setting::findOrFail($id)) {
			$setting = new Setting;
			$setting->group_id = Request::input('group');
		}

		return view('admin::settings.edit', ['setting' => $setting]);
	}

	public function anyBlockParams() {
		$id = Request::input('id');
		$type = Request::input('type');

		if (!$id || !$setting = Setting::findOrFail($id)) {
			$setting = new Setting;
			$setting->type = $type;
		}

		return view('admin::settings.edit_params', ['setting' => $setting]);
	}

	public function postEditSettingSave() {
		$id = Request::input('id');
		$data = Request::only('group_id', 'code', 'type', 'name', 'description');
		$data['params'] = [];
		$params = Request::input('params', []);

		$rules = [
			'name' => 'required',
			'type' => 'required',
			'code' => 'required|unique:settings,code',
		];

		if ($id && $setting = Setting::findOrFail($id)) {
			$rules['code'] = 'required|unique:settings,code,' . $setting->id;
		}

		// валидация данных
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			return ['errors' => $validator->messages()];
		}

		//Определяем параметры
		switch ($data['type']) {
			case 4:
			case 6:
				foreach ($params['fields']['key'] as $n => $key) {
					if (!$key) continue;
					$data['params']['fields'][$key]['type'] = $params['fields']['type'][$n];
					$data['params']['fields'][$key]['title'] = $params['fields']['title'][$n];
				}
				break;
			case 7:
				# code...
				break;
		}

		// Сохраняем настройку
		if ($id) {
			$setting->update($data);
		} else {
			$order = Setting::whereGroupId($data['group_id'])->max('order');
			$data['order'] = $order + 1;
			$setting = Setting::create($data);
		}

		return ['success' => true, 'msg' => 'Изменения сохранены!', 'row' => view('admin::settings.items', ['settings' => [$setting]])->render()];
	}

	public function postSave() {
		$group_id = Request::input('group_id');
		$data = Request::input('setting', []);
		$settings = Setting::where('group_id', $group_id)->get();
		foreach ($settings as $setting) {
			self::settingSave($setting, array_get($data, $setting->id));
		}

		if (empty($_FILES)) {
			return ['success' => true, 'msg' => 'Изменения сохранены'];
		} else {
			return ['redirect' => route('admin.settings.groupItems', [$group_id])];
		}
	}

	public static function settingSave($setting, $value) {
		switch ($setting->type) {
			case 0:
			case 1:
			case 2:
				$setting->value = $value;
				$setting->save();
				break;
			case 3:
				if (starts_with($value, 'setting_file_')) {
					if ($setting->value) @unlink(base_path() . $setting::UPLOAD_PATH . $setting->value);
					if ($file = Request::file($value)) {
						$ext = $file->getClientOriginalExtension();
						$file_name = 'setting_' . $setting->id . '.' . $ext;
						$file->move(base_path() . $setting::UPLOAD_PATH, $file_name);
						if(in_array($ext, self::$image_array)){
							Image::make(base_path($setting::UPLOAD_PATH . $file_name))->save(null, Settings::get('image_quality', 100));
						}
						$value = $file_name;
					}
				} elseif (!$value) {
					@unlink(base_path() . $setting::UPLOAD_PATH . $setting->value);
				}
				$setting->value = $value;
				$setting->save();
				break;
			case 4:
				array_walk_recursive($value, function (&$item, $key) use ($setting) {
					if (starts_with($item, 'setting_file_')) {
						if ($file = Request::file($item)) {
							$ext = $file->getClientOriginalExtension();
							$file_name = 'setting_' . $setting->id . '_' . uniqid() . '.' . $ext;
							$file->move(base_path() . $setting::UPLOAD_PATH, $file_name);
							if(in_array($ext, self::$image_array)){
								Image::make(base_path($setting::UPLOAD_PATH . $file_name))->save(null, Settings::get('image_quality', 100));
							}
							$item = $file_name;
						} else {
							$item = null;
						}
					}
				});
				$setting->value = json_encode($value);
				$setting->save();
				break;
			case 5:
				if ($value) {
					array_pop($value);
					$setting->value = json_encode($value);
					$setting->save();
				}
				break;
			case 6:
				$arr = [];
				foreach ($value as $f => $vs) {
					foreach ($vs as $n => $v) {
						$arr[$n][$f] = $v;
					}
				}
				array_pop($arr);
				$value = $arr;
				array_walk_recursive($value, function (&$item, $key) use ($setting) {
					if (starts_with($item, 'setting_file_')) {
						if ($file = Request::file($item)) {
							$ext = $file->getClientOriginalExtension();
							$file_nameNoExt = 'setting_' . $setting->id . '_' . uniqid();
							$file_name = $file_nameNoExt . '.' . $ext;
							$file->move(base_path() . $setting::UPLOAD_PATH, $file_name);
//                            if(in_array($ext, self::$image_array)){
//								Image::make(base_path($setting::UPLOAD_PATH . $file_name))->save(null, Settings::get('image_quality', 100));
//							}
							$item = $file_name;

//                            if($setting->id == 12) {
//                                // делаем дубли изображений только для слайдера на главной с разным разрешением
//                                $destinationPath = base_path() . $setting::UPLOAD_PATH;
//
//                                //webp full
//                                //$imageFullWebP = Image::make(base_path($setting::UPLOAD_PATH . $file_name))->encode('webp', 90);
//                                //$imageFullWebP->save($destinationPath . $file_nameNoExt . '.webp');
//
//                                //------------1600
//                                $imageResize1600 = Image::make(base_path($setting::UPLOAD_PATH . $file_name))->encode('jpg', 90);
//                                if ($imageResize1600->width() > 2400){
//                                    $imageResize1600->resize(2400, null, function ($constraint) {
//                                        $constraint->aspectRatio();
//                                    });
//                                }
//                                $imageResize1600->save($destinationPath . $file_nameNoExt . '--1600.jpg');
//
//                                //$imageResize1600p = Image::make(base_path($setting::UPLOAD_PATH . $file_name))->encode('webp', 90);
//                                //if ($imageResize1600p->width() > 2400){
//                                //    $imageResize1600p->resize(2400, null, function ($constraint) {
//                                //        $constraint->aspectRatio();
//                                //    });
//                                //}
//                                //$imageResize1600p->save($destinationPath . $file_nameNoExt . '--1600.webp');
//
//                                //------------1024
//                                $imageResize1024 = Image::make(base_path($setting::UPLOAD_PATH . $file_name))->encode('jpg', 90);
//                                if ($imageResize1024->width() > 1536){
//                                    $imageResize1024->resize(1536, null, function ($constraint) {
//                                        $constraint->aspectRatio();
//                                    });
//                                }
//                                $imageResize1024->save($destinationPath . $file_nameNoExt . '--1024.jpg');
//
//                                //$imageResize1024p = Image::make(base_path($setting::UPLOAD_PATH . $file_name))->encode('webp', 90);
//                                //if ($imageResize1024p->width() > 1536){
//                                //    $imageResize1024p->resize(1536, null, function ($constraint) {
//                                //        $constraint->aspectRatio();
//                                //    });
//                                //}
//                                //$imageResize1024p->save($destinationPath . $file_nameNoExt . '--1024.webp');
//
//                                //------------768
//                                $imageResize768 = Image::make(base_path($setting::UPLOAD_PATH . $file_name))->encode('jpg', 90);
//                                if ($imageResize768->width() > 1152){
//                                    $imageResize768->resize(1152, null, function ($constraint) {
//                                        $constraint->aspectRatio();
//                                    });
//                                }
//                                $imageResize768->save($destinationPath . $file_nameNoExt . '--768.jpg');
//
//                                //$imageResize768p = Image::make(base_path($setting::UPLOAD_PATH . $file_name))->encode('webp', 90);
//                                //if ($imageResize768p->width() > 1152){
//                                //    $imageResize768p->resize(1152, null, function ($constraint) {
//                                //        $constraint->aspectRatio();
//                                //    });
//                                //}
//                                //$imageResize768p->save($destinationPath . $file_nameNoExt . '--768.webp');
//                            }
                        } else {
							$item = null;
						}
					}
				});
				$setting->value = json_encode($value);
				$setting->save();
				break;
			case 7:
				if (empty($value)) $value = [];
				foreach ($value as $n => $v) {
					if (starts_with($v, 'setting_file_')) {
						if ($file = Request::file($v)) {
							$ext = $file->getClientOriginalExtension();
							$file_name = 'setting_' . $setting->id . '_' . uniqid() . '.' . $ext;
							$file->move(base_path() . $setting::UPLOAD_PATH, $file_name);
							if(in_array($ext, self::$image_array)){
								Image::make(base_path($setting::UPLOAD_PATH . $file_name))->save(null, Settings::get('image_quality', 100));
							}
							$value[$n] = $file_name;
						} else {
							unset($value[$n]);
						}
					}
				}
				// удаляем удаленные файлы
				foreach (array_diff($setting->value, $value) as $del_f) {
					@unlink(base_path() . $setting::UPLOAD_PATH . $del_f);
				}

				$setting->value = json_encode($value);
				$setting->save();
				break;
		}
	}
}
