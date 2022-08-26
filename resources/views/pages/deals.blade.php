@extends('layout_2col')
@section('layout__right')
    @include('blocks.bread')
    <h1 class="page_tit">{{ $h1 }}</h1>
    <div class="pretext text_page">
        {!! $text !!}
    </div>
    <div class="actions by2">
        @foreach($items as $item)
        <div class="by2__col">
            <a href="{{ $item->url }}" class="action action--05">
                <span class="action__inn">
                    <span class="action__info">
                        <span class="action__tit">{{ $item->name }}</span>
                        <span class="action__subtit">{{ $item->announce }}</span>
                        <span class="action__btn">Подробнее</span>
                    </span>
                </span>
                <span class="action__pic">
                    <span class="action__picinn">
                        <img data-src="{{ $item->thumb(3) }}" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" alt="{{ $item->name }}" class="b-lazy">
                    </span>
                </span>
            </a>
        </div>
        @endforeach
    </div>

    @include('paginations.default', ['paginator' => $items])
@endsection