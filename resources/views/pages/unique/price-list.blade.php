@extends('inner')
@section('inner-page')
    @include('blocks.bread')
    <main class="lazy entered loaded"
          data-bg="/images/common/body-bg.png" data-ll-status="loaded"
          style="background-image: url(&quot;/images/common/body-bg.png&quot;);">
        <section class="section section--inner text-content">
            <div class="container">
                <h1 class="section__title">Прайс-лист</h1>
                @if($prices)
                    @foreach($prices as $cat_name => $gosts)
                        <div class="text-content__table">
                            <h3>{{ $cat_name }}</h3>
                            <div class="hscroll">
                                @foreach($gosts as $gost_name => $gost_products)
                                    <table>
                                        <thead>
                                        <tr>
                                            <th>Наименование товара</th>
                                            <th>Норма загрузки полувагона</th>
                                            <th>Франко-вагон за 1 шт.</th>
                                            <th>Цена на складе за 1 шт.</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td colspan="4" style="text-align: center; font-weight: bold">{{ $gost_name }}</td>
                                        </tr>
                                        @foreach($gost_products as $prod)
                                            <tr>
                                                <td>{{ $prod->name }}</td>

                                                @if($prod->norma)<td>{{ $prod->norma }}</td>
                                                @else <td></td>
                                                @endif

                                                @if($prod->price)<td>{{ $prod->price }} ₽</td>
                                                @else <td></td>
                                                @endif

                                                @if($prod->price_store)<td>{{ $prod->price_store ?? '' }} ₽</td>
                                                @else <td></td>
                                                @endif
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                @endif
                <p>
                    <strong>Все цены указаны с НДС без учета стоимости доставки авто и ж.д. транспортом.</strong>
                </p>
            </div>
        </section>
    </main>
    @include('blocks.feedback')
@stop
