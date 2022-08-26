@extends('admin::template')

@section('scripts')
    <script type="text/javascript" src="/adminlte/plugins/ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="/adminlte/plugins/autocomplete/jquery.autocomplete.min.js"></script>
    <script type="text/javascript" src="/adminlte/interface_news.js"></script>
@stop

@section('page_name')
    <h1>
        Новости
        <small>{{ $article->id ? 'Редактировать' : 'Новая' }}</small>
    </h1>
@stop

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Главная</a></li>
        <li><a href="{{ route('admin.deals') }}">Акции</a></li>
        <li class="active">{{ $article->id ? 'Редактировать' : 'Новая' }}</li>
    </ol>
@stop

@section('content')
    <form action="{{ route('admin.deals.save') }}" onsubmit="return newsSave(this, event)">
        <input type="hidden" name="id" value="{{ $article->id }}">

        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab">Параметры</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">

                    {!! Form::groupDate('date', $article->date, 'Дата') !!}
                    {!! Form::groupText('name', $article->name, 'Название') !!}
                    {!! Form::groupTextarea('announce', $article->announce, 'Краткое описание', ['rows' => 3]) !!}
                    {!! Form::groupText('alias', $article->alias, 'Alias') !!}
                    {!! Form::groupText('title', $article->title, 'Title') !!}
                    {!! Form::groupText('keywords', $article->keywords, 'keywords') !!}
                    {!! Form::groupText('description', $article->description, 'description') !!}

                    {!! Form::groupText('og_title', $article->og_title, 'OpenGraph Title') !!}
                    {!! Form::groupText('og_description', $article->og_description, 'OpenGraph description') !!}
                    <div class="form-group">
                        <label for="article-image">Изображение (472x290)</label>
                        <input id="article-image" type="file" name="image" value=""
                               onchange="return newsImageAttache(this, event)">
                        <div id="article-image-block">
                            @if ($article->image)
                                <img class="img-polaroid" src="{{ $article->thumb(1) }}" height="100"
                                     data-image="{{ $article->image_src }}"
                                     onclick="return popupImage($(this).data('image'))">
                            @else
                                <p class="text-yellow">Изображение не загружено.</p>
                            @endif
                        </div>
                    </div>

                    {!! Form::groupRichtext('text', $article->text, 'Текст', ['rows' => 3]) !!}
                    {!! Form::groupCheckbox('published', 1, $article->published, 'Показывать акцию') !!}
                    {!! Form::groupCheckbox('on_main', 1, $article->on_main, 'Показывать на главной') !!}
                </div>
            </div>

            <div class="box-footer">
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </div>
        </div>
    </form>
@stop