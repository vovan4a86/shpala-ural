@extends('layout_2col')
@section('layout__right')
    @include('blocks.bread')
    <h1 class="page_tit">{{ $h1 }}</h1>
    <div class="reviewslist">
        @foreach($items as $item)
        <div class="reviewslist__item">
            <div class="review">
                <div class="review__inn">
                    <div class="review__name">{{ $item->name }}</div>
                    <div class="review__date">{{ $item->dateFormat() }}
                    </div>
                    <div class="review__descr">
                        {{ $item->text }}
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="write_reviews">
        <a href="#writereviews" class="btn btn--arr maglnk">Написать отзыв</a>
    </div>
    @include('paginations.default', ['paginator' => $items])
    <div class="pagetext text_page">
        {!! $text !!}
    </div>
@endsection