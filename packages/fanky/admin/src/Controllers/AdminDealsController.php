<?php namespace Fanky\Admin\Controllers;

use Fanky\Admin\Models\Deal;
use Request;
use Validator;
use Text;

class AdminDealsController extends AdminController {

	public function getIndex() {
		$news = Deal::orderBy('date', 'desc')->paginate(100);

		return view('admin::deals.main', ['news' => $news]);
	}

	public function getEdit($id = null) {
		if (!$id || !($article = Deal::find($id))) {
			$article = new Deal();
			$article->date = date('Y-m-d');
			$article->published = 1;
		}

		return view('admin::deals.edit', ['article' => $article]);
	}

	public function postSave() {
		$id = Request::input('id');
		$data = Request::only(['date', 'name', 'announce', 'text', 'published', 'on_main', 'alias', 'title', 'keywords', 'description']);
		$image = Request::file('image');

		if (!array_get($data, 'alias')) $data['alias'] = Text::translit($data['name']);
		if (!array_get($data, 'title')) $data['title'] = $data['name'];
		if (!array_get($data, 'published')) $data['published'] = 0;
		if (!array_get($data, 'on_main')) $data['on_main'] = 0;

		// валидация данных
		$validator = Validator::make(
			$data,
			[
				'name' => 'required',
				'date' => 'required',
			]
		);
		if ($validator->fails()) {
			return ['errors' => $validator->messages()];
		}

		// Загружаем изображение
		if ($image) {
			$file_name = Deal::uploadImage($image);
			$data['image'] = $file_name;
		}

		// сохраняем страницу
		$article = Deal::find($id);
		$redirect = false;
		if (!$article) {
			$article = Deal::create($data);
			$redirect = true;
		} else {
			if ($article->image && isset($data['image'])) {
				$article->deleteImage();
			}
			$article->update($data);
		}

		if($redirect){
			return ['redirect' => route('admin.deals.edit', [$article->id])];
		} else {
			return ['msg' => 'Изменения сохранены.'];
		}

	}

	public function postDelete($id) {
		$article = Deal::find($id);
		$article->delete();

		return ['success' => true];
	}
}
