<?php namespace Fanky\Admin\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Request;
use Validator;
use DB;
use Fanky\Admin\YouTube;
use Fanky\Admin\Models\Review;

class AdminReviewsController extends AdminController {

	public function getIndex() {
		$reviews = Review::orderBy('date', 'desc')->get();

		return view('admin::reviews.main', ['reviews' => $reviews]);
	}

	public function getEdit($id = null) {
		if (!$id || !($review = Review::findOrFail($id))) {
			$review = new Review;
			$review->published = 1;
			$review->date = Carbon::now();
		}

		return view('admin::reviews.edit', ['review' => $review]);
	}

	public function postSave() {
		$id = Request::input('id');
		$data = Request::except(['id']);

		if (!Arr::get($data, 'on_main')) $data['on_main'] = 0;
		if (!Arr::get($data, 'published')) $data['published'] = 0;

		// валидация данных
		$validator = Validator::make(
			$data,
			[
				'text' => 'required',
				'date' => 'required',
			]
		);
		if ($validator->fails()) {
			return ['errors' => $validator->messages()];
		}

		// сохраняем страницу
		$review = Review::find($id);
		if (!$review) {
			$review = Review::create($data);

			return ['redirect' => route('admin.reviews.edit', [$review->id])];
		} else {
			$review->update($data);
		}

		return ['msg' => 'Изменения сохранены.'];
	}

	public function postReorder() {
		$sorted = Request::input('sorted', []);
		foreach ($sorted as $order => $id) {
			DB::table('reviews')->where('id', $id)->update(array('order' => $order));
		}

		return ['success' => true];
	}

	public function postDelete($id) {
		$review = Review::find($id);
		$review->delete();

		return ['success' => true];
	}
}
