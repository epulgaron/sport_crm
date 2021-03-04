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
use api\modules\managment\models\Teacher_sport_list;
use api\modules\managment\models\Test_teacher_list;
/**
 * Este es la clase modelo para la tabla teachers.
 *
 * Los siguientes son los campos de la tabla 'teachers':
 * @property integer $user_id
 * @property string $teacher_address
 * @property integer $school_id
 * @property boolean $external

 * Los siguientes son las relaciones de este modelo :

 * @property Schools $school
 * @property Users $user
 * @property Evaluation[] $arrayevaluation
 * @property Teacher_sport_list[] $arrayteacher_sport_list
 * @property Test_teacher_list[] $arraytest_teacher_list
 */

class Teachers extends RestModel 
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

    const MODEL = 'Teachers';

    /**
     * @return string the associated database table name
     */
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'teachers';
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
       const RELATIONS = ['school','user','arrayevaluation','arrayteacher_sport_list','arraytest_teacher_list'];



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
			[['user_id','school_id'],'required','on'=>['create','default']],
			[['user_id'],'required', 'on' => 'update'],
			[['user_id','school_id'],'integer'],
			[['external'],'boolean'],
			[['external'],'safe'],
			[['teacher_address'], 'string', 'max'=>100],
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
     * @description hace referencia al campo foráneo teacher_id
     */
	  public function getArrayevaluation()
		{
			return $this->hasMany(Evaluation::class, ['teacher_id' => 'user_id']);
		}

	 /**
     * @return \yii\db\ActiveQuery
     * @description hace referencia al campo foráneo teacher_id
     */
	  public function getArrayteacher_sport_list()
		{
			return $this->hasMany(Teacher_sport_list::class, ['teacher_id' => 'user_id']);
		}

	 /**
     * @return \yii\db\ActiveQuery
     * @description hace referencia al campo foráneo teacher_id
     */
	  public function getArraytest_teacher_list()
		{
			return $this->hasMany(Test_teacher_list::class, ['teacher_id' => 'user_id']);
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
        $query->innerJoin('users','users.id_user=teachers.user_id');
        $select = ['*', 'teachers.user_id as id', 'teachers.user_first_name as text'];
        $result = new \stdClass();
        $result->data = [];
        if ($parameters->relations == 'all')
            $result->data = $query->select($select)->with(get_called_class()::RELATIONS);
        if (!is_null($parameters->relations) && $parameters->relations != 'all')
            $result->data = $query->select($select)->with($parameters->relations);
        if (is_null($parameters->relations))
            $result->data = $query->select($select);
        $result->data=$result->data->andWhere('teachers.teacher_address LIKE '."'%".$like."%'")->asArray()->all();
        return $result;

    }
}
?>
