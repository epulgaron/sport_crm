<?php

namespace common\migrations\db;

use yii\db\Migration;

/**
 * Class M210225_220904_Flows
 */
class M210225_220904_Flows extends Migration
{

/**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table_name = $this->db->tablePrefix . 'flows';
        $exist_table = $this->getDb()->getTableSchema($table_name, true);
        /*Generating tables and columns*/
        if ($exist_table === null) {
            $this->createTable('flows',
            [
                'id_flow' =>$this->integer(10)->append('AUTO_INCREMENT')->notNull()->unique(),
                'flow_acr' =>$this->string(20),
                'flow_name' =>$this->string(30)->notNull(),
                'flow_description' =>$this->text(),
                 'PRIMARY KEY (`id_flow`)'
            ],'ENGINE=InnoDB'
            );

        } else {

            if (!$exist_table->getColumn('id_flow'))
                $this->addColumn('flows', 'id_flow', $this->integer(10)->append('AUTO_INCREMENT')->notNull()->unique());

            if (!$exist_table->getColumn('flow_acr'))
                $this->addColumn('flows', 'flow_acr', $this->string(20));
             else{

                $this->alterColumn('flows', 'flow_acr', 'VARCHAR(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci  ');

                }
            if (!$exist_table->getColumn('flow_name'))
                $this->addColumn('flows', 'flow_name', $this->string(30)->notNull());
             else{

                $this->alterColumn('flows', 'flow_name', 'VARCHAR(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL ');

                }
            if (!$exist_table->getColumn('flow_description'))
                $this->addColumn('flows', 'flow_description', $this->text());
             else{
                $this->alterColumn('flows', 'flow_description', $this->text());
                }
            }
        /*Generating index*/

        /*Generating foreignkey*/


    }

   public function down()
    {
        echo 'M210225_22939_Flows cannot be reverted.';


        return false;
    }
    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo M210225_22939_Flows cannot be reverted.


        return false;
    }
    */
}
