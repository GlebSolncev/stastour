@php
    $calendar = $tour->checkout->calendar;

    if($calendar) {
        $calendar_min = array_keys($calendar)[0];

        $timeslots = $calendar[$calendar_min];

        $checked_timeslot_id = array_keys($timeslots)[0];
        $checked_timeslot = $timeslots[$checked_timeslot_id];
    }

@endphp

<section class="tour">

    <div class="tour__image">
        <img src="{{$tour->detail_image->src}}" js-module="parallax">
    </div>

    <div class="tour__grid">
        <div class="tour__article">
            <span class="tour__article-type tour__article-type--{{$tour->image->type}}"></span>

            <h1 class="tour__article-title">{{$tour->title}}</h1>
            <p class="tour__article-subtitle">{{$tour->description}}</p>
            <div class="tour__article-properties">
                @foreach($tour?->properties as $property)
                    @if(in_array($property->type, ['price', 'duration', 'count', 'location']))
                        <span
                            class="tour__article-property tour__article-property--{{$property?->type ?: 'none'}}">{{isset($property?->label) ? $property?->label : ''}}</span>
                    @endif
                @endforeach
            </div>

            <div class="tour__article-description"> {!! $tour->detail_text !!}</div>

        </div>
        <div class="tour__gallery swiper-container" js-module="tour-gallery">
            <div class="swiper-wrapper">
                @foreach($tour?->gallery as $image)
                    <div class="tour__gallery-item swiper-slide">
                        <img src="{{$image->src}}">
                    </div>
                @endforeach
            </div>
            <div class="tour__gallery-pagination swiper-pagination"></div>
            <div class="swiper-button-prev" js-element="prev"></div>
            <div class="swiper-button-next" js-element="next"></div>
        </div>

        @if($tour->map)
            <div class="tour__map" js-module="tour-map" data-kml="{{$tour->map}}"></div>
        @endif

        <div class="tour__calendar--wrapper" {{$calendar ? 'js-module=tour-checkout' : ''}} data-price="{{$tour->price}}"
             data-id="{{$tour->id}}">
            @if($calendar)
                <div class="tour__calendar">
                <select class="select tour__select" js-module="select" js-element="current_tour">
                    @foreach($tour->checkout->group as $group)
                        <option
                            value="{{$group->id}}" {{$group->id == $tour->id ? 'selected' : ''}}>{{$group->title}}</option>
                    @endforeach
                </select>

                <div class="tour__options">
                    <div class="tour__option tour__option--adults">
                        <span class="tour__option--title">Adults:</span>
                        <input type="text" class="tour__option--value" name="adults" value="1" js-element="tour_adults">
                    </div>

                    <div class="tour__option tour__option--kids">
                        <span class="tour__option--title">Kids:</span>
                        <input type="text" class="tour__option--value" name="kids" value="0" js-element="tour_kids">
                    </div>

                    <div class="tour__option tour__option--kids-age">
                        <span class="tour__option--title">Kids age:</span>
                        <input type="text" class="tour__option--value" name="kids_age" value="" js-element="kid_info">
                    </div>
                </div>

                <div class="calendar-container" js-module="calendar" js-element="calendar"
                     data-calendar="{{ json_encode($calendar) }}"
                     data-min="{{ $calendar_min }}"></div>

                <div class="tour__properties">

                    <div class="tour__property">
                        <div class="tour__property--title">Choose time slot:</div>
                        <div class="tour__property--value">
                            <select class="select" name="timeslot" js-module="select" js-element="timeslots">
                                @foreach($timeslots as $timeslot_id => $timeslot)
                                    <option
                                        {{$timeslot_id === $checked_timeslot_id ? 'selected' : ''}}
                                        value="{{$timeslot_id}}">{{$timeslot['title']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    @if($tour->image->type === 'group')
                        <div class="tour__property">
                            <div class="tour__property--title">Availability for<br>the selected date:</div>
                            <div class="tour__property--value">
                                <input type="text" class="tour__available--count" js-element='available_count'
                                       value="{{$tour->person_count - $timeslots[$checked_timeslot_id]['booked']}}" readonly>
                                <span class="tour__available--span">of</span>
                                <input type="text" class="tour__available--total" js-element='available_total'
                                       value="{{$tour->person_count}}" readonly>
                                <span class="tour__available--span">are ready for booking</span>
                            </div>
                        </div>
                    @endif

                </div>

                <div class="tour__total">
                    <p class="tour__total--price">TOTAL PRICE: <span js-element="price">{{$tour->price}}</span> € </p>
                    <p class="tour__total--hint">Price depends from the number of people</p>
                    <script type="text/javascript" src="https://widgets.bokun.io/assets/javascripts/apps/build/BokunWidgetsLoader.js?bookingChannelUUID=5ea5460d-38ec-4630-a38f-1d66bd18d816" async></script>
                    <style> #bokun_9e0ff7d3_f56b_4e53_9e71_fde7031ec22f { display: inline-block; padding: 10px 20px; background: #408C3D; border-radius: 5px; box-shadow: none; font-weight: 600; font-size: 16px; text-decoration: none; text-align: center; color: #FFFFFF; border:none; cursor: pointer; transition: background .2s ease; } #bokun_9e0ff7d3_f56b_4e53_9e71_fde7031ec22f:hover{ background: #285726; } #bokun_9e0ff7d3_f56b_4e53_9e71_fde7031ec22f:active{ background: #30682e; } </style> <button class="bokunButton" disabled id=bokun_9e0ff7d3_f56b_4e53_9e71_fde7031ec22f data-src="https://widgets.bokun.io/online-sales/5ea5460d-38ec-4630-a38f-1d66bd18d816/experience/858806?partialView=1" data-testid="widget-book-button" > Book now </button>
                    <button class="button button--fill tour__total--buy" js-element="book">Book now</button>
                    <p class="tour__total--discuss">Need a special tour? <a href="#" js-module="discuss">Let’s discuss!</a></p>
                </div>


            </div>
            @else
                <p class="tour__unavailable">Tour not available for booking</p>
            @endif
        </div>

    </div>
</section>
