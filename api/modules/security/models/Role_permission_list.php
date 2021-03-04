<?php 
/**Generate by ASGENS
*@author Pulgaron  
*@date Thu Feb 25 22:09:38 GMT-05:00 2021  
*@time Thu Feb 25 22:09:38 GMT-05:00 2021  
*/
namespace api\modules\security\models;
use Yii;
use common\models\RestModel;

use common\modules\security\models\Roles;
/**
 * Este es la clase modelo para la tabla role_permission_list.
 *
 * Los siguientes son los campos de la tabla 'role_permission_list':
 * @property integer $id_role_permission
 * @property integer $role_id
 * @property integer $permission_id

 * Los siguientes son las relaciones de este modelo :

 * @property Roles $role
 * @property Permissions $permission
 */

class Role_permission_list extends RestModel 
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
    protected $primaryKey = 'id_role_permission';

    const MODEL = 'Role_permission_list';

    /**
     * @return string the associated database table name
     */
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'role_permission_list';
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
       const RELATIONS = ['role','permission'];



    /**
     * The primary key of the table
     *
     * @var mixed
     */

       const PKEY = 'id_role_permission';

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
			[['role_id','permission_id'],'required','on'=>['create','default']],
			[['id_role_permission'],'required', 'on' => 'update'],
			[['id_role_permission','role_id','permission_id'],'integer'],
			[['id_role_permission'], 'unique' , 'on' => 'create'],
			[['role_id','permission_id'], 'unique', 'targetAttribute' => ['role_id','permission_id'],'on' => ['create','default']],
			[['role_id','permission_id'], 'unique', 'targetAttribute' => ['role_id','permission_id'],'on' => 'update','when'=> function ($model) {
                $elem = self::find()->where($model->getAttributes(['role_id','permission_id']))->one();
                return !$elem ? false : $elem[$elem->primaryKey] != $model[$model->primaryKey];
            }],
        ];
    }
	 /**
     * @return \yii\db\ActiveQuery
     * @description hace referencia al campo foráneo role_id
     */
	  public function getRole()
		{
			return $this->hasOne(Roles::class, ['id_role' => 'role_id']);
		}

	 /**
     * @return \yii\db\ActiveQuery
     * @description hace referencia al campo foráneo permission_id
     */
	  public function getPermission()
		{
			return $this->hasOne(Permissions::class, ['id_permission' => 'permission_id']);
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
        $select = ['*', 'role_permission_list.id_role_permission as id', 'role_permission_list.id_role_permission as text'];
        $result = new \stdClass();
        $result->data = [];
        if ($parameters->relations == 'all')
            $result->data = $query->select($select)->with(get_called_class()::RELATIONS);
        if (!is_null($parameters->relations) && $parameters->relations != 'all')
            $result->data = $query->select($select)->with($parameters->relations);
        if (is_null($parameters->relations))
            $result->data = $query->select($select);
        $result->data=$result->data->andWhere('role_permission_list.id_role_permission LIKE '."'%".$like."%'")->asArray()->all();
        return $result;

    }
}
?>
