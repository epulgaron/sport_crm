<?php 
/**Generate by ASGENS
*@author Pulgaron  
*@date Thu Feb 25 22:09:38 GMT-05:00 2021  
*@time Thu Feb 25 22:09:38 GMT-05:00 2021  
*/
namespace api\modules\entities\models;
use Yii;
use common\models\RestModel;

use common\modules\security\models\Users;
use api\modules\managment\models\Evaluation;
use api\modules\managment\models\Sport_student_list;
use api\modules\managment\models\Test_student_list;
/**
 * Este es la clase modelo para la tabla students.
 *
 * Los siguientes son los campos de la tabla 'students':
 * @property integer $user_id
 * @property string $student_address1
 * @property string $student_address2
 * @property string $student_city
 * @property string $student_state
 * @property integer $student_zip_code
 * @property date $student_dob
 * @property string $student_picture
 * @property boolean $student_legal_age
 * @property string $student_tutor_first_name
 * @property string $student_tutor_last_name
 * @property string $studen_tutor_email
 * @property integer $school_id

 * Los siguientes son las relaciones de este modelo :

 * @property Schools $school
 * @property Users $user
 * @property Evaluation[] $arrayevaluation
 * @property Sport_student_list[] $arraysport_student_list
 * @property Test_student_list[] $arraytest_student_list
 */

class Students extends RestModel 
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
    protected $primaryKey = 'user_id';

    const MODEL = 'Students';

    /**
     * @return string the associated database table name
     */
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'students';
    }

     
    /**
     * /**
     * Parents and the relation attributes
     * class:namespace of the parent class
     * pkey of the chidren class:pkey of the parent class
     * @var array
     */
       const PARENT = ["class" => "common\modules\security\models\Users", "user_id" => "id_user"];

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
       const RELATIONS = ['school','user','arrayevaluation','arraysport_student_list','arraytest_student_list'];



    /**
     * The primary key of the table
     *
     * @var mixed
     */

       const PKEY = 'user_id';

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
			[['user_id','student_address1','student_tutor_first_name','school_id'],'required','on'=>['create','default']],
			[['user_id'],'required', 'on' => 'update'],
			[['user_id','student_zip_code','school_id'],'integer'],
			[['student_legal_age'],'boolean'],
			[['student_dob'],'safe'],
			['student_dob','format_student_dob'],
			[['student_legal_age'],'safe'],
			[['student_address1','student_address2'], 'string', 'max'=>100],
			[['student_city','student_state','student_picture','student_tutor_first_name','student_tutor_last_name','studen_tutor_email'], 'string', 'max'=>50],
			[['user_id'], 'unique' , 'on' => 'create'],
        ];
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
     * @description hace referencia al campo foráneo user_id
     */
	  public function getUser()
		{
			return $this->hasOne(Users::class, ['id_user' => 'user_id']);
		}


	 /**
     * @return \yii\db\ActiveQuery
     * @description hace referencia al campo foráneo student_id
     */
	  public function getArrayevaluation()
		{
			return $this->hasMany(Evaluation::class, ['student_id' => 'user_id']);
		}

	 /**
     * @return \yii\db\ActiveQuery
     * @description hace referencia al campo foráneo student_id
     */
	  public function getArraysport_student_list()
		{
			return $this->hasMany(Sport_student_list::class, ['student_id' => 'user_id']);
		}

	 /**
     * @return \yii\db\ActiveQuery
     * @description hace referencia al campo foráneo student_id
     */
	  public function getArraytest_student_list()
		{
			return $this->hasMany(Test_student_list::class, ['student_id' => 'user_id']);
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
        $query->innerJoin('users','users.id_user=students.user_id');
        $select = ['*', 'students.user_id as id', 'students.user_first_name as text'];
        $result = new \stdClass();
        $result->data = [];
        if ($parameters->relations == 'all')
            $result->data = $query->select($select)->with(get_called_class()::RELATIONS);
        if (!is_null($parameters->relations) && $parameters->relations != 'all')
            $result->data = $query->select($select)->with($parameters->relations);
        if (is_null($parameters->relations))
            $result->data = $query->select($select);
        $result->data=$result->data->andWhere('students.student_address1 LIKE '."'%".$like."%'")->asArray()->all();
        return $result;

    }
   public function format_student_dob(){
        $timestamp = str_replace('/', '-', $this->student_dob);
        $this->student_dob = date('Y-m-d h:i:s', strtotime($timestamp));
    }
}
?>
