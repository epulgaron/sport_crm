<?php 
/**Generate by ASGENS
*@author Pulgaron  
*@date Thu Feb 25 22:09:38 GMT-05:00 2021  
*@time Thu Feb 25 22:09:38 GMT-05:00 2021  
*/
namespace api\modules\security\models;
use Yii;
use common\models\RestModel;

/**
 * Este es la clase modelo para la tabla permissions.
 *
 * Los siguientes son los campos de la tabla 'permissions':
 * @property integer $id_permission
 * @property string $permission_name
 * @property string $permission_description

 * Los siguientes son las relaciones de este modelo :

 * @property Role_permission_list[] $arrayrole_permission_list
 */

class Permissions extends RestModel 
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
    protected $primaryKey = 'id_permission';

    const MODEL = 'Permissions';

    /**
     * @return string the associated database table name
     */
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'permissions';
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
       const RELATIONS = ['arrayrole_permission_list'];



    /**
     * The primary key of the table
     *
     * @var mixed
     */

       const PKEY = 'id_permission';

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
			[['permission_name'],'required','on'=>['create','default']],
			[['id_permission'],'required', 'on' => 'update'],
			[['id_permission'],'integer'],
			[['permission_name'], 'string', 'max'=>50],
			[['permission_description'], 'string', 'max'=>65535],
			[['id_permission'], 'unique' , 'on' => 'create'],
			[['permission_name'], 'unique' , 'on' => 'create'],
			[['permission_name'], 'unique' , 'on' => 'update','when' =>function ($model, $value) {
                $elem = self::find()->where([$value => $model[$value]])->one();
                return !$elem ? false : $elem[$elem->primaryKey] != $model[$model->primaryKey];
            }],
        ];
    }

	 /**
     * @return \yii\db\ActiveQuery
     * @description hace referencia al campo foráneo permission_id
     */
	  public function getArrayrole_permission_list()
		{
			return $this->hasMany(Role_permission_list::class, ['permission_id' => 'id_permission']);
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
        $select = ['*', 'permissions.id_permission as id', 'permissions.permission_name as text'];
        $result = new \stdClass();
        $result->data = [];
        if ($parameters->relations == 'all')
            $result->data = $query->select($select)->with(get_called_class()::RELATIONS);
        if (!is_null($parameters->relations) && $parameters->relations != 'all')
            $result->data = $query->select($select)->with($parameters->relations);
        if (is_null($parameters->relations))
            $result->data = $query->select($select);
        $result->data=$result->data->andWhere('permissions.permission_name LIKE '."'%".$like."%'")->asArray()->all();
        return $result;

    }
}
?>
