<footer class="footer lazy entered loaded" data-bg="/images/common/footer-bg.jpg" data-ll-status="loaded"
        style="background-image: url(&quot;/images/common/footer-bg.jpg&quot;);">
    <div class="container">
        <div class="footer__grid">
            <div class="footer__logo">
                <a href="{{ route('main') }}">
                    <span class="logo lazy entered loaded" data-bg="/images/common/logo.svg"
                          data-ll-status="loaded"
                          style="background-image: url(&quot;/images/common/logo.svg&quot;);"></span>
                </a>
            </div>
            <nav class="footer__nav">
                <ul class="list-reset">
                    @foreach($footer_menu as $item)
                        <li>
                            <a href="{{ $item->url }}" title="{{ $item->name }}">{{ $item->name }}</a>
                        </li>
                    @endforeach
                </ul>
            </nav>
            <div class="footer__contacts">
                <a class="phone" href="tel:{{ preg_replace('/[^\d]+/', '', Settings::get('footer_phone')) }}" title="Позвонить {{ Settings::get('footer_phone') }}">
                    <svg class="svg-sprite-icon icon-phone">
                        <use xlink:href="/images/sprite/symbol/sprite.svg#phone"></use>
                    </svg>
                    <span>{{ Settings::get('footer_phone') }}</span>
                </a>
                <div class="footer__blocks">
                    <a class="email" href="mailto:{{ Settings::get('footer_email') }}" title="Написать письмо">
                        <svg class="svg-sprite-icon icon-mail">
                            <use xlink:href="/images/sprite/symbol/sprite.svg#mail"></use>
                        </svg>
                        <span>{{ Settings::get('footer_email') }}</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="footer__copyrights">
            <div class="footer__copyright">© {{ Settings::get('footer_year') }} Все права защищены.</div>
            <a class="footer__policy" href="_ajax-policy.html" data-fancybox="" data-type="ajax">Политика
                конфиденциальности</a>
        </div>
    </div>
</footer>
