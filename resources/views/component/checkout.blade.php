<section class="checkout" js-module="checkout">
    <div class="checkout__basket">
        <a href="/" class="checkout__back">back to tours</a>

        <p class="checkout__title">Your order:</p>

        <div class="checkout__items">
            @foreach ($checkout->basket->items as $item)
                <div class="checkout__item">
                    <p class="checkout__item-title">{{$item->title}}</p>
                    <div class="checkout__item-properties">
                        @foreach ($item->properties as $key => $value)
                            @if(in_array($key, ['adult', 'kid']))
                                <p class="checkout__item-property"><span>{{$value}}</span> {{$key}}</p>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endforeach

            {{-- for shop basket item
                <div class="checkout__item">
                    <p class="checkout__item-title">Lorem ipsum dolor sit amet, consectetur adipiscing elit </p>
                    <div class="checkout__item-properties">
                        <p class="checkout__item-property"><span>1</span></p>
                    </div>
                </div>

                <div class="checkout__item">
                    <p class="checkout__item-title">Lorem ipsum dolor sit amet, consectetur adipiscing elit </p>
                    <div class="checkout__item-properties">
                        <p class="checkout__item-property"><span>1</span></p>
                    </div>
                </div>
            --}}
        </div>

        <div class="checkout__total">
            <div class="checkout__total-row checkout__total-row--price">
                <p class="checkout__total-key">TOTAL:</p>
                <p class="checkout__total-value">{{$checkout->basket->total}} €</p>
            </div>

            {{--
                <div class="checkout__total-row checkout__total-row--delivery">
                    <p class="checkout__total-key">Delivery price:</p>
                    <p class="checkout__total-value">please insert delivery information</p>
                </div>
            --}}

        </div>

        <div class="checkout__links">
            <a class="checkout__link" href="/">> Refund policy</a>
            <a class="checkout__link" href="/">> Terms of service</a>
        </div>

    </div>
    <div class="checkout__confirm">
        <form class="checkout__form" js-element="form">

            <p class="checkout__head">Contact information:</p>

            <div class="checkout__row">
                <label for="name" class="checkout__row-label">Name*:</label>
                <input id="name" name="name" type="text" class="checkout__row-input" required>
            </div>

            <div class="checkout__row checkout__row-group checkout__row-group--phone">
                <input type="hidden" name="phone" js-element="form-phone">
                <div class="checkout__column">
                    <label for="phone_country" class="checkout__row-label">Phone*:</label>
                    <input id="phone_country" name="phone_country" type="text" class="checkout__row-input" required
                           js-element="form-phone-country">
                </div>
                <div class="checkout__column">
                    <input id="phone_tail" name="phone_tail" type="text" class="checkout__row-input" required
                           js-element="form-phone-tail">
                </div>
            </div>

            <div class="checkout__row checkout__row--mb30">
                <label for="email" class="checkout__row-label">Email*:</label>
                <input id="email" name="email" type="email" class="checkout__row-input" required>
            </div>

            @if($checkout->basket->has_tour)

                <p class="checkout__head">Booking information:</p>

                <div class="checkout__row">
                    <label for="restrictions" class="checkout__row-label">Do you have any mobility restrictions?</label>
                    <input id="restrictions" name="restrictions" type="text" class="checkout__row-input">
                </div>

                <div class="checkout__row">
                    <label for="comments" class="checkout__row-label">Comments (time zone, how to contact,
                        etc.):</label>
                    <textarea id="comments" name="comments" type="text" class="checkout__row-textarea"></textarea>
                </div>

            @endif

            @if($checkout->basket->has_shop)
                <p class="checkout__head">Delivery information:</p>

                <div class="checkout__row">
                    <label for="country" class="checkout__row-label">Country*:</label>
                    <input id="country" name="country" type="text" class="checkout__row-input" required
                           js-element="form-country">
                </div>

                <div class="checkout__row">
                    <label for="address" class="checkout__row-label">Address*:</label>
                    <input id="address" name="address" type="text" class="checkout__row-input" required>
                </div>

                <div class="checkout__row checkout__row--mb30 checkout__row-group checkout__row-group--delivery">
                    <div class="checkout__column">
                        <label for="city" class="checkout__row-label">City*:</label>
                        <input id="city" name="city" type="text" class="checkout__row-input" required
                               js-element="form-city">
                    </div>
                    <div class="checkout__column">
                        <label for="postalcode" class="checkout__row-label">Postal code*:</label>
                        <input id="postalcode" name="postalcode" type="text" class="checkout__row-input" required>
                    </div>
                </div>
            @endif

            <div class="checkout__checkbox">
                <input id="agree" name="agree" type="checkbox" class="checkout__checkbox-input" checked required>
                <label for="agree" class="checkout__checkbox-label">I accept <a href="/">terms and service
                        conditions* </a></label>
            </div>

            <button class="checkout__submit button button--fill" js-element="submit" type="button">Pay now</button>

        </form>
    </div>

    <div class="checkout__footer"></div>
</section>
