<section id="catalog" class="catalog" js-module="catalog">
    <div class="catalog__title wow fadeInUp" data-wow-duration="0.5s"> {{ __('catalog.destinations') }}</div>
    <div class="catalog__filter">
        <div class="catalog__filter-title"> {{ __('catalog.filter.title') }}</div>
        <div class="catalog__filter-items" js-module="catalog-filter">
            <button class="button button--filter" data-code="group"
                    js-element="button"> {{ __('catalog.filter.group') }}</button>
            <button class="button button--filter" data-code="private"
                    js-element="button">{{ __('catalog.filter.private') }}</button>
        </div>
    </div>

    @include('component.partial.catalog-sections')

</section>
