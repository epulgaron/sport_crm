<?php

namespace common\migrations\db;

use yii\db\Migration;

/**
 * Class M210225_220922_Test_level_list
 */
class M210225_220922_Test_level_list extends Migration
{

/**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table_name = $this->db->tablePrefix . 'test_level_list';
        $exist_table = $this->getDb()->getTableSchema($table_name, true);
        /*Generating tables and columns*/
        if ($exist_table === null) {
            $this->createTable('test_level_list',
            [
                'id_test_level_list' =>$this->integer(10)->append('AUTO_INCREMENT')->notNull()->unique(),
                'test_id' =>$this->integer(10)->notNull(),
                'level_id' =>$this->integer(10)->notNull(),
                 'PRIMARY KEY (`id_test_level_list`)'
            ],'ENGINE=InnoDB'
            );

        } else {

            if (!$exist_table->getColumn('id_test_level_list'))
                $this->addColumn('test_level_list', 'id_test_level_list', $this->integer(10)->append('AUTO_INCREMENT')->notNull()->unique());

            if (!$exist_table->getColumn('test_id'))
                $this->addColumn('test_level_list', 'test_id', $this->integer(10)->notNull());

            if (!$exist_table->getColumn('level_id'))
                $this->addColumn('test_level_list', 'level_id', $this->integer(10)->notNull());

            }
        /*Generating index*/

        if ($exist_table === null || !array_key_exists('level_test', $this->db->getSchema()->findUniqueIndexes($exist_table)))
        $this->createIndex(
                'level_test',
                'test_level_list',
                ['test_id','level_id'],
                true
            );
        /*Generating foreignkey*/

        if ($exist_table === null || !array_key_exists('test_level_list_fk',$exist_table->foreignKeys) || !array_key_exists('level_id',$exist_table->foreignKeys['test_level_list_fk'])) 
            $this->addForeignKey(
                'test_level_list_fk',
                'test_level_list',
                'level_id',
                'levels',
                'id_level',
                'CASCADE',
                'CASCADE'
            );
           else {
            $this->dropForeignKey('test_level_list_fk','test_level_list' );
            $this->addForeignKey(
                'test_level_list_fk',
                'test_level_list',
                'level_id',
                'levels',
                'id_level',
                'CASCADE',
                'CASCADE'
            );
           }
        if ($exist_table === null || !array_key_exists('test_level_list_fk1',$exist_table->foreignKeys) || !array_key_exists('test_id',$exist_table->foreignKeys['test_level_list_fk1'])) 
            $this->addForeignKey(
                'test_level_list_fk1',
                'test_level_list',
                'test_id',
                'tests',
                'id_test',
                'CASCADE',
                'CASCADE'
            );
           else {
            $this->dropForeignKey('test_level_list_fk1','test_level_list' );
            $this->addForeignKey(
                'test_level_list_fk1',
                'test_level_list',
                'test_id',
                'tests',
                'id_test',
                'CASCADE',
                'CASCADE'
            );
           }

    }

   public function down()
    {
        echo 'M210225_22939_Test_level_list cannot be reverted.';


        return false;
    }
    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo M210225_22939_Test_level_list cannot be reverted.


        return false;
    }
    */
}
