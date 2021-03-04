<?php 
/**Generate by ASGENS
*@author Pulgaron  
*@date Thu Feb 25 22:09:38 GMT-05:00 2021  
*@time Thu Feb 25 22:09:38 GMT-05:00 2021  
*/
namespace api\modules\security\models;


/** 
*  Esta es  ActiveQuery clase de [[Role_permission_list]].
 *
 * @see Role_permission_list
 */
/**
 * Role_permission_listQuery representa la clase de Consulta del modelo Role_permission_list
 */
class Role_permission_listQuery extends \yii\db\ActiveQuery{
/*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Role_permission_list[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Role_permission_list|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

