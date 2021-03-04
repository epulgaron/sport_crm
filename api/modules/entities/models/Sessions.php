<?php 
/**Generate by ASGENS
*@author Pulgaron  
*@date Thu Feb 25 22:09:38 GMT-05:00 2021  
*@time Thu Feb 25 22:09:38 GMT-05:00 2021  
*/
namespace api\modules\entities\models;
use Yii;
use common\models\RestModel;

use api\modules\types\models\Sports;
use api\modules\types\models\Contents;
use api\modules\managment\models\Evaluation;
use api\modules\managment\models\Session_level_list;
use api\modules\managment\models\Test_session_list;
/**
 * Este es la clase modelo para la tabla sessions.
 *
 * Los siguientes son los campos de la tabla 'sessions':
 * @property integer $id_session
 * @property string $session_name
 * @property integer $sport_id

 * Los siguientes son las relaciones de este modelo :

 * @property Sports $sport
 * @property Contents[] $arraycontents
 * @property Evaluation[] $arrayevaluation
 * @property Session_level_list[] $arraysession_level_list
 * @property Test_session_list[] $arraytest_session_list
 */

class Sessions extends RestModel 
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
    protected $primaryKey = 'id_session';

    const MODEL = 'Sessions';

    /**
     * @return string the associated database table name
     */
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sessions';
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
       const RELATIONS = ['sport','arraycontents','arrayevaluation','arraysession_level_list','arraytest_session_list'];



    /**
     * The primary key of the table
     *
     * @var mixed
     */

       const PKEY = 'id_session';

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
			[['session_name','sport_id'],'required','on'=>['create','default']],
			[['id_session'],'required', 'on' => 'update'],
			[['id_session','sport_id'],'integer'],
			[['session_name'], 'string', 'max'=>50],
			[['id_session'], 'unique' , 'on' => 'create'],
			[['session_name','sport_id'], 'unique', 'targetAttribute' => ['session_name','sport_id'],'on' => ['create','default']],
			[['session_name','sport_id'], 'unique', 'targetAttribute' => ['session_name','sport_id'],'on' => 'update','when'=> function ($model) {
                $elem = self::find()->where($model->getAttributes(['session_name','sport_id']))->one();
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
	  public function getArraycontents()
		{
			return $this->hasMany(Contents::class, ['session_id' => 'id_session']);
		}

	 /**
     * @return \yii\db\ActiveQuery
     * @description hace referencia al campo foráneo session_id
     */
	  public function getArrayevaluation()
		{
			return $this->hasMany(Evaluation::class, ['session_id' => 'id_session']);
		}

	 /**
     * @return \yii\db\ActiveQuery
     * @description hace referencia al campo foráneo session_id
     */
	  public function getArraysession_level_list()
		{
			return $this->hasMany(Session_level_list::class, ['session_id' => 'id_session']);
		}

	 /**
     * @return \yii\db\ActiveQuery
     * @description hace referencia al campo foráneo session_id
     */
	  public function getArraytest_session_list()
		{
			return $this->hasMany(Test_session_list::class, ['session_id' => 'id_session']);
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
        $select = ['*', 'sessions.id_session as id', 'sessions.session_name as text'];
        $result = new \stdClass();
        $result->data = [];
        if ($parameters->relations == 'all')
            $result->data = $query->select($select)->with(get_called_class()::RELATIONS);
        if (!is_null($parameters->relations) && $parameters->relations != 'all')
            $result->data = $query->select($select)->with($parameters->relations);
        if (is_null($parameters->relations))
            $result->data = $query->select($select);
        $result->data=$result->data->andWhere('sessions.session_name LIKE '."'%".$like."%'")->asArray()->all();
        return $result;

    }
}
?>
