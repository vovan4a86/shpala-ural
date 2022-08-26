import 'focus-visible';
import './modules/modules';

import { initSelects } from './modules/select';
initSelects({ select: '.catalog-list__select' });

import { maskedInputs } from './modules/inputMask';
maskedInputs({
  phoneSelector: 'input[name="phone"]',
  emailSelector: 'input[name="email"]'
});
