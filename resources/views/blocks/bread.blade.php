@if(isset($bread) && count($bread))
    <nav class="breadcrumb">
        <div class="container">
            <ul class="breadcrumb__list list-reset" itemscope="" itemtype="https://schema.org/BreadcrumbList">
                <li class="breadcrumb__item" itemprop="itemListElement" itemscope=""
                    itemtype="https://schema.org/ListItem">
                    <a class="breadcrumb__link" href="{{ url('/') }}" itemprop="item">
                        <span itemprop="name">Главная</span>
                        <meta itemprop="position" content="1">
                    </a>
                </li>
                @php
                  $position = 1;
                @endphp

                @foreach($bread as $item)
                    <li class="breadcrumb__item" itemprop="itemListElement" itemscope=""
                        itemtype="https://schema.org/ListItem">
                        <a class="breadcrumb__link" href="{{ $item['url'] }}" itemprop="item">
                            <span itemprop="name">{{ $item['name'] }}</span>
                            <meta itemprop="position" content="{{++$position}}">
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </nav>
@endif
