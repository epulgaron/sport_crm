<?php 
/**Generate by ASGENS
*@author Pulgaron  
*@date Thu Feb 25 22:09:38 GMT-05:00 2021  
*@time Thu Feb 25 22:09:38 GMT-05:00 2021  
*/
namespace common\modules\security\models;
use Yii;
use common\models\RestModel;

use api\modules\security\models\Role_permission_list;
/**
 * Este es la clase modelo para la tabla roles.
 *
 * Los siguientes son los campos de la tabla 'roles':
 * @property integer $id_role
 * @property string $role_name
 * @property string $role_description

 * Los siguientes son las relaciones de este modelo :

 * @property Role_permission_list[] $arrayrole_permission_list
 * @property Users[] $arrayusers
 */

class Roles extends RestModel 
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
    protected $primaryKey = 'id_role';

    const MODEL = 'Roles';

    /**
     * @return string the associated database table name
     */
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'roles';
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
       const RELATIONS = ['arrayrole_permission_list','arrayusers'];



    /**
     * The primary key of the table
     *
     * @var mixed
     */

       const PKEY = 'id_role';

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
			[['role_name'],'required','on'=>['create','default']],
			[['id_role'],'required', 'on' => 'update'],
			[['id_role'],'integer'],
			[['role_name'], 'string', 'max'=>20],
			[['role_description'], 'string', 'max'=>65535],
			[['id_role'], 'unique' , 'on' => 'create'],
			[['role_name'], 'unique' , 'on' => 'create'],
			[['role_name'], 'unique' , 'on' => 'update','when' =>function ($model, $value) {
                $elem = self::find()->where([$value => $model[$value]])->one();
                return !$elem ? false : $elem[$elem->primaryKey] != $model[$model->primaryKey];
            }],
        ];
    }

	 /**
     * @return \yii\db\ActiveQuery
     * @description hace referencia al campo foráneo role_id
     */
	  public function getArrayrole_permission_list()
		{
			return $this->hasMany(Role_permission_list::class, ['role_id' => 'id_role']);
		}

	 /**
     * @return \yii\db\ActiveQuery
     * @description hace referencia al campo foráneo role_id
     */
	  public function getArrayusers()
		{
			return $this->hasMany(Users::class, ['role_id' => 'id_role']);
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
        $select = ['*', 'roles.id_role as id', 'roles.role_name as text'];
        $result = new \stdClass();
        $result->data = [];
        if ($parameters->relations == 'all')
            $result->data = $query->select($select)->with(get_called_class()::RELATIONS);
        if (!is_null($parameters->relations) && $parameters->relations != 'all')
            $result->data = $query->select($select)->with($parameters->relations);
        if (is_null($parameters->relations))
            $result->data = $query->select($select);
        $result->data=$result->data->andWhere('roles.role_name LIKE '."'%".$like."%'")->asArray()->all();
        return $result;

    }
}
?>
