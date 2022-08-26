import $ from 'jquery';

const setActiveNav = () => {
  $('.nav__link')
    .filter('[href="' + window.location + '"]')
    .addClass('is-active');
};

setActiveNav();
