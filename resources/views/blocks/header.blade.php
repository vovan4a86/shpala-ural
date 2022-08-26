<header class="header {{ Request::routeIs('main') ? 'header--home' : 'lazy' }}" data-bg="{{ Request::routeIs('main') ? '' : '/images/common/header-bg@2x.jpg'}}">
    <div class="container header__container">
        <div class="header__top">
            <div class="header__logo">
                <a href="{{ route('main') }}">
                    <span class="logo lazy entered loaded" data-bg="/images/common/logo.svg"
                          data-ll-status="loaded"
                          style="background-image: url(&quot;/images/common/logo.svg&quot;);"></span>
                </a>
            </div>
            <div class="header__info">
                <nav class="header__nav nav" itemscope="" itemtype="https://schema.org/SiteNavigationElement"
                     aria-label="Меню">
                    <ul class="nav__list list-reset" itemprop="about" itemscope=""
                        itemtype="https://schema.org/ItemList">
                        @foreach($top_menu as $item)
                            <li class="nav__item" itemprop="itemListElement" itemscope="itemscope"
                                itemtype="https://schema.org/ItemList">
                                <a class="nav__link" href="{{ $item->url }}" title="{{ $item->name }}"
                                   itemprop="url">{{ $item->name }}</a>
                                <meta itemprop="name" content="{{ $item->name }}">
                            </li>
                        @endforeach
                    </ul>

                </nav>
                <div class="header__item">
                    <a class="email" href="mailto:{{ Settings::get('header_email') }}" title="Написать письмо">
                        <svg class="svg-sprite-icon icon-mail">
                            <use xlink:href="/images/sprite/symbol/sprite.svg#mail"></use>
                        </svg>
                        <span>{{ Settings::get('header_email') }}</span>
                    </a>
                </div>
                <div class="header__item">
                    <a class="phone" href="tel:{{ preg_replace('/[^\d]+/', '', Settings::get('header_phone')) }}" title="Позвонить {{ Settings::get('header_phone') }}">
                        <svg class="svg-sprite-icon icon-phone">
                            <use xlink:href="/images/sprite/symbol/sprite.svg#phone"></use>
                        </svg>
                        <span>{{ Settings::get('header_phone') }}</span>
                    </a>
                </div>
                <div class="header__hamburger">
                    <button class="hamburger hamburger--collapse" aria-label="Мобильное меню" data-open-overlay="">
								<span class="hamburger-box">
									<span class="hamburger-inner"></span>
								</span>
                    </button>
                </div>
            </div>
        </div>
        <div class="header__bottom">
            <div class="header__menu">
                <nav class="header__nav nav" itemscope="" itemtype="https://schema.org/SiteNavigationElement"
                     aria-label="Меню">
                    <ul class="nav__list list-reset" itemprop="about" itemscope=""
                        itemtype="https://schema.org/ItemList">
                        @foreach($main_menu as $item)

                            <li class="nav__item {{ $item->id != 5 ?: 'nav__item--accent' }}" itemprop="itemListElement" itemscope="itemscope"
                                itemtype="https://schema.org/ItemList">
                                <a class="nav__link" href="{{ $item->url }}" title="{{ $item->name }}" itemprop="url">{{ $item->name }}</a>
                                <meta itemprop="name" content="{{ $item->name }}">
                            </li>
                        @endforeach
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</header>
