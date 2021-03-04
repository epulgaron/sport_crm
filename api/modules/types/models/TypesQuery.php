<?php 
/**Generate by ASGENS
*@author Pulgaron  
*@date Thu Feb 25 22:09:38 GMT-05:00 2021  
*@time Thu Feb 25 22:09:38 GMT-05:00 2021  
*/
namespace api\modules\types\models;


/** 
*  Esta es  ActiveQuery clase de [[Types]].
 *
 * @see Types
 */
/**
 * TypesQuery representa la clase de Consulta del modelo Types
 */
class TypesQuery extends \yii\db\ActiveQuery{
/*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Types[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Types|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

