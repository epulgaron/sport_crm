<?php
/**
/**Generate by ASGENS
*@author Pulgaron  
*@date Thu Feb 25 22:09:38 GMT-05:00 2021  
*@time Thu Feb 25 22:09:38 GMT-05:00 2021  
*/
namespace api\modules\managment\controllers;

use common\controllers\SecureController;
use api\modules\managment\models\Tests;

class Tests_soapController extends SecureController
{

    /** @var bool */
    public $enableCsrfValidation = false;

    /**
     * {@inheritdoc}
     */
    public $modelClass = 'api\modules\managment\models\Tests';


    public function behaviors()
    {
        $array = parent::behaviors();
        $array['authenticator']['except'] = ['tests_data'];
        return $array;
    }
    /**
     * {@inheritdoc}
     * redefine las acciones restful de la controladora
     */
    public function actions()
    {
        return [
            'tests_data' => [
                'class' => 'mongosoft\soapserver\Action',
                'classMap' => ['Tests' => 'api\modules\managment\models\Tests'],
                'serviceOptions' => [
                    'disableWsdlMode' => true,
                ]
            ],
        ];
    }

    public function checkAccess($action, $model = null, $params = [])
    {
        parent::checkAccess($action, $model, $params); // TODO: Change the autogenerated stub
    }


    public function encode_result($result)
    {
        $encode = false;
        if (strpos(\Yii::$app->getRequest()->contentType, "application/json") !== false)
            $encode = true;
        if ($encode)
            return json_encode($result, JSON_UNESCAPED_UNICODE);
        return $result;
    }

    /**
     * Simple test which returns a List of tests in order to see how the wsdl pans out
     * @param [] $params
     * @return object[]
     * @soap
     */

    public function tests_list()
    {
        $params=[];
        if (func_get_args())
            $params = func_get_args()[0]['params'];
        return $this->encode_result(Tests::list_model($params));
    }

    /**
     * Simple test which returns a data of tests  with id in order to see how the wsdl pans out
     * @param int $id
     * @return api\modules\managment\models\Tests
     * @soap
     */
    public function tests_view($id)
    {
        $params=[];
        if (func_get_args())
            $params = func_get_args()[0]['params'];
        return $this->encode_result(Tests::view($id, $params));
    }
}