<?php

/**Generate by ASGENS
*@author Pulgaron  
*@date Thu Feb 25 22:09:38 GMT-05:00 2021  
*@time Thu Feb 25 22:09:38 GMT-05:00 2021  
*/
namespace common\controllers;

use Yii;
use yii\filters\auth\HttpBasicAuth;
use sizeg\jwt\JwtHttpBearerAuth;
use yii\helpers\ArrayHelper;
use yii\filters\Cors;

class SecureController extends \yii\rest\ActiveController
 {
    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
//                Default RateLimiter
//                'rateLimiter' => [
//                    'class' => \yii\filters\RateLimiter::class,
//                    'enableRateLimitHeaders' => true,
//                ],
                [
                    'class' => 'thamtech\ratelimiter\RateLimiter',
                    'only' => [],
                    'except' => [],
                    'components' => [
                        'rateLimit' => [
                            'definitions' => [
                                'ip' => [
                                    'limit' => 1000, // allowed hits per window
                                    'window' => 3600, // window in seconds
                                    'identifier' => function($context, $rateLimitId) {
                                        return $context->request->getUserIP();
                                    }
                                ],
                                'user-admin' => [
                                    'limit' => 1000,
                                    'window' => 3600,
                                    'identifier' => Yii::$app->getUser()->getIdentity()?Yii::$app->getUser()->getIdentity()->getId():-1,
                                    // make a rate limit only be considered under certain conditions
                                    'active' => false//Yii::$app->user->getIdentity()->isAdmin(),
                                ],
                            ],
                        ],
                        'allowanceStorage' => [
                            'cache' => 'cache', // use Yii::$app->cache component
                        ],
                    ],
                    'as rateLimitHeaders' => [
                        'class' => 'thamtech\ratelimiter\handlers\RateLimitHeadersHandler',
                        'except' => [],
                        // This can be a single string prefix, or an array of strings to duplicate
                        // the headers with multiple prefixes.
                        // The default prefix is 'X-Rate-Limit-' if this property is not specified
                        'prefix' => ['X-Rate-Limit-', 'X-RateLimit-'],
                    ],
                    'as retryAfterHeader' => [
                        'class'=>'thamtech\ratelimiter\handlers\RetryAfterHeaderHandler',
                        'header' => 'Retry-After',
                    ],
                    'as tooManyRequestsException' => [
                        'class' => 'thamtech\ratelimiter\handlers\TooManyRequestsHttpExceptionHandler',

                        // list of rateLimits this handler should apply to
                        'only' => [], //Example: 'only'=>['ip']

                        // defaults to 'Rate limit exceeded.' if not set
                        'message' => 'There were too many requests',
                    ],

                ],
                'authenticator' => [
                    'authMethods' => [
                        'basicAuth' => [
                            'class' => HttpBasicAuth::class,
                            'auth' => function ($username, $password) {
                                $user = Yii::createObject(Yii::$app->components['user']['identityClass'])->findByUsername($username);
;
                                if ($user !== null && $user->validatePassword($password)) {
                                    return $user;
                                }
                                return null;
                            },
                        ],
                        'bearerAuth' => [
                            'class' => JwtHttpBearerAuth::class,
                            'optional' => [
                                'login',
                            ],
                        ]
                    ]
                ],
               'cors' => [
                   'class' => Cors::class,
                   #common rules
                   'cors' => [
                       'Origin' => ['*'],
                       'Access-Control-Request-Method' => ['POST','OPTIONS','DELETE','PUT','PATCH'],
                       'Access-Control-Request-Headers' => ['*'],
                       'Access-Control-Allow-Credentials' => null,
                       'Access-Control-Max-Age' => 86400,
                       'Access-Control-Expose-Headers' => [],
                   ]
               ],
            ]
        );
    }
}

