@extends('template')
@section('content')
    <main data-bg="">
        <section class="main-slider swiper swiper-fade swiper-initialized swiper-horizontal swiper-pointer-events swiper-watch-progress swiper-backface-hidden" data-main-slider="">
            <div class="main-slider__wrapper swiper-wrapper">
                <!-- slide-->

                @if(Settings::get('slider'))
                    @foreach($slides = Settings::get('slider') as $slide)
                        <div class="main-slider__slide swiper-slide swiper-slide-visible swiper-slide-active" style="width: 1841px; opacity: 1; transform: translate3d(0px, 0px, 0px);">
                    <div class="main-slider__bg">
                        <picture>
                            <img class="main-slider__picture swiper-lazy swiper-lazy-loaded" src="{{ Settings::fileSrc($slide['slider_image']) }}" alt="picture">
                        </picture>
                    </div>
                    <div class="container main-slider__container">
                        <div class="main-slider__content">
                            <h2 class="main-slider__title">{{ $slide['slider_title'] }}</h2>
                            <p class="main-slider__text">{{ $slide['slider_text'] }}</p>
                            <div class="main-slider__action">
                                <a class="btn btn--iconed" href="#catalog-list">
                                    <span>Подробнее</span>
                                    <svg class="svg-sprite-icon icon-arrow">
                                        <use xlink:href="images/sprite/symbol/sprite.svg#arrow"></use>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <div class="main-slider__pagination swiper-pagination-clickable swiper-pagination-bullets swiper-pagination-horizontal"><span class="swiper-pagination-bullet swiper-pagination-bullet-active"></span><span class="swiper-pagination-bullet"></span><span class="swiper-pagination-bullet"></span></div>
                    </div>
                </div>
                    @endforeach
                @endif
            </div>
        </section>
        <section class="section catalog-list" id="catalog-list">
            <div class="container">
                <h2 class="section__title">Основная продукция</h2>
                <div class="catalog-list__item">
                    <div class="catalog-list__grid">
                        <div class="catalog-list__content">
                            <h3 class="section__subtitle">{{ Settings::get('sh_title') ?? '' }}</h3>
                            <ul class="catalog-list__order">
                                @foreach(Settings::get('sh_features') as $feat)
                                    <li>{{ $feat }}</li>
                                @endforeach
                            </ul>
                            <div class="catalog-list__select">
                                <select class="select" autocomplete="off">
                                    <option disabled="">Выберите наименование</option>
                                    @foreach($shpalas as $shpala)
                                        <option data-price="{{ $shpala->price }}" data-store="{{ $shpala->price_store }}" value="a{{$loop->iteration}}">{{ $shpala->name }}</option>
                                    @endforeach
                                </select>
                                <div class="catalog-list__prices prices" data-prices="">
                                    <div class="prices__row">
                                        <div class="prices__item">
                                            <div class="prices__label">Франко-вагон</div>
                                            <div class="prices__value">
                                                <span data-price="">{{ number_format($shpalas[0]->price, 0, ',', ' ') }}</span>&nbsp;₽/ шт.</div>
                                        </div>
                                        <div class="prices__item">
                                            <div class="prices__label">Склад</div>
                                            <div class="prices__value">
                                                <span data-store="">{{ number_format($shpalas[0]->price_store, 0, ',', ' ') }}</span>&nbsp;₽/ шт.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="catalog-list__action">
                                <a class="btn btn--iconed" href="{{ $shpala_url }}">
                                    <span>Подробнее</span>
                                    <svg class="svg-sprite-icon icon-arrow">
                                        <use xlink:href="images/sprite/symbol/sprite.svg#arrow"></use>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <div class="catalog-list__bg lazy entered loaded" data-bg="{{ Settings::fileSrc(Settings::get('sh_image')) }}"
                             data-ll-status="loaded" style="background-image: url({{ Settings::fileSrc(Settings::get('sh_image')) }});"></div>
                    </div>
                </div>
                <div class="catalog-list__item">
                    <div class="catalog-list__grid">
                        <div class="catalog-list__bg lazy entered loaded" data-bg="{{ Settings::fileSrc(Settings::get('op_image')) }}"
                             data-ll-status="loaded" style="background-image: url({{ Settings::fileSrc(Settings::get('op_image')) }});"></div>
                        <div class="catalog-list__content">
                            <h3 class="section__subtitle">{{ Settings::get('op_title') ?? '' }}</h3>
                            <ul class="catalog-list__order">
                                @foreach(Settings::get('op_features') as $feat)
                                    <li>{{ $feat }}</li>
                                @endforeach
                            </ul>
                            <div class="catalog-list__select">
                                <select class="select" autocomplete="off">
                                    <option disabled="">Выберите наименование</option>
                                    @foreach($oporas as $opora)
                                        <option data-price="{{ $opora->price }}" data-store="{{ $opora->price_store }}" value="o{{$loop->iteration}}">{{ $opora->name }}</option>
                                    @endforeach
                                </select>
                                <div class="catalog-list__prices prices" data-prices="">
                                    <div class="prices__row">
                                        <div class="prices__item">
                                            <div class="prices__label">Франко-вагон</div>
                                            <div class="prices__value">
                                                <span data-price="">{{ number_format($oporas[0]->price, 0, ',', ' ') }}</span>&nbsp;₽/ шт.</div>
                                        </div>
                                        <div class="prices__item">
                                            <div class="prices__label">Склад</div>
                                            <div class="prices__value">
                                                <span data-store="">{{ number_format($oporas[0]->price_store, 0, ',', ' ') }}</span>&nbsp;₽/ шт.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="catalog-list__action">
                                <a class="btn btn--iconed" href="{{ $opora_url }}">
                                    <span>Подробнее</span>
                                    <svg class="svg-sprite-icon icon-arrow">
                                        <use xlink:href="images/sprite/symbol/sprite.svg#arrow"></use>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section about">
            <div class="container">
                <div class="about__grid">
                    <div class="about__content">
                        <h2 class="section__title">{{ Settings::get('ur_title') ?? '' }}</h2>
                        <div class="about__subtitle">{{ Settings::get('ur_subtitle') ?? '' }}</div>
                        <div class="about__text">{{ Settings::get('ur_text') ?? '' }}</div>
                    </div>
                    <div class="about__bg lazy entered loaded" data-bg="{{ Settings::fileSrc(Settings::get('ur_image')) }}"
                         data-ll-status="loaded" style="background-image: url({{ Settings::fileSrc(Settings::get('ur_image')) }});"></div>
                </div>
                @if(Settings::get('ur_features'))
                    <div class="about__features">
                        <div class="features">
                            @foreach(Settings::get('ur_features') as $feat)
                                <div class="features__item">
                                <div class="features__icon">
                                    <img class="lazy entered loaded" data-src="/images/common/ico_anniversary.svg"
                                         src="{{ Settings::fileSrc($feat['ur_img']) }}" alt="alt" data-ll-status="loaded">
                                </div>
                                <div class="features__label">{!! $feat['ur_text'] !!}</div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </section>
    </main>
@stop
