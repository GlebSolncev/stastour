@section('discuss_form')
    <form class="checkout__form" id="discuss_form" js-module="discuss-form">

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

        <div class="checkout__row">
            <label for="email" class="checkout__row-label">Email*:</label>
            <input id="email" name="email" type="email" class="checkout__row-input" required>
        </div>

        <div class="checkout__row">
            <label for="comments" class="checkout__row-label">Ask smth:</label>
            <textarea id="comments" name="comments" type="text" class="checkout__row-textarea"></textarea>
        </div>

        <div class="checkout__checkbox">
            <input id="agree" name="agree" type="checkbox" class="checkout__checkbox-input" checked required>
            <label for="agree" class="checkout__checkbox-label">I accept <a href="/">terms and service
                    conditions* </a></label>
        </div>

    </form>
@endsection


@include('component.modal', [
   'window' => (object)[
        'code' => 'discuss',
        'title' => 'Have a question? Let’s discuss:',
        'text' => $__env->yieldContent('discuss_form'),
        'action' => (object)[
            'close_callback' => 'modal.close',
            'buttons' => [
                (object)[
                    'title' => 'Send',
                    'style' => '',
                    'action_callback' => 'send'
                ],
            ]
        ]
    ]
])
