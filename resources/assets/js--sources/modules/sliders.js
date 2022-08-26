import Swiper, { Pagination, EffectFade, Lazy } from 'swiper';

export const mainSlider = ({ slider, pagination }) => {
  new Swiper(slider, {
    modules: [Pagination, EffectFade, Lazy],
    fadeEffect: { crossFade: true },
    effect: 'fade',
    lazy: true,
    pagination: {
      el: pagination,
      clickable: true
    }
  });
};

mainSlider({
  slider: '[data-main-slider]',
  pagination: '.main-slider__pagination'
});
