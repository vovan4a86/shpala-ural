<?php namespace Fanky\Admin\Controllers;

use Fanky\Admin\Models\NewsTag;
use Fanky\Admin\Settings;
use Illuminate\Support\Str;
use Request;
use Validator;
use Text;
use Thumb;
use Image;
use Fanky\Admin\Models\News;

class AdminNewsController extends AdminController {

	public function getIndex() {
		$news = News::orderBy('date', 'desc')->paginate(100);

		return view('admin::news.main', ['news' => $news]);
	}

	public function getEdit($id = null) {
		if (!$id || !($article = News::find($id))) {
			$article = new News;
			$article->date = date('Y-m-d');
			$article->published = 1;
		}

		return view('admin::news.edit', ['article' => $article]);
	}

	public function postSave() {
		$id = Request::input('id');
		$data = Request::only(['date', 'name', 'announce', 'text', 'published', 'alias', 'title', 'keywords', 'description']);
		$image = Request::file('image');

		if (!array_get($data, 'alias')) $data['alias'] = Text::translit($data['name']);
		if (!array_get($data, 'title')) $data['title'] = $data['name'];
		if (!array_get($data, 'published')) $data['published'] = 0;

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
			$file_name = News::uploadImage($image);
			$data['image'] = $file_name;
		}

		// сохраняем страницу
		$article = News::find($id);
		$redirect = false;
		if (!$article) {
			$article = News::create($data);
			$redirect = true;
		} else {
			if ($article->image && isset($data['image'])) {
				$article->deleteImage();
			}
			$article->update($data);
		}

		if($redirect){
			return ['redirect' => route('admin.news.edit', [$article->id])];
		} else {
			return ['msg' => 'Изменения сохранены.'];
		}

	}

	public function postDelete($id) {
		$article = News::find($id);
		$article->delete();

		return ['success' => true];
	}

	public function getGetTags() {
		$q = Request::get('tag_name');
		$result = NewsTag::where('tag', 'LIKE', '%'. $q . '%')
			->limit(10)
			->get()
			->transform(function($item){
				return ['id' => $item->id, 'name' => $item->tag];
			});

		return ['data' => $result];
	}

	public function postAddTag() {
		$tag = Request::get('tag');
		$tag = Str::ucfirst($tag);
		$item = NewsTag::firstOrCreate(['tag' => $tag]);
		$row = view('admin::news.tag_row', ['tag' => $item])->render();

		return ['row' => $row];
	}
}
