import $ from 'jquery';

const preloader = () => {
  $('.preloader').fadeOut();
  $('body').removeClass('no-scroll');
};

const utils = () => {
  const blocks = 'picture, img, video';

  $(blocks).on('dragstart', () => false);
  $(blocks).on('contextmenu', () => false);
};

preloader();
utils();
