<?php
/**
 * This Model was created by Charlietyn
 * Generado by Argens
 * @author Charlietyn
 */

namespace common\models;

use erp\modules\security\models\Logs;
use yii\base\InvalidConfigException;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\web\ServerErrorHttpException;

class RestModel extends \yii\db\ActiveRecord
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';
    const SCENARIO_DELETE = 'delete';
    const SCENARIO_DEFAULT = self::SCENARIO_CREATE;


    /**
     *
     * The names of the hidden fields.
     *
     * @var array
     */
    const HIDE = [];

    /**
     * /**
     * The names of the relation tables.
     *
     * @var array
     */
    const RELATIONS = [];

    /**
     * /**
     * The name of the model name parameters
     *
     * @var string
     */
    const MODEL = '';

    /**
     * /**
     * Parents and the relation attributes
     *
     * @var array
     */
    const PARENT = [];

    /**
     * The names of the relation tables.
     *
     * @var array
     */

    const PKEY = '';


    public function hasHierarchy()
    {
        return count(get_called_class()::PARENT) > 0;
    }

    public function getParents($elements = null, $scenario, $specific = false)
    {
        $parent_array = [];
        if ($this->hasHierarchy()) {
            $parent = \Yii::createObject($this::PARENT['class']);
            $parent->load($elements, '');
            if ($scenario)
                $parent->setScenario($scenario);
            $parent->validate_model($elements, $specific);
            if ($parent->hasHierarchy()) {
                $parent_array = $parent->getParents($elements, $scenario, $specific);
            }
            array_push($parent_array, $parent);
        }
        return $parent_array;
    }

    /**
     * Config de request parameters to return the list of data with config
     * @param $request_array array
     * return array|mixed
     */

    public static function parameters_request($request_array)
    {
        $parameters = [];
        array_key_exists('soft_delete', $request_array) ? $parameters['soft_delete'] = $request_array['soft_delete'] : $parameters['soft_delete'] = null;
        array_key_exists('pagination', $request_array) ? $parameters['pagination'] = $request_array['pagination'] : $parameters['pagination'] = null;
        array_key_exists('relations', $request_array) ? $parameters['relations'] = $request_array['relations'] : $parameters['relations'] = null;
        array_key_exists('attr', $request_array) ? $parameters['attr'] = $request_array['attr'] : $parameters['attr'] = null;
        array_key_exists('select', $request_array) ? $parameters['select'] = $request_array['select'] : $parameters['select'] = get_called_class()::select();
        array_key_exists('oper', $request_array) ? $parameters['oper'] = $request_array['oper'] : $parameters['oper'] = null;
        array_key_exists('orderby', $request_array) ? $parameters['orderby'] = $request_array['orderby'] : $parameters['orderby'] = null;
        array_key_exists('q', $request_array) ? $parameters['q'] = $request_array['q'] : $parameters['q'] = null;
        return (object)$parameters;
    }

    public function process_params(&$params)
    {
        foreach ($params as $key => $param) {
            if (!is_string($param))
                continue;
            $params[$key] = json_decode($param, true);
        }
        return $params;
    }

    /**
     * Config de request parameters for graphql to return the list of data with config
     * @param $request_array array
     * return array|mixed
     */
    public static function parameters_request_graphql($request_array)
    {
        $parameters = [];
        array_key_exists('soft_delete', $request_array) ? $parameters['soft_delete'] = $request_array['soft_delete'] : $parameters['soft_delete'] = null;
        array_key_exists('attr', $request_array) ? $parameters['attr'] = $parameters['attr'] = $request_array['attr'] : $parameters['attr'] = null;
        array_key_exists('oper', $request_array) ? $parameters['oper'] = $parameters['oper'] = $request_array['oper'] : $parameters['oper'] = null;
        array_key_exists('orderby', $request_array) ? $parameters['orderby'] = $parameters['orderby'] = $request_array['orderby'] : $parameters['orderby'] = null;
        return (object)$parameters;
    }

    /**
     * Return general with specify configuration
     * @param $parameters array
     * return Query
     */

    public static function query_list($parameters)
    {
        $query = get_called_class()::find();
        if ($parameters->soft_delete != null) {
            $parameters->soft_delete == 'wt' ? $query = get_called_class()::withTrashed() : null;
            $parameters->soft_delete == 'ot' ? $query = get_called_class()::onlyTrashed() : null;
        }
        return $query;
    }

    /**
     * Return general with specify configuration find parameters
     * @param $parameters array
     * return Query
     */

    public static function process_find_parameters(&$query, $parameters)
    {
        if (isset($parameters->attr)) {
            $query = $query->where($parameters->attr);
        }
        if (isset($parameters->select)) {
            $query = $query->select($parameters->select);
        }
        self::process_query_parameters($query, $parameters->oper);
        if (is_array($parameters->orderby)) {
            foreach ($parameters->orderby as $orderby) {
                if (is_array($orderby))
                    foreach ($orderby as $field => $sort) {
                        $query->orderBy([$field => $sort]);
                    }
            }
        }
        return $query;
    }

    public static function process_query_parameters(&$query, $parameters)
    {
        if (is_array($parameters)) {
            $array_and_or = [];
            foreach ($parameters as $key => $oper) {
                if (is_array($oper) && strcmp($key, "and") != 0 && strcmp($key, "or") != 0) {
                    self::process_query_parameters($query, $oper);
                    continue;
                }
                if (is_array($oper) && (strcmp($key, "and") == 0 || strcmp($key, "or") == 0)) {
                    //Creo la condicion con el and anidado
                    self::process_and_or_query($array_and_or, $key, $oper);
                    continue;
                }
                if (is_null($oper))
                    continue;
                //Aqui se ejecuta la consulta directa
                $oper = self::process_data($oper);
                $query = $query->andWhere($oper);
            }
            if (count($array_and_or) > 0) {
                if (strcmp($array_and_or[0], "and") == 0)
                    $query->andFilterWhere($array_and_or);
                if (strcmp($array_and_or[0], "or") == 0)
                    $query->orFilterWhere($array_and_or);
            }
        }
    }

    public static function process_and_or_query(&$array, $condition, $parameters)
    {
        if (strcmp($condition, "or") == 0 || strcmp($condition, "and") == 0) {
            array_push($array, $condition);
            foreach ($parameters as $key => $params) {
                self::process_and_or_query($array, $key, $parameters[$key]);
            }
        } else {
            if (is_array($parameters)) {
                foreach ($parameters as $key => $params) {
                    if (strcmp($key, "or") == 0 || strcmp($key, "and") == 0) {
                        array_push($array, []);
                        self::process_and_or_query($array[count($array) - 1], $key, $parameters[$key]);
                    } else
                        self::process_and_or_query($array, $key, $parameters[$key]);
                }
            } else {
                array_push($array, self::process_data($parameters));
            }
        }
    }

    public static function process_data($parameters)
    {
        $parameters = explode('|', $parameters);
        if ($parameters[0] == "like")
            $parameters[3] = boolval($parameters[3]);
        if (count($parameters) == 2 || $parameters[2] == 'null') {
            $parameters[2] = null;
        }
        return $parameters;
    }

    /**
     * Return general with specify configuration
     * @param $parameters array
     * return Query
     */

    public static function response($query, $parameters = [])
    {
        if (is_array($parameters) && count($parameters) == 0)
            return $query->asArray()->all();
        if (is_null($parameters->pagination) || !isset($parameters->pagination['pagesize']))
            return $query->asArray()->all();
        try {
            $parameters->pagination['page']=$parameters->pagination['page']-1;            return \Yii::createObject([
                'class' => ActiveDataProvider::class,
                'query' => $query->asArray(),
                'pagination' => $parameters->pagination
            ]);
        } catch (InvalidConfigException $e) {
            return $e;
        }
    }

    /**
     * Get the list of model with relation or trashed serialize.
     * @return array|mixed
     * @var $parameters array
     */
    public static function list_model($parameters = [])
    {
        try {
            if (count($parameters) > 0) {
                $parameters = get_called_class()::parameters_request($parameters);
                $query = get_called_class()::query_list($parameters);
                get_called_class()::process_find_parameters($query, $parameters);
                if ($parameters->relations == 'all')
                    $query = $query->with(get_called_class()::RELATIONS);
                else
                    if ($parameters->relations)
                        $query = $query->with($parameters->relations);
            } else
                $query = get_called_class()::find()->select(get_called_class()::select());
            return get_called_class()::response($query, $parameters);
        } catch (\Exception $e) {
            $result = new \stdClass();
            $result->error = true;
            $result->message = $e->getMessage();
            return $result;
        }
    }


    /**
     * Get the list of model for graphql with relation or trashed serialize.
     * @return array|mixed
     * @var $parameters array
     */
    public
    static function list_model_graphql($parameters = [])
    {
        $query = null;
        if (count($parameters) > 0) {
            $parameters = get_called_class()::parameters_request_graphql($parameters);
            $query = get_called_class()::query_list($parameters);
            get_called_class()::process_find_parameters($query, $parameters);
        } else
            $query = get_called_class()::find();
        return $query;
    }

    public static function select()
    {
        return array_filter(array_keys(get_called_class()::getTableSchema()->columns), function ($element) {
            return !in_array($element, get_called_class()::HIDE);
        });
    }

    /**
     * Get the element of model with relation by id serialize.
     * @return array|mixed
     * @var $parameters array
     */
    public static function view($id, $parameters = [])
    {
        try {
            $query = null;
            if (count($parameters) > 0) {
                $parameters = get_called_class()::parameters_request($parameters);
                $query = get_called_class()::query_list($parameters);
                get_called_class()::process_find_parameters($query, $parameters);
                $query = $query->where([get_called_class()::PKEY => $id]);
                if ($parameters->relations == 'all')
                    $query = $query->with(get_called_class()::RELATIONS);
                else
                    if ($parameters->relations)
                        $query = $query->with($parameters->relations);
            } else
                $query = get_called_class()::find()->select(get_called_class()::select())->where([get_called_class()::PKEY => $id]);
            return $query->asArray()->one();
        } catch (\Exception $e) {
            $result = new \stdClass();
            $result->error = true;
            $result->message = $e->getMessage();
            return $result;
        }

    }


    /**
     * Get the list of model with relation serialize by conditions.
     * @return array|mixed
     * @var $parameters array
     * @var $relation array
     */
    static function find_by_parameters($parameters = [])
    {
        try {
            if (is_array($parameters)) {
                $parameters = get_called_class()::parameters_request($parameters);
                $query = get_called_class()::query_list($parameters);
                if ($parameters->relations == 'all')
                    $query = $query->with(get_called_class()::RELATIONS);
                else
                    if ($parameters->relations)
                        $query = $query->with($parameters->relations);

                $query = get_called_class()::process_find_parameters($query, $parameters);
            } else
                $query = get_called_class()::query()->find()->all();

            return get_called_class()::response($query, $parameters);
        } catch (\Exception $e) {
            $result = new \stdClass();
            $result->error = true;
            $result->message = $e->getMessage();
            return $result;
        }

    }

    private function validate_model($params = [], $specific = false)
    {
        $array = $this->attributes;
        if (count($this::PARENT) > 0) {
            unset($array[$this::PKEY]);
        }
        if ($specific)
            $this->validate(array_keys($params));
        else
            $this->validate(array_keys($array));
    }

    private function validate_all($params = null, $scenario = null, $specific = false)
    {
        if ($params)
            $this->load($params, '');
        if ($scenario)
            $this->setScenario($scenario);
        if (!$this->scenario)
            $this->setScenario('create');
        $this->validate_model($params, $specific);
        $result = $this->parents_validate($params, $scenario, $specific);
        if ($this->hasErrors()) {
            $result->success = false;
            $result->errors[] = $this->result()->errors[0];
        }

        return $result;
    }

    private function save_array($array)
    {
        $result = [];
        $errors = false;
        foreach ($array as $object) {
            $model_result = new \stdClass();
            $model_result->success = true;
            $model = \Yii::createObject(get_called_class());
            $validate_result = $model->validate_all($object);
            if ($validate_result->success) {
                if (!$model->save() && !$model->hasErrors()) {
                    $model_result->errors[] = 'Failed to create the object for unknown reason.';
                }
                $model_result->models = $model;
            } else {
                $errors = true;
                $model_result->success = false;
                foreach ($validate_result->errors as $error)
                    $model_result->errors[] = $error;
            }
            $result[] = $model_result;
        }
        return array("success" => true, "errors" => $errors, "result" => $result);
    }

    private function save_element($element)
    {
        $this->load($element, '');
        $this->validate_all();
        if (!$this->hasErrors() && $this->save()) {
            $response = \Yii::$app->getResponse();
            $response->setStatusCode(201);
            $id = implode(',', array_values($this->getPrimaryKey(true)));
            $response->getHeaders()->set('Location', Url::toRoute(['view', 'id' => $id], true));
        } elseif (!$this->hasErrors()) {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }
        return $this->result();
    }

    public function result()
    {
        $result = new \stdClass();
        $result->success = true;
        $result->errors = [];
        if ($this->hasErrors()) {
            $result->success = false;
            $errors = $this->errors;
            $errors["model_name"] = get_called_class()::MODEL;
            $result->errors[] = $errors;
        } else
            $result->model = $this;
        return $result;
    }

    public function model_validate($params)
    {
        $scenario = 'create';
        $specific = false;

        if (isset(((object)$params)->_scenario))
            $scenario = ((object)$params)->_scenario;
        if (isset(((object)$params)->_specific))
            $specific = ((object)$params)->_specific;
        if (array_key_exists(get_called_class()::MODEL, $params))
            $params = $params[get_called_class()::MODEL];
        try {
            return $this->validate_all($params, $scenario, $specific);
        } catch (\Exception $e) {
            $this->addError("error", $e->getMessage());
            $result = new \stdClass();
            $result->success = false;
            $result->errorcode = true;
            $result->message = $e->getMessage();
            return $result;
        }
    }

    private function save_model($element)
    {
        if (count(get_called_class()::PARENT) > 0) {
            $parent = \Yii::createObject(get_called_class()::PARENT['class']);
            $parent->scenario = $this->scenario;
            $result = $this->validate_all($element);
            if ($result->success) {
                if (isset($element[get_called_class()::PKEY]))
                    $parent = call_user_func_array(get_called_class()::PARENT['class'] . '::findOne', array($element[get_called_class()::PKEY]));
                $parent->save_model($element);
                $this->setAttribute(get_called_class()::PKEY, $parent->attributes[get_called_class()::PARENT[get_called_class()::PKEY]]);
                return $this->save_element($element);
            } else
                return $result;
        } else
            return $this->save_element($element);
    }

    public function model_create($params = null)
    {
        if ($params == null)
            $params = $this->dirtyAttributes;
        $this->setScenario("create");

        if (array_key_exists(get_called_class()::MODEL, $params)) {
            if (array_key_exists(0, $params[get_called_class()::MODEL]))
                $result = $this->save_array($params[get_called_class()::MODEL]);
            else
                $result = $this->save_model($params[get_called_class()::MODEL]);

        } else {
            $result = $this->save_model($params);
        }
        return $result;
    }

    static public function model_update($params, $model)
    {
        $model->setScenario('update');
        if (array_key_exists(get_called_class()::MODEL, $params))
            return $model->save_model($params[get_called_class()::MODEL]);
        else
            return $model->save_model($params);
    }

    public function update_model($params = null)
    {
        if ($params == null)
            $params = $this->dirtyAttributes;

        $this->setScenario('update');
        if (array_key_exists(get_called_class()::MODEL, $params))
            return $this->save_model($params[get_called_class()::MODEL]);
        else
            return $this->save_model($params);
    }

    static public function update_array($array)
    {
        $result = [];
        $errors = false;
        $array = $array[get_called_class()::MODEL];
        foreach ($array as $object) {
            $model_result = new \stdClass();
            $model_result->success = true;
            $model = self::findOne($object[get_called_class()::PKEY]);
            if (!$model) {
                $model_result->success = false;
                $model_result->model = $object;
                $model_result->errors[] = " The element doesn't exist";
            } else {
                $validate_result = $model->validate_all($object);
                if ($validate_result->success) {
                    $model->load($object, '');
                    $model->setScenario('update');
                    if ($model->save()) {
                        $model_result->models = $model;
                    } elseif (!$model->hasErrors()) {
                        $model_result->errors[] = 'Failed to create the object for unknown reason.';
                    }
                } else {
                    $errors = true;
                    $model_result->success = false;
                    foreach ($validate_result->errors as $error)
                        $model_result->errors[] = $error;
                }
            }
            $result[] = $model_result;
        }
        return array("success" => true, "errors" => $errors, "result" => $result);
    }

    public static function delete_array($params)
    {
        $result = [];
        if (is_array($params)) {
            foreach ($params as $item) {
                $model_result = new \stdClass();
                $model_result->success = true;
                $model = \Yii::createObject(get_called_class());
                $model = $model->findOne($item);
                if (!is_null($model)) {
                    if (!$model->delete()) {
                        $model_result->success = false;
                        $model_result->model = $model;
                        $model_result->errors[] = $model->errors;
                    } else {
                        $model_result->model = $model;
                    }
                } else {
                    $element = new \stdClass();
                    $model_result->success = false;
                    $element->element = $item;
                    $element->message = " The element doesn't exist";
                    $model_result->errors[] = $element;
                }
                $result[] = $model_result;
            }
            return array("success" => true, "result" => $result);
        }
        return array("success" => false, "error" => []);
    }

    /**
     * Get the list of model with relation serialize by conditions.
     * @return array|mixed
     * @var $parameters array
     * @var $relation array
     */
    static function delete_by_parameters($parameters = [])
    {
        try {
            $result = new \stdClass();
            $result->success = false;
            $result->array_model = [];
            $result->array_error = [];
            if (is_array($parameters)) {
                $parameters = get_called_class()::parameters_request($parameters);
                $query = get_called_class()::query_list($parameters);
                $query = get_called_class()::process_find_parameters($query, $parameters);
                try {
                    $list = $query->all();
                    foreach ($list as $model) {
                        if ($model->delete())
                            array_push($result->array_model, $model->attributes);
                        else {
                            $st = new \stdClass();
                            $st->id = $model->primaryKey;
                            $st->error = $model->errors;
                            array_push($result->array_error, $st);
                        }
                    }
                    if (count($result->array_model) > 0)
                        $result->success = true;
                } catch (\Exception $e) {
                    $result->array_error[] = 'Incorrect format in parameters';
                }

            } else
                $result->array_error[] = "Unknow error";
            return $result;
        } catch (\Exception $e) {
            $result = new \stdClass();
            $result->error = true;
            $result->message = $e->getMessage();
            return $result;
        }
    }

    private function parents_validate($params, $scenario = null, $specific = false)
    {
        $result = new \stdClass();
        $result->success = true;
        $result->errors = [];
        $parents = $this->getParents($params, $scenario, $specific);
        foreach ($parents as $p) {
            if ($p->hasErrors()) {
                $result->success = false;
                $result->errors[] = $p->result()->errors[0];
            }
        }
        return $result;
    }

    private function log_save($insert, $changedAttributes)
    {
        $user = null;
        if (\Yii::$app->id != 'app-console')
            $user = \Yii::$app->getUser() ? \Yii::$app->getUser()->identity : null;
        $class = get_called_class();
        $classLog = Logs::class;
        if ($user && $class != $classLog) {
            $log = new Logs();
            $log->log_action = $insert ? "Insertar" : "Actualizar";
            $log->log_description = $insert ? json_encode(["Insertando nuevo elemento " => $this->attributes]) : (count($changedAttributes) > 0 ? json_encode(['Campos actualizados' => $changedAttributes]) : 'No se actualizo ningun elemento');
            $log->user_id = $user->id_user;
            $log->id_table = $this->getPrimaryKey();
            $log->name_user = $user->nombre_usuario . ' ' . $user->apellido_usuario;
            $log->table = substr($class, strrpos($class, '\\') + 1, strlen($class));
            $log->created_at = date('Y-m-d h:i:s');
            $log->updated_at = date('Y-m-d h:i:s');
            $log->save();
        }
    }

    public function afterSave($insert, $changedAttributes)
    {
        //$this->log_save($insert,$changedAttributes);
        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
    }


    private function log_delete()
    {
        $user = \Yii::$app->getUser()->identity;
        $class = get_called_class();
        $classLog = Logs::class;
        if ($user && $class != $classLog) {
            $log = new Logs();
            $log->log_action = "Eliminar";
            $log->log_description = json_encode(["Eliminando elemento " => $this->attributes]);
            $log->user_id = $user->id_user;
            $log->id_table = $this->getPrimaryKey();
            $log->name_user = $user->nombre_usuario . ' ' . $user->apellido_usuario;
            $log->table = substr($class, strrpos($class, '\\') + 1, strlen($class));
            $log->created_at = date('Y-m-d h:i:s');
            $log->updated_at = date('Y-m-d h:i:s');
            $log->save();
        }
    }

    public function afterDelete()
    {
        //$this->log_delete();
        parent::afterDelete(); // TODO: Change the autogenerated stub
    }

}



