<?php 
/**Generate by ASGENS
*@author Pulgaron  
*@date Thu Feb 25 22:09:38 GMT-05:00 2021  
*@time Thu Feb 25 22:09:38 GMT-05:00 2021  
*/
namespace api\modules\managment\models;
use Yii;
use common\models\RestModel;

use api\modules\entities\models\Teachers;
use api\modules\types\models\Sports;
/**
 * Este es la clase modelo para la tabla teacher_sport_list.
 *
 * Los siguientes son los campos de la tabla 'teacher_sport_list':
 * @property integer $id_teacher_sport_list
 * @property integer $teacher_id
 * @property integer $sport_id

 * Los siguientes son las relaciones de este modelo :

 * @property Teachers $teacher
 * @property Sports $sport
 */

class Teacher_sport_list extends RestModel 
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
    protected $primaryKey = 'id_teacher_sport_list';

    const MODEL = 'Teacher_sport_list';

    /**
     * @return string the associated database table name
     */
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'teacher_sport_list';
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
       const RELATIONS = ['teacher','sport'];



    /**
     * The primary key of the table
     *
     * @var mixed
     */

       const PKEY = 'id_teacher_sport_list';

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
			[['teacher_id','sport_id'],'required','on'=>['create','default']],
			[['id_teacher_sport_list'],'required', 'on' => 'update'],
			[['id_teacher_sport_list','teacher_id','sport_id'],'integer'],
			[['id_teacher_sport_list'], 'unique' , 'on' => 'create'],
			[['teacher_id','sport_id'], 'unique', 'targetAttribute' => ['teacher_id','sport_id'],'on' => ['create','default']],
			[['teacher_id','sport_id'], 'unique', 'targetAttribute' => ['teacher_id','sport_id'],'on' => 'update','when'=> function ($model) {
                $elem = self::find()->where($model->getAttributes(['teacher_id','sport_id']))->one();
                return !$elem ? false : $elem[$elem->primaryKey] != $model[$model->primaryKey];
            }],
        ];
    }
	 /**
     * @return \yii\db\ActiveQuery
     * @description hace referencia al campo for??neo teacher_id
     */
	  public function getTeacher()
		{
			return $this->hasOne(Teachers::class, ['user_id' => 'teacher_id']);
		}

	 /**
     * @return \yii\db\ActiveQuery
     * @description hace referencia al campo for??neo sport_id
     */
	  public function getSport()
		{
			return $this->hasOne(Sports::class, ['id_sport' => 'sport_id']);
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
        $select = ['*', 'teacher_sport_list.id_teacher_sport_list as id', 'teacher_sport_list.id_teacher_sport_list as text'];
        $result = new \stdClass();
        $result->data = [];
        if ($parameters->relations == 'all')
            $result->data = $query->select($select)->with(get_called_class()::RELATIONS);
        if (!is_null($parameters->relations) && $parameters->relations != 'all')
            $result->data = $query->select($select)->with($parameters->relations);
        if (is_null($parameters->relations))
            $result->data = $query->select($select);
        $result->data=$result->data->andWhere('teacher_sport_list.id_teacher_sport_list LIKE '."'%".$like."%'")->asArray()->all();
        return $result;

    }
}
?>
