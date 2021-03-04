<?php 
/**Generate by ASGENS
*@author Pulgaron  
*@date Thu Feb 25 22:09:38 GMT-05:00 2021  
*@time Thu Feb 25 22:09:38 GMT-05:00 2021  
*/
namespace common\modules\security\models;


/** 
*  Esta es  ActiveQuery clase de [[Roles]].
 *
 * @see Roles
 */
/**
 * RolesQuery representa la clase de Consulta del modelo Roles
 */
class RolesQuery extends \yii\db\ActiveQuery{
/*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Roles[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Roles|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

