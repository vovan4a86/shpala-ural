@extends('inner')
@section('inner-page')
    @include('blocks.bread')
    <main class="lazy entered loaded" data-bg="/images/common/body-bg.png"
          data-ll-status="loaded" style="background-image: url(&quot;/images/common/body-bg.png&quot;);">
        <section class="section section--inner text-content">
            <div class="container">
                <h1>{{ $h1 }}</h1>

                {!! $text !!}

            </div>
        </section>
    </main>
    @include('blocks.feedback')
@stop
