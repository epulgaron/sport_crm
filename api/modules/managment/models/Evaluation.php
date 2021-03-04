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
use api\modules\types\models\Levels;
use api\modules\entities\models\Sessions;
use api\modules\entities\models\Students;
/**
 * Este es la clase modelo para la tabla evaluation.
 *
 * Los siguientes son los campos de la tabla 'evaluation':
 * @property integer $id_eval
 * @property integer $test_id
 * @property integer $level_id
 * @property integer $session_id
 * @property integer $student_id
 * @property integer $teacher_id
 * @property integer $score

 * Los siguientes son las relaciones de este modelo :

 * @property Teachers $teacher
 * @property Tests $test
 * @property Levels $level
 * @property Sessions $session
 * @property Students $student
 * @property Error_level_list[] $arrayerror_level_list
 */

class Evaluation extends RestModel 
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
    protected $primaryKey = 'id_eval';

    const MODEL = 'Evaluation';

    /**
     * @return string the associated database table name
     */
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'evaluation';
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
       const RELATIONS = ['teacher','test','level','session','student','arrayerror_level_list'];



    /**
     * The primary key of the table
     *
     * @var mixed
     */

       const PKEY = 'id_eval';

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
			[['test_id','level_id','session_id','student_id','teacher_id','score'],'required','on'=>['create','default']],
			[['id_eval'],'required', 'on' => 'update'],
			[['id_eval','test_id','level_id','session_id','student_id','teacher_id','score'],'integer'],
			[['id_eval'], 'unique' , 'on' => 'create'],
        ];
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
     * @return \yii\db\ActiveQuery
     * @description hace referencia al campo foráneo test_id
     */
	  public function getTest()
		{
			return $this->hasOne(Tests::class, ['id_test' => 'test_id']);
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
     * @return \yii\db\ActiveQuery
     * @description hace referencia al campo foráneo session_id
     */
	  public function getSession()
		{
			return $this->hasOne(Sessions::class, ['id_session' => 'session_id']);
		}

	 /**
     * @return \yii\db\ActiveQuery
     * @description hace referencia al campo foráneo student_id
     */
	  public function getStudent()
		{
			return $this->hasOne(Students::class, ['user_id' => 'student_id']);
		}


	 /**
     * @return \yii\db\ActiveQuery
     * @description hace referencia al campo foráneo eval_id
     */
	  public function getArrayerror_level_list()
		{
			return $this->hasMany(Error_level_list::class, ['eval_id' => 'id_eval']);
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
        $select = ['*', 'evaluation.id_eval as id', 'evaluation.id_eval as text'];
        $result = new \stdClass();
        $result->data = [];
        if ($parameters->relations == 'all')
            $result->data = $query->select($select)->with(get_called_class()::RELATIONS);
        if (!is_null($parameters->relations) && $parameters->relations != 'all')
            $result->data = $query->select($select)->with($parameters->relations);
        if (is_null($parameters->relations))
            $result->data = $query->select($select);
        $result->data=$result->data->andWhere('evaluation.id_eval LIKE '."'%".$like."%'")->asArray()->all();
        return $result;

    }
}
?>
