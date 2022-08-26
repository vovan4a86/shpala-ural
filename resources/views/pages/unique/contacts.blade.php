@extends('inner')
@section('inner-page')
    @include('blocks.bread')
    <main class="lazy entered loaded" data-bg="/images/common/body-bg.png" data-ll-status="loaded" style="background-image: url(&quot;/images/common/body-bg.png&quot;);">
        <section class="section section--inner about-page">
            <div class="container">
                <div class="section__title">{{ $h1 }}</div>

                <div class="contacts-page__grid">
                    <div class="contacts-page__info">
                        <h2 class="section__subtitle">Доставка в любой регион России, страны СНГ, экспорт</h2>
                        <div class="contacts-page__data data-contacts">
                            <div class="data-contacts__row">
                                <div class="data-contacts__icon">
                                    <svg width="29" height="29" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 4a3 3 0 0 1 3-3h4.919a1.5 1.5 0 0 1 1.423 1.026l2.247 6.74a1.5 1.5 0 0 1-.753 1.816l-3.385 1.693a16.563 16.563 0 0 0 8.274 8.274l1.693-3.385a1.5 1.5 0 0 1 1.816-.753l6.74 2.247A1.5 1.5 0 0 1 28 20.081V25a3 3 0 0 1-3 3h-1.5C11.074 28 1 17.926 1 5.5V4Z" fill="#fff" stroke="#fff" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                </div>
                                <div class="data-contacts__links">
                                    <a class="data-contacts__link" href="tel:{{ Settings::get('header_phone') }}">{{ Settings::get('header_phone') }}</a>
                                    <button class="data-contacts__button btn-reset" type="button" data-popup="" data-src="#callback">Перезвоните мне</button>
                                </div>
                            </div>
                            <div class="data-contacts__row">
                                <div class="data-contacts__icon">
                                    <svg width="29" height="24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 4.143C1 2.407 2.343 1 4 1h21c1.657 0 3 1.407 3 3.143v15.714C28 21.593 26.657 23 25 23H4c-1.657 0-3-1.407-3-3.143V4.143Z" fill="#fff"></path>
                                        <path d="M1.573 4.894a1 1 0 0 0-1.146 1.64l1.146-1.64Zm11.263 9.087-.573.82.573-.82Zm3.328 0-.573-.82.573.82Zm12.409-7.447a1 1 0 1 0-1.146-1.64l1.146 1.64ZM4 2h21V0H4v2Zm23 2.143v15.714h2V4.143h-2ZM25 22H4v2h21v-2ZM2 19.857V4.143H0v15.714h2ZM4 22c-1.061 0-2-.915-2-2.143H0C0 22.101 1.748 24 4 24v-2Zm23-2.143C27 21.085 26.061 22 25 22v2c2.253 0 4-1.9 4-4.143h-2ZM25 2c1.061 0 2 .915 2 2.143h2C29 1.899 27.253 0 25 0v2ZM4 0C1.748 0 0 1.9 0 4.143h2C2 2.915 2.939 2 4 2V0ZM.427 6.534 12.263 14.8l1.146-1.64L1.572 4.895.427 6.534Zm16.31 8.266 11.836-8.266-1.146-1.64-11.835 8.267 1.145 1.64Zm-4.474 0a3.887 3.887 0 0 0 4.474 0l-1.145-1.64a1.887 1.887 0 0 1-2.184 0l-1.145 1.64Z" fill="#e08735"></path>
                                    </svg>
                                </div>
                                <div class="data-contacts__links">
                                    <a class="data-contacts__link" href="mailto:{{ Settings::get('header_email') }}">{{ Settings::get('header_email') }}</a>
                                    <button class="data-contacts__button btn-reset" type="button" data-popup="" data-src="#message">Напишите нам</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form class="contacts-page__form form" action="{{ route('ajax.callback') }}"
                          onsubmit="sendCallback(this, event)">
                        <div class="section__subtitle">Форма обратной связи</div>
                        <div class="form__grid">
                            <label class="form__label">Ваше имя
                                <span>*</span>
                                <input class="form__input" type="text" name="name" placeholder="Введите имя" autocomplete="off" required="">
                            </label>
                            <label class="form__label">Номер телефона
                                <span>*</span>
                                <input class="form__input" type="tel" name="phone" placeholder="+7 (___) ___-__-__" autocomplete="off" required="" inputmode="text">
                            </label>
                        </div>
                        <div class="form__action form__action--row">
                            <button class="btn">
                                <span>Оставить заявку</span>
                            </button>
                            <label class="checkbox">
                                <input class="checkbox__input" type="checkbox" checked="" required="">
                                <span class="checkbox__box"></span>
                                <span class="checkbox__label">Согласие на
										<a href="_ajax-policy.html" data-fancybox="" data-type="ajax">обработку персональных данных</a>
									</span>
                            </label>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>
@stop
