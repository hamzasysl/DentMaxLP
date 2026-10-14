<?php

return [

    'custom' => [
        'phone' => [
            'valid_phone' => 'Please enter a valid phone number.',
        ],
        'email' => [
            'valid_email' => 'Please enter a valid email address.',
            'disposable' => 'Please enter a real email address.',
        ],
        'name' => [
            'real_name' => 'Please enter your real full name.',
        ],
    ],

    'spin' => [
        'phone_used' => 'You have already used your spin today.',
    ],


    'check_marked_fields' => 'Please check the highlighted fields.',
    'required' => 'The :attribute field is required.',
    'email'    => 'The :attribute must be a valid email address.',
    'regex'    => ':attribute must be in a valid format.',
    'min'      => [
        'string' => 'The :attribute must be at least :min characters.',
    ],
    'max'      => [
        'string' => 'The :attribute may not be greater than :max characters.',
    ],

    'attributes' => [
        'name'    => 'full name',
        'email'   => 'email address',
        'phone'   => 'phone number',
        'message' => 'message',
    ],
];
