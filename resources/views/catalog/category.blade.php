@extends('inner')
@section('inner-page')
    @include('blocks.bread')

    <section class="section section--inner content">
        <div class="container">
            <div class="content-main">
                <div class="content-main__picture lazy entered loaded"
                     data-bg="{{ \Fanky\Admin\Models\Catalog::UPLOAD_URL . $category->image }}" data-ll-status="loaded"
                     style="background-image: url({{ \Fanky\Admin\Models\Catalog::UPLOAD_URL . $category->image }});"></div>
                <div class="content-main__description">
                    <h1 class="content-main__title">{{ $category->getH1() }}</h1>
                    <div class="content-main__action">
                        <button class="btn" type="button" data-popup="data-popup" data-src="#message" aria-label="Оставить заявку">
                            <span>Оставить заявку</span>
                        </button>
                    </div>
                </div>
            </div>

            <article class="content__head text-content">
                {!! $category->text_prev !!}
            </article>

        </div>
    </section>

    @if(count($features) && $feat_before_slider)
        @include('blocks.features')
    @endif

    @if(count($images))
        @include('blocks.slider')
    @endif

    <section class="section section--inner">
        @if(count($features) && !$feat_before_slider)
            @include('blocks.features')
        @endif
        <div class="content__head">
            <div class="container text-content">
                <h2>{{ $category->price_header }}</h2>
                <div class="hscroll"><table>
                        <thead>
                        <tr>
                            <th>Наименование товара</th>
                            <th>Норма загрузки полувагона</th>
                            <th>Франко-вагон за 1 шт.</th>
                            <th>Цена на складе за 1 шт.</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($gosts_array as $name => $prods)
                            <tr>
                                <td colspan="4" style="text-align: center; font-weight: bold">{{ $name }}</td>
                            </tr>
                                @foreach($prods as $prod)
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
                        @endforeach
                        </tbody>
                    </table></div>
                <p>
                    <strong>Все цены указаны с НДС без учета стоимости доставки авто и ж.д. транспортом.</strong>
                </p>
            </div>
            <div class="container">
                @include('blocks.questions')
                <article class="text-content">
                    {!! $category->text_after !!}
                </article>
            </div>
        </div>
    </section>

    @include('blocks.feedback')
@stop
