<?php

namespace common\migrations\db;

use yii\db\Migration;

/**
 * Class M210225_220909_Types
 */
class M210225_220909_Types extends Migration
{

/**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table_name = $this->db->tablePrefix . 'types';
        $exist_table = $this->getDb()->getTableSchema($table_name, true);
        /*Generating tables and columns*/
        if ($exist_table === null) {
            $this->createTable('types',
            [
                'id_type' =>$this->integer(10)->append('AUTO_INCREMENT')->notNull()->unique(),
                'type_acr' =>$this->string(20),
                'type_name' =>$this->string(50)->notNull(),
                 'PRIMARY KEY (`id_type`)'
            ],'ENGINE=InnoDB'
            );

        } else {

            if (!$exist_table->getColumn('id_type'))
                $this->addColumn('types', 'id_type', $this->integer(10)->append('AUTO_INCREMENT')->notNull()->unique());

            if (!$exist_table->getColumn('type_acr'))
                $this->addColumn('types', 'type_acr', $this->string(20));
             else{

                $this->alterColumn('types', 'type_acr', 'VARCHAR(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci  ');

                }
            if (!$exist_table->getColumn('type_name'))
                $this->addColumn('types', 'type_name', $this->string(50)->notNull());
             else{

                $this->alterColumn('types', 'type_name', 'VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL ');

                }
            }
        /*Generating index*/

        if ($exist_table === null || !array_key_exists('type_name', $this->db->getSchema()->findUniqueIndexes($exist_table)))
        $this->createIndex(
                'type_name',
                'types',
                ['type_name'],
                true
            );
        /*Generating foreignkey*/


    }

   public function down()
    {
        echo 'M210225_22939_Types cannot be reverted.';


        return false;
    }
    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo M210225_22939_Types cannot be reverted.


        return false;
    }
    */
}
