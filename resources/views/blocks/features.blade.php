<section class="section section--inner">
    <div class="features-block">
        <div class="container features-block__container">
            <div class="features-block__content">
                <h2 class="features-block__title">{!! $features_header ?? '' !!}</h2>
                <ul class="features-block__list list-reset">
                    @foreach($features as $feat)
                        <li class="features-block__item item-features">
                        <span class="item-features__icon lazy entered loaded"
                              data-bg="{{ \Fanky\Admin\Models\CatalogFeature::UPLOAD_URL . $feat->image }}"
                              data-ll-status="loaded"
                              style="background-image: url({{ \Fanky\Admin\Models\CatalogFeature::UPLOAD_URL . $feat->image }});"></span>
                            <span class="item-features__label">{{ $feat->text }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>

