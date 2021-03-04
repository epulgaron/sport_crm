<?php 
/**Generate by ASGENS
*@author Pulgaron  
*@date Thu Feb 25 22:09:38 GMT-05:00 2021  
*@time Thu Feb 25 22:09:38 GMT-05:00 2021  
*/
namespace api\modules\managment\models;
use Yii;
use common\models\RestModel;

use api\modules\entities\models\Principals;
use api\modules\entities\models\Schools;
/**
 * Este es la clase modelo para la tabla principal_school_list.
 *
 * Los siguientes son los campos de la tabla 'principal_school_list':
 * @property integer $id_principal_school_list
 * @property integer $principal_id
 * @property integer $school_id

 * Los siguientes son las relaciones de este modelo :

 * @property Principals $principal
 * @property Schools $school
 */

class Principal_school_list extends RestModel 
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
    protected $primaryKey = 'id_principal_school_list';

    const MODEL = 'Principal_school_list';

    /**
     * @return string the associated database table name
     */
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'principal_school_list';
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
       const RELATIONS = ['principal','school'];



    /**
     * The primary key of the table
     *
     * @var mixed
     */

       const PKEY = 'id_principal_school_list';

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
			[['principal_id','school_id'],'required','on'=>['create','default']],
			[['id_principal_school_list'],'required', 'on' => 'update'],
			[['id_principal_school_list','principal_id','school_id'],'integer'],
			[['id_principal_school_list'], 'unique' , 'on' => 'create'],
			[['principal_id','school_id'], 'unique', 'targetAttribute' => ['principal_id','school_id'],'on' => ['create','default']],
			[['principal_id','school_id'], 'unique', 'targetAttribute' => ['principal_id','school_id'],'on' => 'update','when'=> function ($model) {
                $elem = self::find()->where($model->getAttributes(['principal_id','school_id']))->one();
                return !$elem ? false : $elem[$elem->primaryKey] != $model[$model->primaryKey];
            }],
        ];
    }
	 /**
     * @return \yii\db\ActiveQuery
     * @description hace referencia al campo foráneo principal_id
     */
	  public function getPrincipal()
		{
			return $this->hasOne(Principals::class, ['user_id' => 'principal_id']);
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
        $select = ['*', 'principal_school_list.id_principal_school_list as id', 'principal_school_list.id_principal_school_list as text'];
        $result = new \stdClass();
        $result->data = [];
        if ($parameters->relations == 'all')
            $result->data = $query->select($select)->with(get_called_class()::RELATIONS);
        if (!is_null($parameters->relations) && $parameters->relations != 'all')
            $result->data = $query->select($select)->with($parameters->relations);
        if (is_null($parameters->relations))
            $result->data = $query->select($select);
        $result->data=$result->data->andWhere('principal_school_list.id_principal_school_list LIKE '."'%".$like."%'")->asArray()->all();
        return $result;

    }
}
?>
