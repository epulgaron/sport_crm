<?php 
/**Generate by ASGENS
*@author Pulgaron  
*@date Thu Feb 25 22:09:38 GMT-05:00 2021  
*@time Thu Feb 25 22:09:38 GMT-05:00 2021  
*/
namespace api\modules\types\models;
use Yii;
use common\models\RestModel;

use api\modules\managment\models\Tests;
/**
 * Este es la clase modelo para la tabla status.
 *
 * Los siguientes son los campos de la tabla 'status':
 * @property integer $id_status
 * @property string $status_acr
 * @property string $status_name

 * Los siguientes son las relaciones de este modelo :

 * @property Tests[] $arraytests
 */

class Status extends RestModel 
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
    protected $primaryKey = 'id_status';

    const MODEL = 'Status';

    /**
     * @return string the associated database table name
     */
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'status';
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
       const RELATIONS = ['arraytests'];



    /**
     * The primary key of the table
     *
     * @var mixed
     */

       const PKEY = 'id_status';

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
			[['status_name'],'required','on'=>['create','default']],
			[['id_status'],'required', 'on' => 'update'],
			[['id_status'],'integer'],
			[['status_acr'], 'string', 'max'=>20],
			[['status_name'], 'string', 'max'=>50],
			[['id_status'], 'unique' , 'on' => 'create'],
			[['status_name'], 'unique' , 'on' => 'create'],
			[['status_name'], 'unique' , 'on' => 'update','when' =>function ($model, $value) {
                $elem = self::find()->where([$value => $model[$value]])->one();
                return !$elem ? false : $elem[$elem->primaryKey] != $model[$model->primaryKey];
            }],
        ];
    }

	 /**
     * @return \yii\db\ActiveQuery
     * @description hace referencia al campo foráneo status_id
     */
	  public function getArraytests()
		{
			return $this->hasMany(Tests::class, ['status_id' => 'id_status']);
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
        $select = ['*', 'status.id_status as id', 'status.status_acr as text'];
        $result = new \stdClass();
        $result->data = [];
        if ($parameters->relations == 'all')
            $result->data = $query->select($select)->with(get_called_class()::RELATIONS);
        if (!is_null($parameters->relations) && $parameters->relations != 'all')
            $result->data = $query->select($select)->with($parameters->relations);
        if (is_null($parameters->relations))
            $result->data = $query->select($select);
        $result->data=$result->data->andWhere('status.status_acr LIKE '."'%".$like."%'")->asArray()->all();
        return $result;

    }
}
?>
