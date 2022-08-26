@extends('inner')
@section('inner-page')
    @include('blocks.bread')
    <main class="lazy entered loaded" data-bg="/images/common/body-bg.png"
          data-ll-status="loaded" style="background-image: url(&quot;/images/common/body-bg.png&quot;);">
        <section class="section section--inner about-page">
            <div class="container">
                <div class="section__title">{{ $h1 }}</div>

                {!! $text !!}

            </div>
        </section>
    </main>
@stop
