<?php
/**
/**Generate by ASGENS
*@author Pulgaron  
*@date Thu Feb 25 22:09:38 GMT-05:00 2021  
*@time Thu Feb 25 22:09:38 GMT-05:00 2021  
*/
namespace api\modules\entities\controllers;

use common\controllers\SecureController;
use api\modules\entities\models\Students;

class Students_soapController extends SecureController
{

    /** @var bool */
    public $enableCsrfValidation = false;

    /**
     * {@inheritdoc}
     */
    public $modelClass = 'api\modules\entities\models\Students';


    public function behaviors()
    {
        $array = parent::behaviors();
        $array['authenticator']['except'] = ['students_data'];
        return $array;
    }
    /**
     * {@inheritdoc}
     * redefine las acciones restful de la controladora
     */
    public function actions()
    {
        return [
            'students_data' => [
                'class' => 'mongosoft\soapserver\Action',
                'classMap' => ['Students' => 'api\modules\entities\models\Students'],
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
     * Simple test which returns a List of students in order to see how the wsdl pans out
     * @param [] $params
     * @return object[]
     * @soap
     */

    public function students_list()
    {
        $params=[];
        if (func_get_args())
            $params = func_get_args()[0]['params'];
        return $this->encode_result(Students::list_model($params));
    }

    /**
     * Simple test which returns a data of students  with id in order to see how the wsdl pans out
     * @param int $id
     * @return api\modules\entities\models\Students
     * @soap
     */
    public function students_view($id)
    {
        $params=[];
        if (func_get_args())
            $params = func_get_args()[0]['params'];
        return $this->encode_result(Students::view($id, $params));
    }
}