<?php 
/**Generate by ASGENS
*@author Pulgaron  
*@date Thu Feb 25 22:09:38 GMT-05:00 2021  
*@time Thu Feb 25 22:09:38 GMT-05:00 2021  
*/
namespace api\modules\types\models;
use Yii;
use common\models\RestModel;

use api\modules\entities\models\Sessions;
use api\modules\managment\models\Content_error_list;
use api\modules\managment\models\Content_level_list;
/**
 * Este es la clase modelo para la tabla contents.
 *
 * Los siguientes son los campos de la tabla 'contents':
 * @property integer $id_content
 * @property string $content_name
 * @property string $content_description
 * @property integer $sport_id
 * @property integer $session_id

 * Los siguientes son las relaciones de este modelo :

 * @property Sports $sport
 * @property Sessions $session
 * @property Content_error_list[] $arraycontent_error_list
 * @property Content_level_list[] $arraycontent_level_list
 */

class Contents extends RestModel 
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
    protected $primaryKey = 'id_content';

    const MODEL = 'Contents';

    /**
     * @return string the associated database table name
     */
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'contents';
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
       const RELATIONS = ['sport','session','arraycontent_error_list','arraycontent_level_list'];



    /**
     * The primary key of the table
     *
     * @var mixed
     */

       const PKEY = 'id_content';

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
			[['content_name','sport_id','session_id'],'required','on'=>['create','default']],
			[['id_content'],'required', 'on' => 'update'],
			[['id_content','sport_id','session_id'],'integer'],
			[['content_name'], 'string', 'max'=>50],
			[['content_description'], 'string', 'max'=>65535],
			[['id_content'], 'unique' , 'on' => 'create'],
			[['content_name','sport_id','session_id'], 'unique', 'targetAttribute' => ['content_name','sport_id','session_id'],'on' => ['create','default']],
			[['content_name','sport_id','session_id'], 'unique', 'targetAttribute' => ['content_name','sport_id','session_id'],'on' => 'update','when'=> function ($model) {
                $elem = self::find()->where($model->getAttributes(['content_name','sport_id','session_id']))->one();
                return !$elem ? false : $elem[$elem->primaryKey] != $model[$model->primaryKey];
            }],
        ];
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
     * @description hace referencia al campo foráneo session_id
     */
	  public function getSession()
		{
			return $this->hasOne(Sessions::class, ['id_session' => 'session_id']);
		}


	 /**
     * @return \yii\db\ActiveQuery
     * @description hace referencia al campo foráneo content_id
     */
	  public function getArraycontent_error_list()
		{
			return $this->hasMany(Content_error_list::class, ['content_id' => 'id_content']);
		}

	 /**
     * @return \yii\db\ActiveQuery
     * @description hace referencia al campo foráneo content_id
     */
	  public function getArraycontent_level_list()
		{
			return $this->hasMany(Content_level_list::class, ['content_id' => 'id_content']);
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
        $select = ['*', 'contents.id_content as id', 'contents.content_name as text'];
        $result = new \stdClass();
        $result->data = [];
        if ($parameters->relations == 'all')
            $result->data = $query->select($select)->with(get_called_class()::RELATIONS);
        if (!is_null($parameters->relations) && $parameters->relations != 'all')
            $result->data = $query->select($select)->with($parameters->relations);
        if (is_null($parameters->relations))
            $result->data = $query->select($select);
        $result->data=$result->data->andWhere('contents.content_name LIKE '."'%".$like."%'")->asArray()->all();
        return $result;

    }
}
?>
