import { Fancybox } from '@fancyapps/ui';

export const closeBtn = `<svg width="27" height="27" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M21.094 5.906 5.906 21.094M21.094 21.094 5.906 5.906" stroke="#9E9E9E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
  </svg>`;

Fancybox.bind('[data-fancybox]', {
  // closeButton: 'outside',
});

export const showCallbackConfirm = () => {
  Fancybox.show([{ src: '#callback-confirm', type: 'inline' }], {
    mainClass: 'fancybox--custom',
    template: {
      closeButton: closeBtn
    }
  });
};

export const showMessageConfirm = () => {
  Fancybox.show([{ src: '#message-confirm', type: 'inline' }], {
    mainClass: 'fancybox--custom fancybox--confirm-message',
    template: {
      closeButton: closeBtn
    }
  });
};

// form modules './forms.js'
