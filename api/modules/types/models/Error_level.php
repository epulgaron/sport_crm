<?php 
/**Generate by ASGENS
*@author Pulgaron  
*@date Thu Feb 25 22:09:38 GMT-05:00 2021  
*@time Thu Feb 25 22:09:38 GMT-05:00 2021  
*/
namespace api\modules\types\models;
use Yii;
use common\models\RestModel;

use api\modules\entities\models\Schools;
use api\modules\managment\models\Error_level_list;
/**
 * Este es la clase modelo para la tabla error_level.
 *
 * Los siguientes son los campos de la tabla 'error_level':
 * @property integer $id_error_level
 * @property string $error_level_name
 * @property integer $error_level_eval
 * @property integer $school_id
 * @property integer $sport_id

 * Los siguientes son las relaciones de este modelo :

 * @property Schools $school
 * @property Sports $sport
 * @property Error_level_list[] $arrayerror_level_list
 */

class Error_level extends RestModel 
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
    protected $primaryKey = 'id_error_level';

    const MODEL = 'Error_level';

    /**
     * @return string the associated database table name
     */
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'error_level';
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
       const RELATIONS = ['school','sport','arrayerror_level_list'];



    /**
     * The primary key of the table
     *
     * @var mixed
     */

       const PKEY = 'id_error_level';

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
			[['error_level_name','error_level_eval','school_id','sport_id'],'required','on'=>['create','default']],
			[['id_error_level'],'required', 'on' => 'update'],
			[['id_error_level','error_level_eval','school_id','sport_id'],'integer'],
            [['error_level_name'], 'string', 'max'=>100],
			[['id_error_level'], 'unique' , 'on' => 'create'],
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
     * @description hace referencia al campo foráneo sport_id
     */
	  public function getSport()
		{
			return $this->hasOne(Sports::class, ['id_sport' => 'sport_id']);
		}


	 /**
     * @return \yii\db\ActiveQuery
     * @description hace referencia al campo foráneo error_level_id
     */
	  public function getArrayerror_level_list()
		{
			return $this->hasMany(Error_level_list::class, ['error_level_id' => 'id_error_level']);
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
        $select = ['*', 'error_level.id_error_level as id', 'error_level.error_level_name as text'];
        $result = new \stdClass();
        $result->data = [];
        if ($parameters->relations == 'all')
            $result->data = $query->select($select)->with(get_called_class()::RELATIONS);
        if (!is_null($parameters->relations) && $parameters->relations != 'all')
            $result->data = $query->select($select)->with($parameters->relations);
        if (is_null($parameters->relations))
            $result->data = $query->select($select);
        $result->data=$result->data->andWhere('error_level.error_level_name LIKE '."'%".$like."%'")->asArray()->all();
        return $result;

    }
}
?>
