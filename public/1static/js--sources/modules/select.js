import { formatPrice } from '../functions/formatPrice';

export const initSelects = ({ select: selector }) => {
  const selectBlock = document.querySelectorAll(selector);

  selectBlock &&
    selectBlock.forEach(block => {
      const select = block.querySelector('select');

      select.addEventListener('change', function () {
        const option = select.options[select.selectedIndex];
        const priceValue = parseInt(option.dataset.price) || '';
        const storeValue = parseInt(option.dataset.store) || '';

        const prices = block.querySelector('[data-prices]');

        if (prices) {
          const outputPrice = prices.querySelector('[data-price]');
          const outputStore = prices.querySelector('[data-store]');

          if (priceValue) outputPrice.textContent = formatPrice(priceValue);
          if (storeValue) outputStore.textContent = formatPrice(storeValue);
        }
      });
    });
};
