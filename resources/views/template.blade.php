<!DOCTYPE html>
<html lang="ru">
@include('blocks.head')
<body class="{{ (Request::url() == '/')? 'homepage':'innpage' }}">
    <div class="preloader">
        <div class="preloader__loader">
            <svg width="57" height="57" xmlns="http://www.w3.org/2000/svg" stroke="#fff">
                <g transform="translate(1 1)" stroke-width="2" fill="none" fill-rule="evenodd">
                    <circle cx="5" cy="50" r="5">
                        <animate attributeName="cy" begin="0s" dur="2.2s" values="50;5;50;50" calcMode="linear" repeatCount="indefinite" />
                        <animate attributeName="cx" begin="0s" dur="2.2s" values="5;27;49;5" calcMode="linear" repeatCount="indefinite" />
                    </circle>
                    <circle cx="27" cy="5" r="5">
                        <animate attributeName="cy" begin="0s" dur="2.2s" from="5" to="5" values="5;50;50;5" calcMode="linear" repeatCount="indefinite" />
                        <animate attributeName="cx" begin="0s" dur="2.2s" from="27" to="27" values="27;49;5;27" calcMode="linear" repeatCount="indefinite" />
                    </circle>
                    <circle cx="49" cy="50" r="5">
                        <animate attributeName="cy" begin="0s" dur="2.2s" values="50;50;5;50" calcMode="linear" repeatCount="indefinite" />
                        <animate attributeName="cx" from="49" to="49" begin="0s" dur="2.2s" values="49;5;27;49" calcMode="linear" repeatCount="indefinite" />
                    </circle>
                </g>
            </svg>
        </div>
    </div>
    <div class="scrolltop" aria-label="В начало страницы" tabindex="1">
        <svg class="svg-sprite-icon icon-up">
            <use xlink:href="/images/sprite/symbol/sprite.svg#up"></use>
        </svg>
    </div>

    @include('blocks.header')

    <div class="overlay">
        <div class="container overlay__container">
            <div class="overlay__close" data-overlay-close=""></div>
            <div class="overlay__logo">
                <span class="logo lazy" data-bg="/images/common/logo.svg"></span>
            </div>
            <nav class="overlay__nav">
                <ul class="list-reset">
                    @foreach($mob_menu as $elem)
                    <li>
                        <a href="{{ $elem['link'] }}">{{ $elem['name'] }}</a>
                    </li>
                    @endforeach
                </ul>
            </nav>
            <div class="overlay__contacts">
                <div class="overlay__phone">
                    <a class="phone" href="tel:{{ preg_replace('/[^\d]+/', '', Settings::get('header_phone')) }}" title="Позвонить {{ Settings::get('header_phone') }}">
                        <svg class="svg-sprite-icon icon-phone">
                            <use xlink:href="/images/sprite/symbol/sprite.svg#phone"></use>
                        </svg>
                        <span>{{ Settings::get('header_phone') }}</span>
                    </a>
                </div>
                <div class="overlay__email">
                    <a class="email" href="mailto:{{ Settings::get('header_email') }}" title="Написать письмо">
                        <svg class="svg-sprite-icon icon-mail">
                            <use xlink:href="/images/sprite/symbol/sprite.svg#mail"></use>
                        </svg>
                        <span>{{ Settings::get('header_email') }}</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    @yield('content')

    @if(Request::routeIs('main'))
        @include('blocks.feedback')
    @endif

    <!-- _footer-->
    @include('blocks.footer')

    <!-- _cookies-->
    @include('blocks.cookies')

    <!-- _popups-->
    @include('blocks.popups')

    {!! Settings::get('schema.org') !!}
</body>
</html>
