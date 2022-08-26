<?php namespace App\Http\Controllers;

use Carbon\Carbon;
use Fanky\Admin\Models\Feedback;
use Fanky\Admin\Models\Review;
use Mail;
use Request;
use Mailer;
use Settings;
use Cart;
use Validator;

class AjaxController extends Controller {

	private $fromMail = 'rail-ek@mail.ru';
	private $fromName = 'shpala-ural';

	public function postFeedback() {
		$data = Request::only(['name', 'phone', 'email', 'text']);
		$valid = Validator::make($data, [
			'name'  => 'required',
			'phone' => 'required',
		], [
			'name.required'  => 'Не заполнено поле Имя',
			'phone.required' => 'Не заполнено поле Телефон',
		]);

		if ($valid->fails()) {
			return ['errors' => $valid->messages()];
		} else {
			$feedback_data = [
				'type' => 1,
				'data' => $data
			];
			$feedback = Feedback::create($feedback_data);

			Mail::send('mail.feedback', ['feedback' => $feedback], function ($message) use ($feedback) {
				$title = $feedback->id . ' | Заявка | shpala-ural';
				$message->from($this->fromMail, $this->fromName)
					->to(Settings::get('feedback_email'))
					->subject($title);
			});

			return ['success' => true];
		}
	}

	public function postCallback() {
		$data = Request::only(['name', 'phone', 'email', 'text']);
		$valid = Validator::make($data, [
			'name'  => 'required',
			'phone' => 'required',
		], [
			'name.required'  => 'Не заполнено поле Имя',
			'phone.required' => 'Не заполнено поле Телефон',
		]);

		if ($valid->fails()) {
			return ['errors' => $valid->messages()];
		} else {
			$feedback_data = [
				'type' => 2,
				'data' => $data
			];
			$feedback = Feedback::create($feedback_data);

			Mail::send('mail.feedback', ['feedback' => $feedback], function ($message) use ($feedback) {
				$title = $feedback->id . ' | Заказ звонка | shpala-ural';
				$message->from($this->fromMail, $this->fromName)
					->to(Settings::get('header_email'))
					->subject($title);
			});

			return ['success' => true];
		}
	}

	public function postWriteback() {
		$data = Request::only(['name', 'email', 'text']);
		$valid = Validator::make($data, [
			'name'  => 'required',
			'email' => 'required',
		], [
			'name.required'  => 'Не заполнено поле Имя',
			'email.required' => 'Не заполнено поле Телефон',
			'text.required' => 'Не заполнено поле Текст',
		]);

		if ($valid->fails()) {
			return ['errors' => $valid->messages()];
		} else {
			$feedback_data = [
				'type' => 3,
				'data' => $data
			];
			$feedback = Feedback::create($feedback_data);

			Mail::send('mail.feedback', ['feedback' => $feedback], function ($message) use ($feedback) {
				$title = $feedback->id . ' | Ответить на письмо | shpala-ural';
				$message->from($this->fromMail, $this->fromName)
					->to(Settings::get('feedback_email'))
					->subject($title);
			});

			return ['success' => true];
		}
	}

	public function postAddReview() {
		$data = Request::only(['name', 'text']);
		$valid = Validator::make($data, [
			'name'  => 'required',
			'text'  => 'required|max:500'
		], [
			'name.required'  => 'Не заполнено поле Имя',
			'text.max'       => 'Слишком длинное сообщение',
		]);

		if ($valid->fails()) {
			return ['errors' => $valid->messages()];
		} else {
			$data['date'] = Carbon::now();
			$data['published'] = 0;
			$review = Review::create($data);
			Mail::send('mail.review', ['review' => $review], function ($message) use ($review) {
				$title = $review->id . ' | Отзыв | Oteli96';
				$message->from($this->fromMail, $this->fromName)
					->to(Settings::get('feedback_email'))
//					->to('as@klee.ru')
					->subject($title);
			});

			return ['success' => true, 'msg' => 'Спасибо за отзыв. После модерации он появится на сайте'];
		}
	}
}
