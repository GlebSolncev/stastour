@php
    $adventures = (object) [
        'Lorem ipsum dolor sit amet, consectetur adipiscing elit',
        'Lorem ipsum dolor sit amet, consectetur adipiscing elit',
        'Lorem ipsum dolor sit amet, consectetur adipiscing elit',
        'Lorem ipsum dolor sit amet, consectetur adipiscing elit',
    ];
@endphp

<section class="about">
    <div class="about__title wow fadeInUp" data-wow-duration="0.5s"> {{__('about.title')}}</div>
    <div class="about__image">
        <img class="about__image--main" src="{{  null  }}" js-module="parallax" data-orientation="left">
        <img class="about__image--mark" src="/asset/images/about-mark.png">
    </div>
    <div class="about__content">
        <p class="about__content--title wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.5s"> {{__('about.hello')}}</p>
        <span class="about__content--description wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="1s"> {{__('about.text')}}</span>
    </div>
    <div class="about__adventures wow fadeInUp" data-wow-duration="0.5s">
        <div class="about__adventures__title"> {!! __('about.adventures.title') !!} </div>

        <div class="about__adventures__list">
            @foreach(__('about.adventures.list')  as $i => $adventure)
                <div class="about__adventures__item wow bounceInUp" data-wow-duration="0.5s" data-wow-delay="{{$i*0.5}}s">
                    {{$adventure}}
                </div>
            @endforeach
        </div>
    </div>
</section>
