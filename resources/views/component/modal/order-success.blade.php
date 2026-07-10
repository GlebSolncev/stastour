@php
    $close = "javascript:window.callback.trigger('modal.close')";
@endphp

@include('component.modal', [
   'window' => (object)[
        'code' => 'order-success',
        'title' => 'Success',
        'text' => 'Order №'.$id.' was successfully completed',
        'action' => (object)[
            'close_callback' => 'done',
            'buttons' => [
                (object)[
                    'title' => 'Homepage',
                    'style' => '',
                    'action_callback' => 'done'
                ],
            ]
        ]
    ]
])
