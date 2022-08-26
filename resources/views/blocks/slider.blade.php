<section class="photo-slider">
    <div class="container photo-slider__container">
        <div class="photo-slider__nav slider-nav">
            <div class="slider-nav__icon slider-nav__prev swiper-button-disabled" data-slider-prev="">
                <svg class="svg-sprite-icon icon-prev">
                    <use xlink:href="/images/sprite/symbol/sprite.svg#prev"></use>
                </svg>
            </div>
            <div class="slider-nav__icon slider-nav__next" data-slider-next="">
                <svg class="svg-sprite-icon icon-next">
                    <use xlink:href="/images/sprite/symbol/sprite.svg#next"></use>
                </svg>
            </div>
        </div>
        <div class="photo-slider__content swiper swiper-initialized swiper-horizontal swiper-pointer-events swiper-backface-hidden" data-photo-slider="">
            <div class="photo-slider__wrapper swiper-wrapper" style="transform: translate3d(0px, 0px, 0px);">
                <!-- slide-->
                @foreach($images as $image)
                    <div class="photo-slider__item swiper-slide swiper-slide-active" style="width: 433.333px; margin-right: 30px;">
                        <a href="{{ $image->image_src }}" data-fancybox="gallery" data-caption="{{ $category->name }}">
                            <img class="lazy entered loaded" src="{{ $image->thumb(2) }}" data-src="{{ $image->image_src }}" alt="{{ $category->name }}" width="420" height="395" data-ll-status="loaded">
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
