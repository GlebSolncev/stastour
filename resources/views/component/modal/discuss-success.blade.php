@include('component.modal', [
   'window' => (object)[
        'code' => 'discuss-success',
        'title' => 'Success',
        'text' => 'Form successfully completed',
        'action' => (object)[
            'close_callback' => 'modal.close',
            'buttons' => [
                (object)[
                    'title' => 'Close',
                    'style' => '',
                    'action_callback' => 'modal.close'
                ],
            ]
        ]
    ]
])
