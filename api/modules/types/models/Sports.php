<?php 
/**Generate by ASGENS
*@author Pulgaron  
*@date Thu Feb 25 22:09:38 GMT-05:00 2021  
*@time Thu Feb 25 22:09:38 GMT-05:00 2021  
*/
namespace api\modules\types\models;
use Yii;
use common\models\RestModel;

use api\modules\entities\models\Sessions;
use api\modules\managment\models\Sport_student_list;
use api\modules\managment\models\Teacher_sport_list;
use api\modules\managment\models\Tests;
/**
 * Este es la clase modelo para la tabla sports.
 *
 * Los siguientes son los campos de la tabla 'sports':
 * @property integer $id_sport
 * @property string $sport_name

 * Los siguientes son las relaciones de este modelo :

 * @property Contents[] $arraycontents
 * @property Error_level[] $arrayerror_level
 * @property Levels[] $arraylevels
 * @property Sessions[] $arraysessions
 * @property Sport_student_list[] $arraysport_student_list
 * @property Teacher_sport_list[] $arrayteacher_sport_list
 * @property Tests[] $arraytests
 */

class Sports extends RestModel 
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
    protected $primaryKey = 'id_sport';

    const MODEL = 'Sports';

    /**
     * @return string the associated database table name
     */
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sports';
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
       const RELATIONS = ['arraycontents','arrayerror_level','arraylevels','arraysessions','arraysport_student_list','arrayteacher_sport_list','arraytests'];



    /**
     * The primary key of the table
     *
     * @var mixed
     */

       const PKEY = 'id_sport';

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
			[['sport_name'],'required','on'=>['create','default']],
			[['id_sport'],'required', 'on' => 'update'],
			[['id_sport'],'integer'],
			[['sport_name'], 'string', 'max'=>50],
			[['id_sport'], 'unique' , 'on' => 'create'],
			[['sport_name'], 'unique' , 'on' => 'create'],
			[['sport_name'], 'unique' , 'on' => 'update','when' =>function ($model, $value) {
                $elem = self::find()->where([$value => $model[$value]])->one();
                return !$elem ? false : $elem[$elem->primaryKey] != $model[$model->primaryKey];
            }],
        ];
    }

	 /**
     * @return \yii\db\ActiveQuery
     * @description hace referencia al campo foráneo sport_id
     */
	  public function getArraycontents()
		{
			return $this->hasMany(Contents::class, ['sport_id' => 'id_sport']);
		}

	 /**
     * @return \yii\db\ActiveQuery
     * @description hace referencia al campo foráneo sport_id
     */
	  public function getArrayerror_level()
		{
			return $this->hasMany(Error_level::class, ['sport_id' => 'id_sport']);
		}

	 /**
     * @return \yii\db\ActiveQuery
     * @description hace referencia al campo foráneo sport_id
     */
	  public function getArraylevels()
		{
			return $this->hasMany(Levels::class, ['sport_id' => 'id_sport']);
		}

	 /**
     * @return \yii\db\ActiveQuery
     * @description hace referencia al campo foráneo sport_id
     */
	  public function getArraysessions()
		{
			return $this->hasMany(Sessions::class, ['sport_id' => 'id_sport']);
		}

	 /**
     * @return \yii\db\ActiveQuery
     * @description hace referencia al campo foráneo sport_id
     */
	  public function getArraysport_student_list()
		{
			return $this->hasMany(Sport_student_list::class, ['sport_id' => 'id_sport']);
		}

	 /**
     * @return \yii\db\ActiveQuery
     * @description hace referencia al campo foráneo sport_id
     */
	  public function getArrayteacher_sport_list()
		{
			return $this->hasMany(Teacher_sport_list::class, ['sport_id' => 'id_sport']);
		}

	 /**
     * @return \yii\db\ActiveQuery
     * @description hace referencia al campo foráneo sport_id
     */
	  public function getArraytests()
		{
			return $this->hasMany(Tests::class, ['sport_id' => 'id_sport']);
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
        $select = ['*', 'sports.id_sport as id', 'sports.sport_name as text'];
        $result = new \stdClass();
        $result->data = [];
        if ($parameters->relations == 'all')
            $result->data = $query->select($select)->with(get_called_class()::RELATIONS);
        if (!is_null($parameters->relations) && $parameters->relations != 'all')
            $result->data = $query->select($select)->with($parameters->relations);
        if (is_null($parameters->relations))
            $result->data = $query->select($select);
        $result->data=$result->data->andWhere('sports.sport_name LIKE '."'%".$like."%'")->asArray()->all();
        return $result;

    }
}
?>
