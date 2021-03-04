<?php

namespace common\migrations\db;

use yii\db\Migration;

/**
 * Class M210225_220924_Test_student_list
 */
class M210225_220924_Test_student_list extends Migration
{

/**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table_name = $this->db->tablePrefix . 'test_student_list';
        $exist_table = $this->getDb()->getTableSchema($table_name, true);
        /*Generating tables and columns*/
        if ($exist_table === null) {
            $this->createTable('test_student_list',
            [
                'id_test_student_list' =>$this->integer(10)->append('AUTO_INCREMENT')->notNull()->unique(),
                'test_id' =>$this->integer(10)->notNull(),
                'student_id' =>$this->integer(10),
                'notify_tutor' =>$this->tinyInteger(3),
                 'PRIMARY KEY (`id_test_student_list`)'
            ],'ENGINE=InnoDB'
            );

        } else {

            if (!$exist_table->getColumn('id_test_student_list'))
                $this->addColumn('test_student_list', 'id_test_student_list', $this->integer(10)->append('AUTO_INCREMENT')->notNull()->unique());

            if (!$exist_table->getColumn('test_id'))
                $this->addColumn('test_student_list', 'test_id', $this->integer(10)->notNull());

            if (!$exist_table->getColumn('student_id'))
                $this->addColumn('test_student_list', 'student_id', $this->integer(10));

            if (!$exist_table->getColumn('notify_tutor'))
                $this->addColumn('test_student_list', 'notify_tutor', $this->tinyInteger(3));
             else{
                $this->alterColumn('test_student_list', 'notify_tutor', $this->tinyInteger(3));
                }
            }
        /*Generating index*/

        if ($exist_table === null || !array_key_exists('test_student', $this->db->getSchema()->findUniqueIndexes($exist_table)))
        $this->createIndex(
                'test_student',
                'test_student_list',
                ['test_id','student_id'],
                true
            );
        /*Generating foreignkey*/

        if ($exist_table === null || !array_key_exists('test_student_list_fk',$exist_table->foreignKeys) || !array_key_exists('test_id',$exist_table->foreignKeys['test_student_list_fk'])) 
            $this->addForeignKey(
                'test_student_list_fk',
                'test_student_list',
                'test_id',
                'tests',
                'id_test',
                'CASCADE',
                'CASCADE'
            );
           else {
            $this->dropForeignKey('test_student_list_fk','test_student_list' );
            $this->addForeignKey(
                'test_student_list_fk',
                'test_student_list',
                'test_id',
                'tests',
                'id_test',
                'CASCADE',
                'CASCADE'
            );
           }
        if ($exist_table === null || !array_key_exists('test_student_list_fk1',$exist_table->foreignKeys) || !array_key_exists('student_id',$exist_table->foreignKeys['test_student_list_fk1'])) 
            $this->addForeignKey(
                'test_student_list_fk1',
                'test_student_list',
                'student_id',
                'students',
                'user_id',
                'CASCADE',
                'CASCADE'
            );
           else {
            $this->dropForeignKey('test_student_list_fk1','test_student_list' );
            $this->addForeignKey(
                'test_student_list_fk1',
                'test_student_list',
                'student_id',
                'students',
                'user_id',
                'CASCADE',
                'CASCADE'
            );
           }

    }

   public function down()
    {
        echo 'M210225_22939_Test_student_list cannot be reverted.';


        return false;
    }
    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo M210225_22939_Test_student_list cannot be reverted.


        return false;
    }
    */
}
