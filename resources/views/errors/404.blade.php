@extends('template')
@section('content')
    <section class="error-page">
        <div class="container error-page__container">
            <div class="error-page__label">Такой страницы не существует</div>
            <img class="error-page__picture lazy entered loaded" src="/images/common/404.svg" data-src="/images/common/404.svg" alt="404" width="855" height="253" data-ll-status="loaded">
            <div class="error-page__link">Вы можете
                <a href="{{ route('main') }}">вернуться на главную</a>
            </div>
        </div>
    </section>
@stop
