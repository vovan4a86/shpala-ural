@extends('template')
@section('content')
    <div class="content">
        <div class="neck">
            <h1 class="page_tit">{{ $h1 }}</h1>
            @include('blocks.bread')
        </div>
        <div class="www">
            <div class="filter">
                <div class="filter__tit">Фильтр:
                </div>
                <div class="filter__inn">
                    @foreach($tags as $tag)
                        <a href="{{ route('news', ['tag' => $tag->id]) }}"
                           {!! $tag->id == Request::get('tag')? 'style="font-weight:bold"': '' !!}
                           class="filter__item">{{ $tag->tag }}</a>
                    @endforeach
                </div>
            </div>
            <!-- /filter-->
            <div class="news bricklayer">
                @foreach($items as $item)
                    @include('news.list_item')
                @endforeach
            </div>
        </div>
        @if($next_news_count)
        <div class="loadmore">
            <div class="loadmore__item js_more_lnk" data-url="{{ $next_news_page }}" onclick="moreNews(this)">
                <div class="loadmore__in">Еще
                    <span>{{ $next_news_count }}</span>
                </div>
                <div class="loadmore__ico"></div>
            </div>
            <div class="loadmore__item js_wait" style="display: none">
                <span>Загрузка</span>
            </div>
        </div>
        @endif
    </div>
@endsection