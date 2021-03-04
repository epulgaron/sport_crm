<?php 
/**Generate by ASGENS
*@author Pulgaron  
*@date Thu Feb 25 22:09:38 GMT-05:00 2021  
*@time Thu Feb 25 22:09:38 GMT-05:00 2021  
*/
namespace api\modules\entities\models;


/** 
*  Esta es  ActiveQuery clase de [[Errors]].
 *
 * @see Errors
 */
/**
 * ErrorsQuery representa la clase de Consulta del modelo Errors
 */
class ErrorsQuery extends \yii\db\ActiveQuery{
/*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Errors[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Errors|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

