<?php 
/**Generate by ASGENS
*@author Pulgaron  
*@date Thu Feb 25 22:09:38 GMT-05:00 2021  
*@time Thu Feb 25 22:09:38 GMT-05:00 2021  
*/
namespace api\modules\managment\models;
use Yii;
use common\models\RestModel;

use api\modules\entities\models\Errors;
use api\modules\types\models\Error_level;
/**
 * Este es la clase modelo para la tabla error_level_list.
 *
 * Los siguientes son los campos de la tabla 'error_level_list':
 * @property integer $id_error_level_list
 * @property integer $error_id
 * @property integer $error_level_id
 * @property integer $eval_id

 * Los siguientes son las relaciones de este modelo :

 * @property Evaluation $eval
 * @property Errors $error
 * @property Error_level $error_level
 */

class Error_level_list extends RestModel 
{

    /**
     * The number of models to return for pagination.
     *
     * @var int
     */
    protected $perPage = 15;

    /**
     * The primarykey associated with the table-model.
     *
     * @var integer
     */
    protected $primaryKey = 'id_error_level_list';

    const MODEL = 'Error_level_list';

    /**
     * @return string the associated database table name
     */
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'error_level_list';
    }

     
        /**
     *
     * The names of the hidden fields.
     *
     * @var array
     */
    const HIDE = [];
    /**

     * The names of the relation tables.
     *
     */
       const RELATIONS = ['eval','error','error_level'];



    /**
     * The primary key of the table
     *
     * @var mixed
     */

       const PKEY = 'id_error_level_list';

     /*
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
			[['error_id','error_level_id','eval_id'],'required','on'=>['create','default']],
			[['id_error_level_list'],'required', 'on' => 'update'],
			[['id_error_level_list','error_id','error_level_id','eval_id'],'integer'],
			[['id_error_level_list'], 'unique' , 'on' => 'create'],
        ];
    }
	 /**
     * @return \yii\db\ActiveQuery
     * @description hace referencia al campo foráneo eval_id
     */
	  public function getEval()
		{
			return $this->hasOne(Evaluation::class, ['id_eval' => 'eval_id']);
		}

	 /**
     * @return \yii\db\ActiveQuery
     * @description hace referencia al campo foráneo error_id
     */
	  public function getError()
		{
			return $this->hasOne(Errors::class, ['id_error' => 'error_id']);
		}

	 /**
     * @return \yii\db\ActiveQuery
     * @description hace referencia al campo foráneo error_level_id
     */
	  public function getError_level()
		{
			return $this->hasOne(Error_level::class, ['id_error_level' => 'error_level_id']);
		}

 /**
     * Get the list model with select2 schema.
     * @var $relation array
     * @var $parameters array
     * @return array|mixed
     */
    static function select_2_list($parameters = [])
    {
        $parameters = get_called_class()::parameters_request($parameters);
        $like = '';
        if (isset($_GET['q']))
            $like = $_GET['q'];
        else
            if (isset($parameters->q))
                $like = $parameters->q;
        $query = get_called_class()::query_list($parameters);
        get_called_class()::process_find_parameters($query, $parameters);
        $select = ['*', 'error_level_list.id_error_level_list as id', 'error_level_list.id_error_level_list as text'];
        $result = new \stdClass();
        $result->data = [];
        if ($parameters->relations == 'all')
            $result->data = $query->select($select)->with(get_called_class()::RELATIONS);
        if (!is_null($parameters->relations) && $parameters->relations != 'all')
            $result->data = $query->select($select)->with($parameters->relations);
        if (is_null($parameters->relations))
            $result->data = $query->select($select);
        $result->data=$result->data->andWhere('error_level_list.id_error_level_list LIKE '."'%".$like."%'")->asArray()->all();
        return $result;

    }
}
?>
