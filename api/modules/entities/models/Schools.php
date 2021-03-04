<?php 
/**Generate by ASGENS
*@author Pulgaron  
*@date Thu Feb 25 22:09:38 GMT-05:00 2021  
*@time Thu Feb 25 22:09:38 GMT-05:00 2021  
*/
namespace api\modules\entities\models;
use Yii;
use common\models\RestModel;

use api\modules\types\models\Countries;
use api\modules\types\models\Error_level;
use api\modules\managment\models\Principal_school_list;
use api\modules\managment\models\Tests;
/**
 * Este es la clase modelo para la tabla schools.
 *
 * Los siguientes son los campos de la tabla 'schools':
 * @property integer $id_school
 * @property string $school_name
 * @property string $school_email
 * @property string $school_phone
 * @property string $school_address1
 * @property string $school_address2
 * @property string $school_city
 * @property string $school_state
 * @property integer $country_id
 * @property integer $school_zip_code
 * @property string $school_logo

 * Los siguientes son las relaciones de este modelo :

 * @property Countries $country
 * @property Error_level[] $arrayerror_level
 * @property Principal_school_list[] $arrayprincipal_school_list
 * @property Students[] $arraystudents
 * @property Teachers[] $arrayteachers
 * @property Tests[] $arraytests
 */

class Schools extends RestModel 
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
    protected $primaryKey = 'id_school';

    const MODEL = 'Schools';

    /**
     * @return string the associated database table name
     */
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'schools';
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
       const RELATIONS = ['country','arrayerror_level','arrayprincipal_school_list','arraystudents','arrayteachers','arraytests'];



    /**
     * The primary key of the table
     *
     * @var mixed
     */

       const PKEY = 'id_school';

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
			[['school_name','school_email','school_address1'],'required','on'=>['create','default']],
			[['id_school'],'required', 'on' => 'update'],
			[['id_school','country_id','school_zip_code'],'integer'],
			[['school_name','school_address1','school_address2'], 'string', 'max'=>100],
			[['school_email','school_city','school_state','school_logo'], 'string', 'max'=>50],
			[['school_phone'], 'string', 'max'=>30],
			[['id_school'], 'unique' , 'on' => 'create'],
			[['school_name'], 'unique' , 'on' => 'create'],
			[['school_email'], 'unique' , 'on' => 'create'],
			[['school_name'], 'unique' , 'on' => 'update','when' =>function ($model, $value) {
                $elem = self::find()->where([$value => $model[$value]])->one();
                return !$elem ? false : $elem[$elem->primaryKey] != $model[$model->primaryKey];
            }],
			[['school_email'], 'unique' , 'on' => 'update','when' =>function ($model, $value) {
                $elem = self::find()->where([$value => $model[$value]])->one();
                return !$elem ? false : $elem[$elem->primaryKey] != $model[$model->primaryKey];
            }],
        ];
    }
	 /**
     * @return \yii\db\ActiveQuery
     * @description hace referencia al campo foráneo country_id
     */
	  public function getCountry()
		{
			return $this->hasOne(Countries::class, ['id_country' => 'country_id']);
		}


	 /**
     * @return \yii\db\ActiveQuery
     * @description hace referencia al campo foráneo school_id
     */
	  public function getArrayerror_level()
		{
			return $this->hasMany(Error_level::class, ['school_id' => 'id_school']);
		}

	 /**
     * @return \yii\db\ActiveQuery
     * @description hace referencia al campo foráneo school_id
     */
	  public function getArrayprincipal_school_list()
		{
			return $this->hasMany(Principal_school_list::class, ['school_id' => 'id_school']);
		}

	 /**
     * @return \yii\db\ActiveQuery
     * @description hace referencia al campo foráneo school_id
     */
	  public function getArraystudents()
		{
			return $this->hasMany(Students::class, ['school_id' => 'id_school']);
		}

	 /**
     * @return \yii\db\ActiveQuery
     * @description hace referencia al campo foráneo school_id
     */
	  public function getArrayteachers()
		{
			return $this->hasMany(Teachers::class, ['school_id' => 'id_school']);
		}

	 /**
     * @return \yii\db\ActiveQuery
     * @description hace referencia al campo foráneo school_id
     */
	  public function getArraytests()
		{
			return $this->hasMany(Tests::class, ['school_id' => 'id_school']);
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
        $select = ['*', 'schools.id_school as id', 'schools.school_name as text'];
        $result = new \stdClass();
        $result->data = [];
        if ($parameters->relations == 'all')
            $result->data = $query->select($select)->with(get_called_class()::RELATIONS);
        if (!is_null($parameters->relations) && $parameters->relations != 'all')
            $result->data = $query->select($select)->with($parameters->relations);
        if (is_null($parameters->relations))
            $result->data = $query->select($select);
        $result->data=$result->data->andWhere('schools.school_name LIKE '."'%".$like."%'")->asArray()->all();
        return $result;

    }
}
?>
