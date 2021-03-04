<?php 
/**Generate by ASGENS
*@author Pulgaron  
*@date Thu Feb 25 22:09:38 GMT-05:00 2021  
*@time Thu Feb 25 22:09:38 GMT-05:00 2021  
*/
namespace api\modules\managment\models;
use Yii;
use common\models\RestModel;

use api\modules\types\models\Status;
use api\modules\types\models\Flows;
use api\modules\entities\models\Schools;
use api\modules\types\models\Sports;
use api\modules\types\models\Types;
/**
 * Este es la clase modelo para la tabla tests.
 *
 * Los siguientes son los campos de la tabla 'tests':
 * @property integer $id_test
 * @property integer $test_name
 * @property date $test_date
 * @property integer $flow_id
 * @property integer $sport_id
 * @property integer $type_id
 * @property integer $school_id
 * @property integer $status_id
 * @property date $final_date

 * Los siguientes son las relaciones de este modelo :

 * @property Status $status
 * @property Flows $flow
 * @property Schools $school
 * @property Sports $sport
 * @property Types $type
 * @property Evaluation[] $arrayevaluation
 * @property Test_level_list[] $arraytest_level_list
 * @property Test_session_list[] $arraytest_session_list
 * @property Test_student_list[] $arraytest_student_list
 * @property Test_teacher_list[] $arraytest_teacher_list
 */

class Tests extends RestModel 
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
    protected $primaryKey = 'id_test';

    const MODEL = 'Tests';

    /**
     * @return string the associated database table name
     */
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tests';
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
       const RELATIONS = ['status','flow','school','sport','type','arrayevaluation','arraytest_level_list','arraytest_session_list','arraytest_student_list','arraytest_teacher_list'];



    /**
     * The primary key of the table
     *
     * @var mixed
     */

       const PKEY = 'id_test';

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
			[['test_name','test_date','flow_id','sport_id','type_id','school_id','status_id'],'required','on'=>['create','default']],
			[['id_test'],'required', 'on' => 'update'],
			[['id_test','test_name','flow_id','sport_id','type_id','school_id','status_id'],'integer'],
			[['test_date','final_date'],'safe'],
			['test_date','format_test_date'],
			['final_date','format_final_date'],
			[['id_test'], 'unique' , 'on' => 'create'],
        ];
    }
	 /**
     * @return \yii\db\ActiveQuery
     * @description hace referencia al campo foráneo status_id
     */
	  public function getStatus()
		{
			return $this->hasOne(Status::class, ['id_status' => 'status_id']);
		}

	 /**
     * @return \yii\db\ActiveQuery
     * @description hace referencia al campo foráneo flow_id
     */
	  public function getFlow()
		{
			return $this->hasOne(Flows::class, ['id_flow' => 'flow_id']);
		}

	 /**
     * @return \yii\db\ActiveQuery
     * @description hace referencia al campo foráneo school_id
     */
	  public function getSchool()
		{
			return $this->hasOne(Schools::class, ['id_school' => 'school_id']);
		}

	 /**
     * @return \yii\db\ActiveQuery
     * @description hace referencia al campo foráneo sport_id
     */
	  public function getSport()
		{
			return $this->hasOne(Sports::class, ['id_sport' => 'sport_id']);
		}

	 /**
     * @return \yii\db\ActiveQuery
     * @description hace referencia al campo foráneo type_id
     */
	  public function getType()
		{
			return $this->hasOne(Types::class, ['id_type' => 'type_id']);
		}


	 /**
     * @return \yii\db\ActiveQuery
     * @description hace referencia al campo foráneo test_id
     */
	  public function getArrayevaluation()
		{
			return $this->hasMany(Evaluation::class, ['test_id' => 'id_test']);
		}

	 /**
     * @return \yii\db\ActiveQuery
     * @description hace referencia al campo foráneo test_id
     */
	  public function getArraytest_level_list()
		{
			return $this->hasMany(Test_level_list::class, ['test_id' => 'id_test']);
		}

	 /**
     * @return \yii\db\ActiveQuery
     * @description hace referencia al campo foráneo test_id
     */
	  public function getArraytest_session_list()
		{
			return $this->hasMany(Test_session_list::class, ['test_id' => 'id_test']);
		}

	 /**
     * @return \yii\db\ActiveQuery
     * @description hace referencia al campo foráneo test_id
     */
	  public function getArraytest_student_list()
		{
			return $this->hasMany(Test_student_list::class, ['test_id' => 'id_test']);
		}

	 /**
     * @return \yii\db\ActiveQuery
     * @description hace referencia al campo foráneo test_id
     */
	  public function getArraytest_teacher_list()
		{
			return $this->hasMany(Test_teacher_list::class, ['test_id' => 'id_test']);
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
        $select = ['*', 'tests.id_test as id', 'tests.id_test as text'];
        $result = new \stdClass();
        $result->data = [];
        if ($parameters->relations == 'all')
            $result->data = $query->select($select)->with(get_called_class()::RELATIONS);
        if (!is_null($parameters->relations) && $parameters->relations != 'all')
            $result->data = $query->select($select)->with($parameters->relations);
        if (is_null($parameters->relations))
            $result->data = $query->select($select);
        $result->data=$result->data->andWhere('tests.id_test LIKE '."'%".$like."%'")->asArray()->all();
        return $result;

    }
   public function format_test_date(){
        $timestamp = str_replace('/', '-', $this->test_date);
        $this->test_date = date('Y-m-d h:i:s', strtotime($timestamp));
    }
   public function format_final_date(){
        $timestamp = str_replace('/', '-', $this->final_date);
        $this->final_date = date('Y-m-d h:i:s', strtotime($timestamp));
    }
}
?>
