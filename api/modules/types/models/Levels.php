<?php 
/**Generate by ASGENS
*@author Pulgaron  
*@date Thu Feb 25 22:09:38 GMT-05:00 2021  
*@time Thu Feb 25 22:09:38 GMT-05:00 2021  
*/
namespace api\modules\types\models;
use Yii;
use common\models\RestModel;

use api\modules\managment\models\Content_level_list;
use api\modules\managment\models\Evaluation;
use api\modules\managment\models\Session_level_list;
use api\modules\managment\models\Sport_student_list;
use api\modules\managment\models\Test_level_list;
/**
 * Este es la clase modelo para la tabla levels.
 *
 * Los siguientes son los campos de la tabla 'levels':
 * @property integer $id_level
 * @property string $level_acr
 * @property string $level_name
 * @property integer $sport_id

 * Los siguientes son las relaciones de este modelo :

 * @property Sports $sport
 * @property Content_level_list[] $arraycontent_level_list
 * @property Evaluation[] $arrayevaluation
 * @property Session_level_list[] $arraysession_level_list
 * @property Sport_student_list[] $arraysport_student_list
 * @property Test_level_list[] $arraytest_level_list
 */

class Levels extends RestModel 
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
    protected $primaryKey = 'id_level';

    const MODEL = 'Levels';

    /**
     * @return string the associated database table name
     */
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'levels';
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
       const RELATIONS = ['sport','arraycontent_level_list','arrayevaluation','arraysession_level_list','arraysport_student_list','arraytest_level_list'];



    /**
     * The primary key of the table
     *
     * @var mixed
     */

       const PKEY = 'id_level';

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
			[['level_name','sport_id'],'required','on'=>['create','default']],
			[['id_level'],'required', 'on' => 'update'],
			[['id_level','sport_id'],'integer'],
			[['level_acr'], 'string', 'max'=>10],
			[['level_name'], 'string', 'max'=>30],
			[['id_level'], 'unique' , 'on' => 'create'],
			[['level_name','sport_id'], 'unique', 'targetAttribute' => ['level_name','sport_id'],'on' => ['create','default']],
			[['level_name','sport_id'], 'unique', 'targetAttribute' => ['level_name','sport_id'],'on' => 'update','when'=> function ($model) {
                $elem = self::find()->where($model->getAttributes(['level_name','sport_id']))->one();
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
     * @description hace referencia al campo foráneo level_id
     */
	  public function getArraycontent_level_list()
		{
			return $this->hasMany(Content_level_list::class, ['level_id' => 'id_level']);
		}

	 /**
     * @return \yii\db\ActiveQuery
     * @description hace referencia al campo foráneo level_id
     */
	  public function getArrayevaluation()
		{
			return $this->hasMany(Evaluation::class, ['level_id' => 'id_level']);
		}

	 /**
     * @return \yii\db\ActiveQuery
     * @description hace referencia al campo foráneo level_id
     */
	  public function getArraysession_level_list()
		{
			return $this->hasMany(Session_level_list::class, ['level_id' => 'id_level']);
		}

	 /**
     * @return \yii\db\ActiveQuery
     * @description hace referencia al campo foráneo level_id
     */
	  public function getArraysport_student_list()
		{
			return $this->hasMany(Sport_student_list::class, ['level_id' => 'id_level']);
		}

	 /**
     * @return \yii\db\ActiveQuery
     * @description hace referencia al campo foráneo level_id
     */
	  public function getArraytest_level_list()
		{
			return $this->hasMany(Test_level_list::class, ['level_id' => 'id_level']);
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
        $select = ['*', 'levels.id_level as id', 'levels.level_acr as text'];
        $result = new \stdClass();
        $result->data = [];
        if ($parameters->relations == 'all')
            $result->data = $query->select($select)->with(get_called_class()::RELATIONS);
        if (!is_null($parameters->relations) && $parameters->relations != 'all')
            $result->data = $query->select($select)->with($parameters->relations);
        if (is_null($parameters->relations))
            $result->data = $query->select($select);
        $result->data=$result->data->andWhere('levels.level_acr LIKE '."'%".$like."%'")->asArray()->all();
        return $result;

    }
}
?>
