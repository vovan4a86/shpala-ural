@extends('admin::template')

@section('scripts')
	<script type="text/javascript" src="/adminlte/interface_reviews.js"></script>
@stop

@section('page_name')
	<h1>
		Отзывы
		<small>{{ $review->id ? 'Редактировать' : 'Новый' }}</small>
	</h1>
@stop

@section('breadcrumb')
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Главная</a></li>
		<li><a href="{{ route('admin.reviews') }}">Отзывы</a></li>
		<li class="active">{{ $review->id ? 'Редактировать' : 'Новый' }}</li>
	</ol>
@stop

@section('content')
	<form action="{{ route('admin.reviews.save') }}" onsubmit="return reviewsSave(this, event)">
		<input type="hidden" name="id" value="{{ $review->id }}">

		<div class="box box-solid">
			<div class="box-body">
                {!! Form::groupText('name', $review->name, 'Имя') !!}
                {!! Form::groupDate('date', $review->date, 'Дата') !!}
                {!! Form::groupTextarea('text', $review->text, 'Текст') !!}
				{!! Form::groupCheckbox('published', 1, $review->published, 'Показывать отзыв') !!}
				{!! Form::groupCheckbox('on_main', 1, $review->on_main, 'Показывать на главной') !!}
			</div>

			<div class="box-footer">
    			<button type="submit" class="btn btn-primary">Сохранить</button>
    		</div>
		</div>
	</form>
@stop