<div class="popup" id="callback" style="display: none">
    <div class="popup__title">Оставьте контактные данные</div>
    <div class="popup__description">В течении рабочего дня мы свяжемся с Вами</div>
    <form class="popup__form form" action="{{ route('ajax.callback') }}"
          onsubmit="sendCallback(this, event)">
        <div class="popup__fields">
            <input class="form__input" type="text" name="name" placeholder="Как вас зовут?" autocomplete="off" required="">
            <input class="form__input" type="tel" name="phone" placeholder="+7 (___) ___-__-__" autocomplete="off" required="" inputmode="text">
        </div>
        <div class="popup__policy">Оставляя заявку вы соглашаетесь с
            <a href="_ajax-policy.html" data-fancybox="" data-type="ajax">правилами обработки персональных данных</a>
        </div>
        <div class="popup__submit">
            <button class="btn">
                <span>Отправить</span>
            </button>
        </div>
    </form>
</div>

<div class="popup" id="callback-confirm" style="display: none">
    <div class="popup__title">Оставьте контактные данные</div>
    <div class="popup__description">В течении рабочего дня мы свяжемся с Вами</div>
    <div class="popup__confirm">
        <span>Спасибо! Данные успешно отправлены.</span>
    </div>
</div>

<div class="popup" id="message" style="display: none">
    <div class="popup__title">Что вас интересует?</div>
    <div class="popup__description">В течении рабочего дня мы ответим Вам</div>
    <form class="popup__form form" action="{{ route('ajax.writeback') }}"
          onsubmit="sendCallback(this, event)">
        <div class="popup__fields">
            <input class="form__input" type="text" name="name" placeholder="Как вас зовут?" autocomplete="off" required="">
            <input class="form__input" type="text" name="email" placeholder="Введите E-mail" autocomplete="off" required="" inputmode="email">
            <textarea class="form__text" rows="4" name="text" placeholder="Напишите сообщение в свободной форме" required=""></textarea>
        </div>
        <div class="popup__policy">Отправляя сообщение вы соглашаетесь с
            <a href="_ajax-policy.html" data-fancybox="" data-type="ajax">правилами обработки персональных данных</a>
        </div>
        <div class="popup__submit">
            <button class="btn">
                <span>Отправить</span>
            </button>
        </div>
    </form>
</div>

<div class="popup" id="message-confirm" style="display: none">
    <div class="popup__message message-popup">
        <div class="message-popup__icon">
            <svg width="60" height="60" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="30" cy="30" r="30" fill="#62C584"></circle>
                <path d="M41 23 27 37l-7-7" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
        </div>
        <div class="message-popup__label">Ваша заявка успешно отправлена.
            <br>Наш менеджер свяжется с Вами в близжайшее время</div>
    </div>
</div>
