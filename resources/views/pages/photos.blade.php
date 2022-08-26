@extends('layout_2col')
@section('layout__right')
    @include('blocks.bread')
    <h1 class="page_tit">{{ $h1 }}</h1>
    <div class="pretext text_page">
        {!! $text !!}
    </div>
    <div class="cutgallery popup-gallery">
        @foreach($items as $item)
            <div class="cutgallery__item">
            <a href="{{ $item->src }}" title="{{ array_get($item->data, 'title', $h1) }}" class="cutgallery__link">
                <picture>
                    {{--<source srcset="uploads/$pic-text-gal-1.webp" type="image/webp">--}}
                    <img data-src="{{ $item->thumb(1) }}" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" alt="{{ array_get($item->data, 'title')?: $h1 }}" class="b-lazy">
                </picture>
            </a>
        </div>
        @endforeach
    </div>
    @include('paginations.default', ['paginator' => $items])
@endsection