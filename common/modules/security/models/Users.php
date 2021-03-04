<?php 
/**Generate by ASGENS
*@author Pulgaron  
*@date Thu Feb 25 22:09:38 GMT-05:00 2021  
*@time Thu Feb 25 22:09:38 GMT-05:00 2021  
*/
namespace common\modules\security\models;
use Yii;
use common\models\RestModel;

use yii\web\IdentityInterface;
/**
 * Este es la clase modelo para la tabla users.
 *
 * Los siguientes son los campos de la tabla 'users':
 * @property integer $id_user
 * @property string $user_first_name
 * @property string $user_last_name
 * @property string $user_email
 * @property string $user_phone
 * @property string $user_password
 * @property integer $role_id

 * Los siguientes son las relaciones de este modelo :

 * @property Roles $role
 */

class Users extends RestModel implements IdentityInterface
{

    const ACCESS_TOKEN = 'user_last_name';
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
    protected $primaryKey = 'id_user';

    const MODEL = 'Users';

    /**
     * @return string the associated database table name
     */
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

     
        /**
     *
     * The names of the hidden fields.
     *
     * @var array
     */
    const HIDE = ['user_password'];
    /**

     * The names of the relation tables.
     *
     */
       const RELATIONS = ['role'];



    /**
     * The primary key of the table
     *
     * @var mixed
     */

       const PKEY = 'id_user';

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
			[['user_first_name','user_last_name','user_email','role_id'],'required','on'=>['create','default']],
			[['id_user'],'required', 'on' => 'update'],
			[['id_user','role_id'],'integer'],
			[['user_first_name','user_last_name','user_email','user_password'], 'string', 'max'=>50],
			[['user_phone'], 'string', 'max'=>30],
			[['id_user'], 'unique' , 'on' => 'create'],
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
        $select = ['*', 'users.id_user as id', 'users.user_first_name as text'];
        $result = new \stdClass();
        $result->data = [];
        if ($parameters->relations == 'all')
            $result->data = $query->select($select)->with(get_called_class()::RELATIONS);
        if (!is_null($parameters->relations) && $parameters->relations != 'all')
            $result->data = $query->select($select)->with($parameters->relations);
        if (is_null($parameters->relations))
            $result->data = $query->select($select);
        $result->data=$result->data->andWhere('users.user_first_name LIKE '."'%".$like."%'")->asArray()->all();
        return $result;

    }
    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id_user' => $id]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne([self::PKEY => (string) $token->getClaim('uid')]);
    }

    /**
     * Finds user by username     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['user_email' => $username]);
    }


    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token
            ]);

    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->user_last_name;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->user_password);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->user_password = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->user_last_name = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
   /* 
   *  Updating hash password 
   */
    public function beforeSave($insert)
    {
        if ($insert){
            $this->setPassword($this->user_password);
            
           }else
        if ($this->isAttributeChanged('user_password') && $this->user_password!='' && $this->user_password!='0')
                $this->setPassword($this->user_password);
            if($this->user_password=='' || $this->user_password=='0')
                $this->user_password=$this->getOldAttribute('user_password');        
        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }
    
   public function get_data()
    {
        return array_intersect_key($this->attributes,['user_first_name'=>'','user_last_name'=>'']);
    }

}
?>
