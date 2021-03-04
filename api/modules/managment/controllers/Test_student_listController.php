<?php
/**
/**Generate by ASGENS
*@author Pulgaron  
*@date Thu Feb 25 22:09:38 GMT-05:00 2021  
*@time Thu Feb 25 22:09:38 GMT-05:00 2021  
*/
namespace api\modules\managment\controllers;


use common\controllers\RestController;
use api\modules\managment\services\Test_student_listService;
use yii\helpers\Url;
use yii\filters\Cors;
use api\modules\managment\models\Test_student_list;
use yii\web\ServerErrorHttpException;

class Test_student_listController extends RestController
{
    /**
     * {@inheritdoc}
     */
    public $service ;
    public $modelClass = 'api\modules\managment\models\Test_student_list';


    public function behaviors()
    {
        $array= parent::behaviors();
        $array['authenticator']['except']= ['index','create', 'update', 'delete', 'view', 'select_2_list', 'validate', 'delete_parameters', 'delete_by_id','update_multiple'];
        $array['cors']=[
            'class' => Cors::class,
            'actions' => [
                'your-action-name' => [
                    #web-servers which you alllow cross-domain access
                    'Origin' => ['*'],
                    'Access-Control-Request-Method' => ['POST','OPTIONS'],
                    'Access-Control-Request-Headers' => ['*'],
                    'Access-Control-Allow-Credentials' => null,
                    'Access-Control-Max-Age' => 86400,
                    'Access-Control-Expose-Headers' => [],
                ]
            ],
        ];
        return $array;
    }

    protected function verbs()
    {
        $array= [];
        return array_merge(parent::verbs(),$array);
    }
   public function getService()
    {
        if ($this->service == null)
            $this->service = new Test_student_listService();
        return $this->service;
    }

}
