@extends('template')
@section('content')
    <div class="content content--post">
        <div class="www">
            <div class="content__inn">
                <div class="neck">
                    <h1 class="page_tit page_tit--post">{{ $h1 }}</h1>
                    @include('blocks.bread')
                </div>
                <div class="post gs">
                    <div class="post__left gs-col">
                        <div class="post__pic">
                            @if($image = $item->thumb(3))
                                <img data-src="{{ $image }}"
                                     src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                                     alt="{{ $item->name }}" class="b-lazy">
                            @endif


                        </div>
                        <div class="post__tags tags">
                            @foreach($item->tags as $tag)
                                <div class="tags__tag">{{ $tag->tag }}</div>
                            @endforeach
                        </div>
                        <div class="post__date">{{ $item->dateFormat('d F Y') }}</div>
                        <div class="text_page">{!! $text !!}</div>
                        <div class="sharebig">
                            <div class="sharebig__tit">Поделиться:
                            </div>
                            <div class="sharebig__inn">
                                <a href="#" data-social="facebook" class="sharebig__item share_fb">
                                    <span class="sharebig__ico"></span>
                                    <span data-counter="facebook" class="sharebig__count"></span>
                                </a>
                                <a href="#" data-social="vkontakte" class="sharebig__item share_vk">
                                    <span class="sharebig__ico"></span>
                                    <span data-counter="vkontakte" class="sharebig__count"></span>
                                </a>
                                <a href="#" data-social="twitter" class="sharebig__item share_tw">
                                    <span class="sharebig__ico"></span>
                                    <span data-counter="twitter" class="sharebig__count">10</span>
                                </a>
                                <a href="#" class="sharebig__item share_tg">
                                    <span class="sharebig__ico"></span>
                                    <span class="sharebig__count">20</span>
                                </a>
                                <a href="#" data-social="odnoklassniki" class="sharebig__item share_ok">
                                    <span class="sharebig__ico"></span>
                                    <span data-counter="odnoklassniki" class="sharebig__count"></span>
                                </a>
                                <a href="#" data-social="googleplus" class="sharebig__item share_gp">
                                    <span class="sharebig__ico"></span>
                                    <span data-counter="googleplus" class="sharebig__count">10000</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="post__right gs-col">
                        @if($relative && count($relative))
                            <div class="cupboard">
                                <div class="cupboard__tit">Другие материалы</div>
                                <div class="cupboard__inn">
                                    <ul class="newslist">
                                        @foreach($relative as $relative_item)
                                            <li class="newslist__item">
                                                <span class="newslist__date">{{ $relative_item->dateFormat() }}</span>
                                                <a href="{{ $relative_item->url }}"
                                                   class="newslist__descr">{{ $relative_item->name }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif


                        <form class="formshort formshort--black">
                            <div class="formshort__tit">Возникли вопросы?</div>
                            <div class="formshort__subtit">Поможем найти нужное решение</div>
                            <label>
                                <input type="text" name="name" placeholder="Ваше имя">
                            </label>
                            <label>
                                <input type="tel" name="tel" placeholder="Ваш телефон">
                            </label>
                            <button class="btn btn--block">Перезвоните мне</button>
                        </form>
                        <!-- /formshort-->
                        <div class="sharebig sharebig--short">
                            <div class="sharebig__tit">Поделиться:</div>
                            <div class="sharebig__inn">
                                <a href="#" data-social="facebook" class="sharebig__item share_fb">
                                    <span class="sharebig__ico"></span>
                                    <span data-counter="facebook" class="sharebig__count"></span>
                                </a>
                                <a href="#" data-social="vkontakte" class="sharebig__item share_vk">
                                    <span class="sharebig__ico"></span>
                                    <span data-counter="vkontakte" class="sharebig__count"></span>
                                </a>
                                <a href="#" data-social="twitter" class="sharebig__item share_tw">
                                    <span class="sharebig__ico"></span>
                                    <span data-counter="twitter" class="sharebig__count">10</span>
                                </a>
                                <a href="#" class="sharebig__item share_tg">
                                    <span class="sharebig__ico"></span>
                                    <span class="sharebig__count">20</span>
                                </a>
                                <a href="#" data-social="odnoklassniki" class="sharebig__item share_ok">
                                    <span class="sharebig__ico"></span>
                                    <span data-counter="odnoklassniki" class="sharebig__count"></span>
                                </a>
                                <a href="#" data-social="googleplus" class="sharebig__item share_gp">
                                    <span class="sharebig__ico"></span>
                                    <span data-counter="googleplus" class="sharebig__count">10000</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="w_another">
        <div class="www">
            <div class="w_another__inn">
                <div class="another gs">
                    @foreach($last as $last_item)
                        <div class="another__item gs-col">
                            <div class="postcard">
                                <a href="#" class="postcard__pic">
                                <span class="postcard__picinn">
                                    @if($image = $last_item->thumb(2))
                                        <img data-src="{{ $image }}"
                                             src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                                             alt="{{ $last_item->name }}" class="b-lazy">
                                    @endif
                                </span>
                                </a>
                                <div class="postcard__body">
                                    <div class="postcard__tags tags">
                                        @foreach($last_item->tags as $tag)
                                            <div class="tags__tag">{{ $tag->tag }}</div>
                                        @endforeach
                                    </div>
                                    <div class="postcard__date">{{ $last_item->dateFormat('d F Y') }}</div>
                                    <a href="{{ $last_item->url }}" class="postcard__name">{{ $last_item->name }}</a>
                                    <div class="postcard__descr">{{ $last_item->announce }}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="w_another__more">
                    <div class="more">
                        <a href="{{ route('publications') }}">Другие материалы</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection