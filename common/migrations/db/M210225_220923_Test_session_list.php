<?php

namespace common\migrations\db;

use yii\db\Migration;

/**
 * Class M210225_220923_Test_session_list
 */
class M210225_220923_Test_session_list extends Migration
{

/**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table_name = $this->db->tablePrefix . 'test_session_list';
        $exist_table = $this->getDb()->getTableSchema($table_name, true);
        /*Generating tables and columns*/
        if ($exist_table === null) {
            $this->createTable('test_session_list',
            [
                'id_test_session_list' =>$this->integer(10)->append('AUTO_INCREMENT')->notNull()->unique(),
                'test_id' =>$this->integer(10)->notNull(),
                'session_id' =>$this->integer(10)->notNull(),
                'value' =>$this->integer(10)->notNull(),
                 'PRIMARY KEY (`id_test_session_list`)'
            ],'ENGINE=InnoDB'
            );

        } else {

            if (!$exist_table->getColumn('id_test_session_list'))
                $this->addColumn('test_session_list', 'id_test_session_list', $this->integer(10)->append('AUTO_INCREMENT')->notNull()->unique());

            if (!$exist_table->getColumn('test_id'))
                $this->addColumn('test_session_list', 'test_id', $this->integer(10)->notNull());

            if (!$exist_table->getColumn('session_id'))
                $this->addColumn('test_session_list', 'session_id', $this->integer(10)->notNull());

            if (!$exist_table->getColumn('value'))
                $this->addColumn('test_session_list', 'value', $this->integer(10)->notNull());
             else{
                $this->alterColumn('test_session_list', 'value', $this->integer(10)->notNull());
                }
            }
        /*Generating index*/

        if ($exist_table === null || !array_key_exists('test_session', $this->db->getSchema()->findUniqueIndexes($exist_table)))
        $this->createIndex(
                'test_session',
                'test_session_list',
                ['test_id','session_id'],
                true
            );
        /*Generating foreignkey*/

        if ($exist_table === null || !array_key_exists('test_session_list_fk',$exist_table->foreignKeys) || !array_key_exists('session_id',$exist_table->foreignKeys['test_session_list_fk'])) 
            $this->addForeignKey(
                'test_session_list_fk',
                'test_session_list',
                'session_id',
                'sessions',
                'id_session',
                'CASCADE',
                'CASCADE'
            );
           else {
            $this->dropForeignKey('test_session_list_fk','test_session_list' );
            $this->addForeignKey(
                'test_session_list_fk',
                'test_session_list',
                'session_id',
                'sessions',
                'id_session',
                'CASCADE',
                'CASCADE'
            );
           }
        if ($exist_table === null || !array_key_exists('test_session_list_fk1',$exist_table->foreignKeys) || !array_key_exists('test_id',$exist_table->foreignKeys['test_session_list_fk1'])) 
            $this->addForeignKey(
                'test_session_list_fk1',
                'test_session_list',
                'test_id',
                'tests',
                'id_test',
                'CASCADE',
                'CASCADE'
            );
           else {
            $this->dropForeignKey('test_session_list_fk1','test_session_list' );
            $this->addForeignKey(
                'test_session_list_fk1',
                'test_session_list',
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
        echo 'M210225_22939_Test_session_list cannot be reverted.';


        return false;
    }
    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo M210225_22939_Test_session_list cannot be reverted.


        return false;
    }
    */
}
