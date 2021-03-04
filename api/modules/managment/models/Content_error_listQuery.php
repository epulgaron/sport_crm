<?php 
/**Generate by ASGENS
*@author Pulgaron  
*@date Thu Feb 25 22:09:38 GMT-05:00 2021  
*@time Thu Feb 25 22:09:38 GMT-05:00 2021  
*/
namespace api\modules\managment\models;


/** 
*  Esta es  ActiveQuery clase de [[Content_error_list]].
 *
 * @see Content_error_list
 */
/**
 * Content_error_listQuery representa la clase de Consulta del modelo Content_error_list
 */
class Content_error_listQuery extends \yii\db\ActiveQuery{
/*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Content_error_list[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Content_error_list|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

