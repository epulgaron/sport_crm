<?php

namespace common\migrations\db;

use yii\db\Migration;

/**
 * Class M210225_220908_Status
 */
class M210225_220908_Status extends Migration
{

/**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table_name = $this->db->tablePrefix . 'status';
        $exist_table = $this->getDb()->getTableSchema($table_name, true);
        /*Generating tables and columns*/
        if ($exist_table === null) {
            $this->createTable('status',
            [
                'id_status' =>$this->integer(10)->append('AUTO_INCREMENT')->notNull()->unique(),
                'status_acr' =>$this->string(20),
                'status_name' =>$this->string(50)->notNull(),
                 'PRIMARY KEY (`id_status`)'
            ],'ENGINE=InnoDB'
            );

        } else {

            if (!$exist_table->getColumn('id_status'))
                $this->addColumn('status', 'id_status', $this->integer(10)->append('AUTO_INCREMENT')->notNull()->unique());

            if (!$exist_table->getColumn('status_acr'))
                $this->addColumn('status', 'status_acr', $this->string(20));
             else{

                $this->alterColumn('status', 'status_acr', 'VARCHAR(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci  ');

                }
            if (!$exist_table->getColumn('status_name'))
                $this->addColumn('status', 'status_name', $this->string(50)->notNull());
             else{

                $this->alterColumn('status', 'status_name', 'VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL ');

                }
            }
        /*Generating index*/

        if ($exist_table === null || !array_key_exists('status_name', $this->db->getSchema()->findUniqueIndexes($exist_table)))
        $this->createIndex(
                'status_name',
                'status',
                ['status_name'],
                true
            );
        /*Generating foreignkey*/


    }

   public function down()
    {
        echo 'M210225_22939_Status cannot be reverted.';


        return false;
    }
    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo M210225_22939_Status cannot be reverted.


        return false;
    }
    */
}
