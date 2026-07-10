@php
    if($window->action->close_callback) {
        $window->action->close = "javascript:window.modal('".$window->code.".".$window->action->close_callback."')";
    }

    foreach ($window->action->buttons as $i => $button) {
        if($button->action_callback) {
            $window->action->buttons[$i]->action = "javascript:window.modal('".$window->code.".".$button->action_callback."')";
        }
    }
@endphp

<div class="modal__layout" data-modal="{{$window->code}}">
    <div class="modal-window" {{isset($window->autorun) ? 'js-module=modal-autorun' : ''}}>
        <a class="modal-window__close" href="{{$window->action->close}}"></a>

        <h1 class="modal-window__title">{{$window->title}}</h1>
        <div class="modal-window__text">{!! $window->text !!}</div>

        <div class="modal-window__actions">
            @foreach($window->action->buttons as $button)
                <a class="modal-window__button button {{$button->style}}" href="{{$button->action}}">{{$button->title}}</a>
            @endforeach
        </div>
    </div>
</div>
