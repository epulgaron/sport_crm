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
 * Este es la clase modelo para la tabla types.
 *
 * Los siguientes son los campos de la tabla 'types':
 * @property integer $id_type
 * @property string $type_acr
 * @property string $type_name

 * Los siguientes son las relaciones de este modelo :

 * @property Tests[] $arraytests
 */

class Types extends RestModel 
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
    protected $primaryKey = 'id_type';

    const MODEL = 'Types';

    /**
     * @return string the associated database table name
     */
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'types';
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

       const PKEY = 'id_type';

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
			[['type_name'],'required','on'=>['create','default']],
			[['id_type'],'required', 'on' => 'update'],
			[['id_type'],'integer'],
			[['type_acr'], 'string', 'max'=>20],
			[['type_name'], 'string', 'max'=>50],
			[['id_type'], 'unique' , 'on' => 'create'],
			[['type_name'], 'unique' , 'on' => 'create'],
			[['type_name'], 'unique' , 'on' => 'update','when' =>function ($model, $value) {
                $elem = self::find()->where([$value => $model[$value]])->one();
                return !$elem ? false : $elem[$elem->primaryKey] != $model[$model->primaryKey];
            }],
        ];
    }

	 /**
     * @return \yii\db\ActiveQuery
     * @description hace referencia al campo foráneo type_id
     */
	  public function getArraytests()
		{
			return $this->hasMany(Tests::class, ['type_id' => 'id_type']);
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
        $select = ['*', 'types.id_type as id', 'types.type_acr as text'];
        $result = new \stdClass();
        $result->data = [];
        if ($parameters->relations == 'all')
            $result->data = $query->select($select)->with(get_called_class()::RELATIONS);
        if (!is_null($parameters->relations) && $parameters->relations != 'all')
            $result->data = $query->select($select)->with($parameters->relations);
        if (is_null($parameters->relations))
            $result->data = $query->select($select);
        $result->data=$result->data->andWhere('types.type_acr LIKE '."'%".$like."%'")->asArray()->all();
        return $result;

    }
}
?>
