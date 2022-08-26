import { getScrollbarWidth } from '../functions/scrollBarWidth';

export const burger = () => {
  const burger = document.querySelector('[data-open-overlay]');
  const body = document.body;

  burger && burger.addEventListener('click', openOverlay);

  function openOverlay() {
    const overlay = document.querySelector('.overlay');
    overlay.classList.add('is-active');

    setNoScroll();
    closeOverlay(overlay);
  }

  function closeOverlay(overlay) {
    const closeTrigger = overlay.querySelector('[data-overlay-close]');
    closeTrigger.addEventListener('click', () => {
      overlay.classList.remove('is-active');

      removeNoScroll();
    });
  }

  function setNoScroll() {
    body.classList.add('no-scroll');
    body.style.marginRight = getScrollbarWidth() + 'px';
  }

  function removeNoScroll() {
    body.classList.remove('no-scroll');
    body.style.removeProperty('margin-right');
  }
};

burger();
