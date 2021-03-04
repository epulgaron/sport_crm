<?php

namespace common\migrations\db;

use yii\db\Migration;

/**
 * Class M210225_220925_Test_teacher_list
 */
class M210225_220925_Test_teacher_list extends Migration
{

/**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table_name = $this->db->tablePrefix . 'test_teacher_list';
        $exist_table = $this->getDb()->getTableSchema($table_name, true);
        /*Generating tables and columns*/
        if ($exist_table === null) {
            $this->createTable('test_teacher_list',
            [
                'id_test_teacher_list' =>$this->integer(10)->append('AUTO_INCREMENT')->notNull()->unique(),
                'test_id' =>$this->integer(10)->notNull(),
                'teacher_id' =>$this->integer(10)->notNull(),
                 'PRIMARY KEY (`id_test_teacher_list`)'
            ],'ENGINE=InnoDB'
            );

        } else {

            if (!$exist_table->getColumn('id_test_teacher_list'))
                $this->addColumn('test_teacher_list', 'id_test_teacher_list', $this->integer(10)->append('AUTO_INCREMENT')->notNull()->unique());

            if (!$exist_table->getColumn('test_id'))
                $this->addColumn('test_teacher_list', 'test_id', $this->integer(10)->notNull());

            if (!$exist_table->getColumn('teacher_id'))
                $this->addColumn('test_teacher_list', 'teacher_id', $this->integer(10)->notNull());

            }
        /*Generating index*/

        if ($exist_table === null || !array_key_exists('test_teacher', $this->db->getSchema()->findUniqueIndexes($exist_table)))
        $this->createIndex(
                'test_teacher',
                'test_teacher_list',
                ['test_id','teacher_id'],
                true
            );
        /*Generating foreignkey*/

        if ($exist_table === null || !array_key_exists('test_teacher_list_fk',$exist_table->foreignKeys) || !array_key_exists('test_id',$exist_table->foreignKeys['test_teacher_list_fk'])) 
            $this->addForeignKey(
                'test_teacher_list_fk',
                'test_teacher_list',
                'test_id',
                'tests',
                'id_test',
                'CASCADE',
                'CASCADE'
            );
           else {
            $this->dropForeignKey('test_teacher_list_fk','test_teacher_list' );
            $this->addForeignKey(
                'test_teacher_list_fk',
                'test_teacher_list',
                'test_id',
                'tests',
                'id_test',
                'CASCADE',
                'CASCADE'
            );
           }
        if ($exist_table === null || !array_key_exists('test_teacher_list_fk1',$exist_table->foreignKeys) || !array_key_exists('teacher_id',$exist_table->foreignKeys['test_teacher_list_fk1'])) 
            $this->addForeignKey(
                'test_teacher_list_fk1',
                'test_teacher_list',
                'teacher_id',
                'teachers',
                'user_id',
                'CASCADE',
                'CASCADE'
            );
           else {
            $this->dropForeignKey('test_teacher_list_fk1','test_teacher_list' );
            $this->addForeignKey(
                'test_teacher_list_fk1',
                'test_teacher_list',
                'teacher_id',
                'teachers',
                'user_id',
                'CASCADE',
                'CASCADE'
            );
           }

    }

   public function down()
    {
        echo 'M210225_22939_Test_teacher_list cannot be reverted.';


        return false;
    }
    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo M210225_22939_Test_teacher_list cannot be reverted.


        return false;
    }
    */
}
