@extends('inner')
@section('inner-page')
    @include('blocks.bread')
    <section class="section section--inner newses-page">
        <div class="container">
            <div class="section__title centered">{{ $h1 ?: $name }}</div>
            <div class="newses-page__list">
                @foreach($items as $item)
                    <article class="newses-page__item item-news">
                        <a class="item-news__link" href="{{ $item->url }}" title="{{ $item->name }}">
                            <img class="item-news__picture lazy entered loaded" src="{{ $item->thumb(2) }}"
                                 data-src="{{ $item->thumb(2) }}" alt="" width="374" height="123"
                                 data-ll-status="loaded">
                        </a>
                        <div class="item-news__date">{{ $item->dateFormat('d.m.Y') }}</div>
                        <h2 class="item-news__title">
                            <a href="{{ $item->url }}">{{ $item->name }}</a>
                        </h2>
                        <p class="item-news__text">{{ $item->announce }}</p>
                    </article>
                @endforeach
            </div>
            @include('paginations.default', ['paginator' => $items])

        </div>
    </section>
{{--    <div class="pagetext text_page">--}}
{{--        {!! $text !!}--}}
{{--    </div>--}}
@endsection
