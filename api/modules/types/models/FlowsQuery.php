<?php 
/**Generate by ASGENS
*@author Pulgaron  
*@date Thu Feb 25 22:09:38 GMT-05:00 2021  
*@time Thu Feb 25 22:09:38 GMT-05:00 2021  
*/
namespace api\modules\types\models;


/** 
*  Esta es  ActiveQuery clase de [[Flows]].
 *
 * @see Flows
 */
/**
 * FlowsQuery representa la clase de Consulta del modelo Flows
 */
class FlowsQuery extends \yii\db\ActiveQuery{
/*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Flows[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Flows|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

