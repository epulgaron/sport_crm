<?php

/**Generate by ASGENS
*@author Pulgaron  
*@date Thu Feb 25 22:09:38 GMT-05:00 2021  
*@time Thu Feb 25 22:09:38 GMT-05:00 2021  
*/


$params = array_merge(
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php'),
    require(__DIR__ . '/../../common/config/params.php')
);


 /*Ficheros de modulos*/
$modules = require(__DIR__ . '/modules.php');

 /*Ficheros de reglas de las rutas*/
$rules = require(__DIR__ . '/routes.php');

$config = [
    'id' => getenv('id'),
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'api\controllers',
    'bootstrap' => ['log'],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'showScriptName' => false,
            'enablePrettyUrl' => true,
            'enableStrictParsing' => false,
            'rules' => $rules
        ],
       'user' => [
            'identityClass' => getenv('identityClass'),
            'enableAutoLogin' => true,
            'enableSession' => false,// Dejar session activa durante la autenticasion basica
            'identityCookie' => ['name' => getenv('identityCookie.name'), 'httpOnly' => true],
        ],
        'jwt' => [
            'class' => \sizeg\jwt\Jwt::class,
            'key' => 'sport_crm',
            // You have to configure ValidationData informing all claims you want to validate the token.
            'jwtValidationData' => common\components\JwtValidationData::class,
        ],
       'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
    ],
    'params' => $params,
    'modules' => $modules
];

   if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    /*  $config['bootstrap'][] = 'debug';
         $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
     ];*/

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
      'class' => 'yii\gii\Module',
    ];
}

return $config;

?>
