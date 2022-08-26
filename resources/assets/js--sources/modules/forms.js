import { Fancybox } from '@fancyapps/ui';
import $ from 'jquery';

import { closeBtn, showCallbackConfirm, showMessageConfirm } from './popups';

Fancybox.bind('[data-popup]', {
  mainClass: 'fancybox--custom',
  template: {
    closeButton: closeBtn
  },
  on: {
    reveal: (e, trigger) => {
      const form = trigger.$content.querySelector('form');
      const target = trigger.src;

      form &&
        form.addEventListener('submit', function (e) {
          e.preventDefault();

          /*
           *  your code
           * */

          // close popup
          Fancybox.close();

          // show confirm dialogs by condition
          switch (target) {
            case '#callback': {
              showCallbackConfirm();
              break;
            }
            case '#message': {
              showMessageConfirm();
              break;
            }
          }
        });
    }
  }
});
