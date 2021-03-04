<?php 
/**Generate by ASGENS
*@author Pulgaron  
*@date Thu Feb 25 22:09:38 GMT-05:00 2021  
*@time Thu Feb 25 22:09:38 GMT-05:00 2021  
*/
namespace api\modules\entities\models;
use Yii;
use common\models\RestModel;

use api\modules\managment\models\Content_error_list;
use api\modules\managment\models\Error_level_list;
/**
 * Este es la clase modelo para la tabla errors.
 *
 * Los siguientes son los campos de la tabla 'errors':
 * @property integer $id_error
 * @property string $error_name
 * @property string $recomendacion

 * Los siguientes son las relaciones de este modelo :

 * @property Content_error_list[] $arraycontent_error_list
 * @property Error_level_list[] $arrayerror_level_list
 */

class Errors extends RestModel 
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
    protected $primaryKey = 'id_error';

    const MODEL = 'Errors';

    /**
     * @return string the associated database table name
     */
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'errors';
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
       const RELATIONS = ['arraycontent_error_list','arrayerror_level_list'];



    /**
     * The primary key of the table
     *
     * @var mixed
     */

       const PKEY = 'id_error';

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
			[['error_name'],'required','on'=>['create','default']],
			[['id_error'],'required', 'on' => 'update'],
			[['id_error'],'integer'],
			[['error_name'], 'string', 'max'=>50],
			[['recomendacion'], 'string', 'max'=>65535],
			[['id_error'], 'unique' , 'on' => 'create'],
        ];
    }

	 /**
     * @return \yii\db\ActiveQuery
     * @description hace referencia al campo foráneo error_id
     */
	  public function getArraycontent_error_list()
		{
			return $this->hasMany(Content_error_list::class, ['error_id' => 'id_error']);
		}

	 /**
     * @return \yii\db\ActiveQuery
     * @description hace referencia al campo foráneo error_id
     */
	  public function getArrayerror_level_list()
		{
			return $this->hasMany(Error_level_list::class, ['error_id' => 'id_error']);
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
        $select = ['*', 'errors.id_error as id', 'errors.error_name as text'];
        $result = new \stdClass();
        $result->data = [];
        if ($parameters->relations == 'all')
            $result->data = $query->select($select)->with(get_called_class()::RELATIONS);
        if (!is_null($parameters->relations) && $parameters->relations != 'all')
            $result->data = $query->select($select)->with($parameters->relations);
        if (is_null($parameters->relations))
            $result->data = $query->select($select);
        $result->data=$result->data->andWhere('errors.error_name LIKE '."'%".$like."%'")->asArray()->all();
        return $result;

    }
}
?>
