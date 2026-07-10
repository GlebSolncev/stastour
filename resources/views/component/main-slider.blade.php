<section class="main-slider swiper-container" js-module="main-slider" id="main-slider">
    <div class="swiper-wrapper">

        @foreach($slides as $slide)
            <div class="main-slider__item swiper-slide">
                <div class="main-slider__background">
                    <img src="{{$slide->image->src}}" js-module="parallax">
                </div>
                <div class="main-slider__foreground main-slider__foreground--{{$slide->align ?: 'center'}}">
                    <div class="main-slider__content">
                        <p class="main-slider__title"> {{$slide->title}}</p>
                        @if ($slide->description)
                            <p class="main-slider__description">{!! $slide->description !!}</p>
                        @endif

                        @if ($slide->button)
                            <a class="button" href="{{$slide->button->href}}">{{$slide->button->title}}</a>
                        @endif

                    </div>
                </div>
            </div>
        @endforeach

    </div>
    <div class="main-slider__pagination swiper-pagination"></div>
</section>
