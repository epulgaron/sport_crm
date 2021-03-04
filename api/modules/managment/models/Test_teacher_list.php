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
/**
 * Este es la clase modelo para la tabla test_teacher_list.
 *
 * Los siguientes son los campos de la tabla 'test_teacher_list':
 * @property integer $id_test_teacher_list
 * @property integer $test_id
 * @property integer $teacher_id

 * Los siguientes son las relaciones de este modelo :

 * @property Tests $test
 * @property Teachers $teacher
 */

class Test_teacher_list extends RestModel 
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
    protected $primaryKey = 'id_test_teacher_list';

    const MODEL = 'Test_teacher_list';

    /**
     * @return string the associated database table name
     */
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'test_teacher_list';
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
       const RELATIONS = ['test','teacher'];



    /**
     * The primary key of the table
     *
     * @var mixed
     */

       const PKEY = 'id_test_teacher_list';

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
			[['test_id','teacher_id'],'required','on'=>['create','default']],
			[['id_test_teacher_list'],'required', 'on' => 'update'],
			[['id_test_teacher_list','test_id','teacher_id'],'integer'],
			[['id_test_teacher_list'], 'unique' , 'on' => 'create'],
			[['test_id','teacher_id'], 'unique', 'targetAttribute' => ['test_id','teacher_id'],'on' => ['create','default']],
			[['test_id','teacher_id'], 'unique', 'targetAttribute' => ['test_id','teacher_id'],'on' => 'update','when'=> function ($model) {
                $elem = self::find()->where($model->getAttributes(['test_id','teacher_id']))->one();
                return !$elem ? false : $elem[$elem->primaryKey] != $model[$model->primaryKey];
            }],
        ];
    }
	 /**
     * @return \yii\db\ActiveQuery
     * @description hace referencia al campo foráneo test_id
     */
	  public function getTest()
		{
			return $this->hasOne(Tests::class, ['id_test' => 'test_id']);
		}

	 /**
     * @return \yii\db\ActiveQuery
     * @description hace referencia al campo foráneo teacher_id
     */
	  public function getTeacher()
		{
			return $this->hasOne(Teachers::class, ['user_id' => 'teacher_id']);
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
        $select = ['*', 'test_teacher_list.id_test_teacher_list as id', 'test_teacher_list.id_test_teacher_list as text'];
        $result = new \stdClass();
        $result->data = [];
        if ($parameters->relations == 'all')
            $result->data = $query->select($select)->with(get_called_class()::RELATIONS);
        if (!is_null($parameters->relations) && $parameters->relations != 'all')
            $result->data = $query->select($select)->with($parameters->relations);
        if (is_null($parameters->relations))
            $result->data = $query->select($select);
        $result->data=$result->data->andWhere('test_teacher_list.id_test_teacher_list LIKE '."'%".$like."%'")->asArray()->all();
        return $result;

    }
}
?>
