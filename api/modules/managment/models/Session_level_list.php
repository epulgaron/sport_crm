<?php 
/**Generate by ASGENS
*@author Pulgaron  
*@date Thu Feb 25 22:09:38 GMT-05:00 2021  
*@time Thu Feb 25 22:09:38 GMT-05:00 2021  
*/
namespace api\modules\managment\models;
use Yii;
use common\models\RestModel;

use api\modules\entities\models\Sessions;
use api\modules\types\models\Levels;
/**
 * Este es la clase modelo para la tabla session_level_list.
 *
 * Los siguientes son los campos de la tabla 'session_level_list':
 * @property integer $id_session_level
 * @property integer $session_id
 * @property integer $level_id

 * Los siguientes son las relaciones de este modelo :

 * @property Sessions $session
 * @property Levels $level
 */

class Session_level_list extends RestModel 
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
    protected $primaryKey = 'id_session_level';

    const MODEL = 'Session_level_list';

    /**
     * @return string the associated database table name
     */
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'session_level_list';
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
       const RELATIONS = ['session','level'];



    /**
     * The primary key of the table
     *
     * @var mixed
     */

       const PKEY = 'id_session_level';

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
			[['session_id','level_id'],'required','on'=>['create','default']],
			[['id_session_level'],'required', 'on' => 'update'],
			[['id_session_level','session_id','level_id'],'integer'],
			[['id_session_level'], 'unique' , 'on' => 'create'],
			[['session_id','level_id'], 'unique', 'targetAttribute' => ['session_id','level_id'],'on' => ['create','default']],
			[['session_id','level_id'], 'unique', 'targetAttribute' => ['session_id','level_id'],'on' => 'update','when'=> function ($model) {
                $elem = self::find()->where($model->getAttributes(['session_id','level_id']))->one();
                return !$elem ? false : $elem[$elem->primaryKey] != $model[$model->primaryKey];
            }],
        ];
    }
	 /**
     * @return \yii\db\ActiveQuery
     * @description hace referencia al campo foráneo session_id
     */
	  public function getSession()
		{
			return $this->hasOne(Sessions::class, ['id_session' => 'session_id']);
		}

	 /**
     * @return \yii\db\ActiveQuery
     * @description hace referencia al campo foráneo level_id
     */
	  public function getLevel()
		{
			return $this->hasOne(Levels::class, ['id_level' => 'level_id']);
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
        $select = ['*', 'session_level_list.id_session_level as id', 'session_level_list.id_session_level as text'];
        $result = new \stdClass();
        $result->data = [];
        if ($parameters->relations == 'all')
            $result->data = $query->select($select)->with(get_called_class()::RELATIONS);
        if (!is_null($parameters->relations) && $parameters->relations != 'all')
            $result->data = $query->select($select)->with($parameters->relations);
        if (is_null($parameters->relations))
            $result->data = $query->select($select);
        $result->data=$result->data->andWhere('session_level_list.id_session_level LIKE '."'%".$like."%'")->asArray()->all();
        return $result;

    }
}
?>
