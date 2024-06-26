<?php

return [
    'name' => 'Lms',
    'service_url'=>[
        'auth' => env('AUTH_SERVICE_URL','http://lms-ptc.com'),
        'eduquiz'=> env('EDU_QUIZ_SERVICE_URL','https://api-dev.eduquiz.vn')
    ]
];
