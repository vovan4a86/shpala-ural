@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ route('admin') }}"><i class="fa fa-dashboard"></i> Главная</a></li>
        <li><a href="{{ route('admin.catalog') }}"><i class="fa fa-list"></i> Каталог</a></li>
        @foreach($catalog->getParents(false, true) as $parent)
            <li><a href="{{ route('admin.catalog.products', [$parent->id]) }}">{{ $parent->name }}</a></li>
        @endforeach
        <li class="active">{{ $catalog->id ? $catalog->name : 'Новый раздел' }}</li>

    </ol>
@stop
@section('page_name')
    <h1>Каталог
        <small>{{ $catalog->id ? $catalog->name : 'Новый раздел' }}</small>
    </h1>
@stop

<form action="{{ route('admin.catalog.catalogSave') }}" onsubmit="return catalogSave(this, event)">
	<input type="hidden" name="id" value="{{ $catalog->id }}">

	<div class="nav-tabs-custom">
		<ul class="nav nav-tabs">
			<li class="active"><a href="#tab_1" data-toggle="tab">Параметры</a></li>
			<li><a href="#tab_2" data-toggle="tab">Текст</a></li>
			<li><a href="#tab_2b" data-toggle="tab">Преимущества</a></li>
			<li><a href="#tab_3" data-toggle="tab">Слайдер</a></li>
            @if($catalog->id)
                <li class="pull-right">
                    <a href="{{ $catalog->url }}" target="_blank">Посмотреть</a>
                </li>
            @endif
		</ul>
		<div class="tab-content">
			<div class="tab-pane active" id="tab_1">

                {!! Form::groupText('name', $catalog->name, 'Название') !!}
                {!! Form::groupTextarea('descr', $catalog->descr, 'Карткое описание') !!}
                {!! Form::groupText('h1', $catalog->h1, 'H1') !!}

                {!! Form::groupSelect('parent_id', ['0' => '---корень---'] + $catalogs,
                    $catalog->parent_id, 'Родительский раздел') !!}

                {!! Form::groupText('alias', $catalog->alias, 'Alias') !!}
                {!! Form::groupText('title', $catalog->title, 'Title') !!}
                {!! Form::groupText('keywords', $catalog->keywords, 'keywords') !!}
                {!! Form::groupText('description', $catalog->description, 'description') !!}

                <div class="form-group">
                    <label for="article-image">Изображение (1360x442)</label>
                    <input id="article-image" type="file" name="image" value="" onchange="return newsImageAttache(this, event)">
                    <div id="article-image-block">
                        @if ($catalog->image)
                            <img class="img-polaroid" src="{{ $catalog->thumb(1) }}" height="100" data-image="{{ $catalog->image_src }}"
                                 onclick="return popupImage($(this).data('image'))">
                        @else
                            <p class="text-yellow">Изображение не загружено.</p>
                        @endif
                    </div>
                </div>

                {!! Form::groupCheckbox('published', 1, $catalog->published, 'Показывать раздел') !!}
                {!! Form::hidden('hide_on_menu', 0) !!}
                {!! Form::groupCheckbox('hide_on_menu', 1, $catalog->hide_on_menu, 'Не показывать в меню') !!}
{{--                {!! Form::groupCheckbox('on_main', 1, $catalog->on_main, 'Показывать на главной') !!}--}}
			</div>

			<div class="tab-pane" id="tab_2">
                {!! Form::groupCheckbox('feat_before_slider', 1, $catalog->feat_before_slider, 'Преимущества идут перед слайдером') !!}
                {!! Form::groupText('features_header', $catalog->features_header, 'Заголовок преимуществ', ['rows' => 1]) !!}
                {!! Form::groupText('price_header', $catalog->price_header, 'Заголовок стоимости', ['rows' => 1]) !!}
                {!! Form::groupRichtext('text_prev', $catalog->text_prev, 'Вступительный текст до слайдера', ['rows' => 3]) !!}
                {!! Form::groupRichtext('text_after', $catalog->text_after, 'Заключительный текст', ['rows' => 3]) !!}
			</div>

            <div class="tab-pane" id="tab_2b">
                @include('admin::features.main')
            </div>

            <div class="tab-pane" id="tab_3">
                @if ($catalog->id)
                    <div class="form-group">
                        <label class="btn btn-success">
                            <input id="offer_imag_upload" type="file" multiple data-url="{{ route('admin.catalog.catalogImageUpload', $catalog->id) }}" style="display:none;"
                                   onchange="productImageUpload(this, event)">
                            Загрузить изображения
                        </label>
                    </div>

                    <div class="images_list">
                        @foreach ($catalog->images()->orderBy('order')->get() as $image)
                            @include('admin::catalog.catalog_image', ['image' => $image])
                        @endforeach
                    </div>
                @else
                    <p class="text-yellow">Изображения можно будет загрузить после сохранения!</p>
                @endif
            </div>
		</div>

		<div class="box-footer">
			<button type="submit" class="btn btn-primary">Сохранить</button>
		</div>
	</div>
</form>
<script type="text/javascript">
    $(".images_list").sortable({
        update: function(event, ui) {
            var url = "{{ route('admin.catalog.postCatalogImageOrder') }}";
            var data = {};
            data.sorted = $('.images_list').sortable("toArray", {attribute: 'data-id'} );
            sendAjax(url, data);
            //console.log(data);
        },
    }).disableSelection();
</script>
