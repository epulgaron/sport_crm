<?php 
/**Generate by ASGENS
*@author Pulgaron  
*@date Thu Feb 25 22:09:38 GMT-05:00 2021  
*@time Thu Feb 25 22:09:38 GMT-05:00 2021  
*/
namespace api\modules\managment\models;
use Yii;
use common\models\RestModel;

use api\modules\types\models\Contents;
use api\modules\types\models\Levels;
/**
 * Este es la clase modelo para la tabla content_level_list.
 *
 * Los siguientes son los campos de la tabla 'content_level_list':
 * @property integer $id_content_level_list
 * @property integer $content_id
 * @property integer $level_id

 * Los siguientes son las relaciones de este modelo :

 * @property Contents $content
 * @property Levels $level
 */

class Content_level_list extends RestModel 
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
    protected $primaryKey = 'id_content_level_list';

    const MODEL = 'Content_level_list';

    /**
     * @return string the associated database table name
     */
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'content_level_list';
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
       const RELATIONS = ['content','level'];



    /**
     * The primary key of the table
     *
     * @var mixed
     */

       const PKEY = 'id_content_level_list';

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
			[['content_id','level_id'],'required','on'=>['create','default']],
			[['id_content_level_list'],'required', 'on' => 'update'],
			[['id_content_level_list','content_id','level_id'],'integer'],
			[['id_content_level_list'], 'unique' , 'on' => 'create'],
			[['content_id','level_id'], 'unique', 'targetAttribute' => ['content_id','level_id'],'on' => ['create','default']],
			[['content_id','level_id'], 'unique', 'targetAttribute' => ['content_id','level_id'],'on' => 'update','when'=> function ($model) {
                $elem = self::find()->where($model->getAttributes(['content_id','level_id']))->one();
                return !$elem ? false : $elem[$elem->primaryKey] != $model[$model->primaryKey];
            }],
        ];
    }
	 /**
     * @return \yii\db\ActiveQuery
     * @description hace referencia al campo for??neo content_id
     */
	  public function getContent()
		{
			return $this->hasOne(Contents::class, ['id_content' => 'content_id']);
		}

	 /**
     * @return \yii\db\ActiveQuery
     * @description hace referencia al campo for??neo level_id
     */
	  public function getLevel()
		{
			return $this->hasOne(Levels::class, ['id_level' => 'level_id']);
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
        $select = ['*', 'content_level_list.id_content_level_list as id', 'content_level_list.id_content_level_list as text'];
        $result = new \stdClass();
        $result->data = [];
        if ($parameters->relations == 'all')
            $result->data = $query->select($select)->with(get_called_class()::RELATIONS);
        if (!is_null($parameters->relations) && $parameters->relations != 'all')
            $result->data = $query->select($select)->with($parameters->relations);
        if (is_null($parameters->relations))
            $result->data = $query->select($select);
        $result->data=$result->data->andWhere('content_level_list.id_content_level_list LIKE '."'%".$like."%'")->asArray()->all();
        return $result;

    }
}
?>
