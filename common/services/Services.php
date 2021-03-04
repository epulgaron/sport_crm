<?php

/**Generate by ASGENS
*@author Pulgaron  
*@date Thu Feb 25 22:09:38 GMT-05:00 2021  
*@time Thu Feb 25 22:09:38 GMT-05:00 2021  
*/
namespace common\services;

use yii\base\Controller;
use yii\web\ServerErrorHttpException;

class Services extends Controller
{
    public $modelClass = '';

    public function __construct()
    {
        parent::__construct('', '', []);
    }

    public function validate($params)
    {
        $model = new $this->modelClass();
        $result = $model->model_validate($params);
        return $result;
    }

    public function list($params)
    {
        return \Yii::createObject($this->modelClass)::list_model($params);
    }

    public function view($id, $params)
    {
        $model = \Yii::createObject($this->modelClass)::findOne($id);
        if (!is_null($model))
            return \Yii::createObject($this->modelClass)::view($id, $params);
        return null;
    }

    public function select2_list($params)
    {
        return \Yii::createObject($this->modelClass)::select_2_list($params);
    }

    public function create($params)
    {
        return \Yii::createObject($this->modelClass)->model_create($params, 'create');
    }

    public function update($id, $params)
    {
        $model = \Yii::createObject($this->modelClass)::findOne($id);
        if (!is_null($model))
            return \Yii::createObject($this->modelClass)::model_update($params, $model);
        return null;
    }

    public function update_multiple($params)
    {
        return \Yii::createObject($this->modelClass)::update_array($params);
    }

    public function delete_parameters($params)
    {
        return \Yii::createObject($this->modelClass)::delete_by_parameters($params);
    }

    public function delete_by_id($params)
    {
        return \Yii::createObject($this->modelClass)::delete_array($params);
    }

    public function delete($id)
    {
        $model = \Yii::createObject($this->modelClass)::findOne($id);
        $result = new \stdClass();
        try {
            if (!is_null($model)) {
                if ($model->delete() === false) {
                    throw new ServerErrorHttpException('Failed to delete the object for unknown reason.');
                }
                $result->success = !count($model->errors) > 0;
                $result->model = $model;
                $result->errors = $model->errors;
                return $result;
            }
        }catch (\Exception $e){
            $result->success = false;
            $result->model = $model;
            $result->delete = true;
            $result->errors = $e->getMessage();
            return $result;
        }
        return null;
    }
    public function process_response($result)
    {
        $errors=[];
        foreach ($result as $response){
            if(!$response->success){
                $errors[]=$response->errors;
            }
        }
        $success=count($errors)==0;
        return ['success'=>$success,'errors'=>$errors];
    }
}

