<?php

$config = [
    'components' => [
        'request' => [
            'cookieValidationKey' => getenv('cookieValidationKey'),
            'csrfParam' => getenv('csrfParam'),
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
                'multipart/form-data' => 'yii\web\MultipartFormDataParser'
              ]
           ],
        ],
];
return $config;

