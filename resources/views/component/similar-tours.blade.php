<section class="similar-tours">
    <p class="similar-tours__head">Other destinations</p>

    <div class="similar-tours__container swiper-container" js-module="similar-tours">
        <div class="similar-tours__wrapper swiper-wrapper grid">
            @foreach($similar as $i => $item)
                @php
                    $row_index = floor($i / 3);
                @endphp
                @include('component.partial.catalog-item', [
                    'item' => $item,
                    'row' => $row_index,
                    'js_element' => 'item',
                    'grid' => 'swiper-slide similar-tours__item col-24 col-md-8'
                ])
            @endforeach

        </div>
        <div class="swiper-button-prev" js-element="prev"></div>
        <div class="swiper-button-next" js-element="next"></div>

        <a class="similar-tours__expand" js-element="more"></a>
    </div>

</section>
