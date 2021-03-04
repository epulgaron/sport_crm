<?php

namespace api\controllers;

use common\controllers\SecureController;
use common\components\JwtValidationData;
use common\models\LoginForm;
use common\models\SignupForm;
use Yii;
use yii\filters\Cors;
use yii\helpers\ArrayHelper;

class SiteController extends SecureController
{
    /**
     * {@inheritdoc}
     */
    public $modelClass = "";

    public function behaviors()
    {
        $array['authenticator']['except'] = ['login','signup','error'];
        return ArrayHelper::merge(
            $array,
            parent::behaviors(),
            [
                'cors' => [
                    'class' => Cors::class,
                    #special rules for particular action
                    'actions' => [
                        'your-action-name' => [
                            #web-servers which you alllow cross-domain access
                            'Origin' => ['*'],
                            'Access-Control-Request-Method' => ['POST', 'OPTIONS'],
                            'Access-Control-Request-Headers' => ['*'],
                            'Access-Control-Allow-Credentials' => null,
                            'Access-Control-Max-Age' => 86400,
                            'Access-Control-Expose-Headers' => [],
                        ]
                    ],
                ],
            ]
        );
    }

    /**
     * {@inheritdoc}
     * Asignar a cada accion por el metodo por el que va a salir
     */
    protected function verbs()
    {
        return [
            'logout' => ['POST', 'OPTIONS'],
            'login' => ['POST', 'OPTIONS'],
            'signup' => ['POST', 'OPTIONS'],
        ];
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = new LoginForm();
        if ($model->load(\Yii::$app->getRequest()->getBodyParams(), '') && $model->login()) {
             $token=JwtValidationData::get_token(Yii::$app->getUser()->getId(),Yii::$app->getUser()->identity);
             return ['token'=>$token];
        } else {
            Yii::$app->getResponse()->setStatusCode(422);
            return array("error" => "Authenticate Error, username or password");
        }
    }


    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = new SignupForm();
        if ($model->load(\Yii::$app->getRequest()->getBodyParams(), '')) {
            $user = $model->signup();
            return $user;
        }
        return array('error' => "Data Error");
    }


    public function actionLogout()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $username = Yii::$app->user->identity->username;
        Yii::$app->user->logout();
        Yii::$app->getResponse()->setStatusCode(200);
        return ['username' => $username, 'action' => 'logout'];
    }

    public function actionError()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            'statusText' => \Yii::$app->response->statusText,
            'statusCode' => \Yii::$app->response->statusCode,
        ];
    }
}
