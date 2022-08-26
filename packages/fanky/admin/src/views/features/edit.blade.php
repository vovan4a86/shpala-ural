
@extends('admin::template')

@section('scripts')
    <script type="text/javascript" src="/adminlte/plugins/ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="/adminlte/plugins/autocomplete/jquery.autocomplete.min.js"></script>
    <script type="text/javascript" src="/adminlte/interface_news.js"></script>
@stop

@section('page_name')
    <h1>Добавление преимущества</h1>
@stop

@section('content')
    <form action="{{ route('admin.catalog.saveFeature') }}" onsubmit="return newsSave(this, event)">
        <input type="hidden" name="id" value="{{ $id }}">

        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab">Параметры</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    {!! Form::groupText('text', '', 'Название') !!}
                    <div class="form-group">
                        <label for="article-image">Изображение (40x40, *.ico)</label>
                        <input id="article-image" type="file" name="image" value=""
                               onchange="return newsImageAttache(this, event)">
                        <div id="article-image-block">
{{--                        @if ($item->image)--}}
{{--                            <img class="img-polaroid" src="{{ $item->thumb(1) }}" height="100"--}}
{{--                                 data-image="{{ $item->image_src }}"--}}
{{--                                 onclick="return popupImage($(this).data('image'))">--}}
{{--                            <a class="images_del" href="{{ route('admin.product-icons.delete-image', [$item->id]) }}" onclick="return newsImageDel(this, event)">--}}
{{--                                <span class="glyphicon glyphicon-trash text-red"></span></a>--}}
{{--                        @else--}}
{{--                            --}}
{{--                        @endif--}}
                            <p class="text-yellow">Изображение не загружено.</p>
                        </div>
                    </div>

                </div>
            </div>

            <div class="box-footer">
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </div>
        </div>
    </form>

@stop

