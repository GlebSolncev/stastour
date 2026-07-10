@if (isset($catalog->group))
    <div class="catalog-section wow fadeInUp" js-element="section" js-module="catalog-section" data-code="group">
        <div class="catalog-section__title">{{__('catalog.group.title')}}</div>
        <div class="catalog-section__description">{{__('catalog.group.description')}}</div>
        <div class="catalog-section__container">
            <div class="catalog-section__items grid" js-element="grid">
                @include('component.partial.catalog-section', ['items' => $catalog->group])
            </div>
        </div>
    </div>
@endif

@if (isset($catalog->private))
    <div class="catalog-section wow fadeInUp" js-element="section" js-module="catalog-section" data-code="private">
        <div class="catalog-section__title">{{__('catalog.private.title')}}</div>
        <div class="catalog-section__description">{{__('catalog.private.description')}}</div>
        <div class="catalog-section__container">
            <div class="catalog-section__items grid" js-element="grid">
                @include('component.partial.catalog-section', ['items' => $catalog->private])
            </div>
        </div>
    </div>
@endif
