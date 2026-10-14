<?php

return [

    '404' => [
        'title' => 'Page not found',
        'message' => 'Sorry, the page you are looking for could not be found.',
        'action' => 'Go back to homepage',
    ],

    '403' => [
        'title' => 'Access denied',
        'message' => 'You do not have permission to access this page.',
        'action' => 'Go back',
    ],

    '500' => [
        'title' => 'Server error',
        'message' => 'Something went wrong on our side. Please try again later.',
        'action' => 'Refresh page',
    ],

    'generic' => [
        'title' => 'Something went wrong',
        'message' => 'An unexpected error occurred.',
        'action' => 'Go back',
    ],

];
