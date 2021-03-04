<?php

namespace common\migrations\db;

use yii\db\Migration;

/**
 * Class M210225_220903_Errors
 */
class M210225_220903_Errors extends Migration
{

/**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table_name = $this->db->tablePrefix . 'errors';
        $exist_table = $this->getDb()->getTableSchema($table_name, true);
        /*Generating tables and columns*/
        if ($exist_table === null) {
            $this->createTable('errors',
            [
                'id_error' =>$this->integer(10)->append('AUTO_INCREMENT')->notNull()->unique(),
                'error_name' =>$this->string(50)->notNull(),
                'recomendacion' =>$this->text(),
                 'PRIMARY KEY (`id_error`)'
            ],'ENGINE=InnoDB'
            );

        } else {

            if (!$exist_table->getColumn('id_error'))
                $this->addColumn('errors', 'id_error', $this->integer(10)->append('AUTO_INCREMENT')->notNull()->unique());

            if (!$exist_table->getColumn('error_name'))
                $this->addColumn('errors', 'error_name', $this->string(50)->notNull());
             else{

                $this->alterColumn('errors', 'error_name', 'VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL ');

                }
            if (!$exist_table->getColumn('recomendacion'))
                $this->addColumn('errors', 'recomendacion', $this->text());
             else{
                $this->alterColumn('errors', 'recomendacion', $this->text());
                }
            }
        /*Generating index*/

        /*Generating foreignkey*/


    }

   public function down()
    {
        echo 'M210225_22939_Errors cannot be reverted.';


        return false;
    }
    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo M210225_22939_Errors cannot be reverted.


        return false;
    }
    */
}
