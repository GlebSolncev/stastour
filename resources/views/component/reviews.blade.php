<section class="reviews">
    <div class="reviews__title"> {{__('reviews.title')}}
        <a href="#" js-module="discuss">{{__('reviews.action')}}</a></div>

    <div class="reviews__hint">{{__('reviews.hint')}}</div>
    <div class="reviews__rating">
        <span class="reviews__star"></span>
        <span class="reviews__star"></span>
        <span class="reviews__star"></span>
        <span class="reviews__star"></span>
        <span class="reviews__star"></span>
    </div>

    <div class="reviews__wrapper swiper-container" js-module="reviews">
        <div class="reviews__items swiper-wrapper">
            @foreach(__('reviews.items') as $slide)
                <div class="reviews__item swiper-slide">
                    <div class="reviews__text">
                        {{$slide['title']}}
                    </div>
                    <div class="reviews__author">{{$slide['author']}}</div>
                </div>
            @endforeach
        </div>
        <div class="reviews__pagination swiper-pagination"></div>
        <div class="swiper-button-prev" js-element="prev"></div>
        <div class="swiper-button-next" js-element="next"></div>
    </div>

</section>
