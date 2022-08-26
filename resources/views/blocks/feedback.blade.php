<section class="section contacts lazy entered loaded"
         data-bg="/images/common/contacts.jpg" data-ll-status="loaded"
         style="background-image: url(&quot;/images/common/contacts.jpg&quot;);">
    <div class="container">
        <h2 class="section__title">Свяжитесь с нами!</h2>
        <form class="contacts__form form" action="{{ route('ajax.feedback') }}"
              onsubmit="sendFeedback(this, event)">
            <div class="form__container">
                <div class="form__row">
                    <label class="form__label">Ваше имя
                        <span>*</span>
                        <input class="form__input" type="text" name="name" placeholder="Введите имя" autocomplete="off" required="">
                    </label>
                </div>
                <div class="form__grid">
                    <label class="form__label">Номер телефона
                        <span>*</span>
                        <input class="form__input" type="tel" name="phone" placeholder="+7 (___) ___-__-__" autocomplete="off" required="" inputmode="text">
                    </label>
                    <label class="form__label">E-mail
                        <input class="form__input" type="text" name="email" placeholder="Введите E-mail" autocomplete="off" inputmode="email">
                    </label>
                </div>
                <div class="form__row">
                    <label class="form__label">Сообщение
                        <textarea class="form__text" rows="4" name="text" placeholder="Напишите сообщение в свободной форме"></textarea>
                    </label>
                </div>
            </div>
            <div class="form__requires">
                <label class="checkbox">
                    <input class="checkbox__input" type="checkbox" checked="" required="">
                    <span class="checkbox__box"></span>
                    <span class="checkbox__label">Согласие на
								<a href="_ajax-policy.html" data-fancybox="" data-type="ajax">обработку персональных данных</a>
							</span>
                </label>
                <div class="form__require">
                    <span>*</span>&nbsp;Обязательные поля</div>
            </div>
            <div class="form__action">
                <button class="btn">
                    <span>Оставить заявку</span>
                </button>
            </div>
        </form>
    </div>
</section>
