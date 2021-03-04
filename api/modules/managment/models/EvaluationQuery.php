<?php 
/**Generate by ASGENS
*@author Pulgaron  
*@date Thu Feb 25 22:09:38 GMT-05:00 2021  
*@time Thu Feb 25 22:09:38 GMT-05:00 2021  
*/
namespace api\modules\managment\models;


/** 
*  Esta es  ActiveQuery clase de [[Evaluation]].
 *
 * @see Evaluation
 */
/**
 * EvaluationQuery representa la clase de Consulta del modelo Evaluation
 */
class EvaluationQuery extends \yii\db\ActiveQuery{
/*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Evaluation[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Evaluation|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

