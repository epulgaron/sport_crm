<?php

namespace common\migrations\db;

use yii\db\Migration;

/**
 * Class M210225_220928_Evaluation
 */
class M210225_220928_Evaluation extends Migration
{

/**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table_name = $this->db->tablePrefix . 'evaluation';
        $exist_table = $this->getDb()->getTableSchema($table_name, true);
        /*Generating tables and columns*/
        if ($exist_table === null) {
            $this->createTable('evaluation',
            [
                'id_eval' =>$this->integer(10)->append('AUTO_INCREMENT')->notNull()->unique(),
                'test_id' =>$this->integer(10)->notNull(),
                'level_id' =>$this->integer(10)->notNull(),
                'session_id' =>$this->integer(10)->notNull(),
                'student_id' =>$this->integer(10)->notNull(),
                'teacher_id' =>$this->integer(10)->notNull(),
                'score' =>$this->integer(10)->notNull(),
                 'PRIMARY KEY (`id_eval`)'
            ],'ENGINE=InnoDB'
            );

        } else {

            if (!$exist_table->getColumn('id_eval'))
                $this->addColumn('evaluation', 'id_eval', $this->integer(10)->append('AUTO_INCREMENT')->notNull()->unique());

            if (!$exist_table->getColumn('test_id'))
                $this->addColumn('evaluation', 'test_id', $this->integer(10)->notNull());

            if (!$exist_table->getColumn('level_id'))
                $this->addColumn('evaluation', 'level_id', $this->integer(10)->notNull());

            if (!$exist_table->getColumn('session_id'))
                $this->addColumn('evaluation', 'session_id', $this->integer(10)->notNull());

            if (!$exist_table->getColumn('student_id'))
                $this->addColumn('evaluation', 'student_id', $this->integer(10)->notNull());

            if (!$exist_table->getColumn('teacher_id'))
                $this->addColumn('evaluation', 'teacher_id', $this->integer(10)->notNull());

            if (!$exist_table->getColumn('score'))
                $this->addColumn('evaluation', 'score', $this->integer(10)->notNull());
             else{
                $this->alterColumn('evaluation', 'score', $this->integer(10)->notNull());
                }
            }
        /*Generating index*/

        /*Generating foreignkey*/

        if ($exist_table === null || !array_key_exists('Refteachers50',$exist_table->foreignKeys) || !array_key_exists('teacher_id',$exist_table->foreignKeys['Refteachers50'])) 
            $this->addForeignKey(
                'Refteachers50',
                'evaluation',
                'teacher_id',
                'teachers',
                'user_id',
                'NO ACTION',
                'NO ACTION'
            );
           else {
            $this->dropForeignKey('Refteachers50','evaluation' );
            $this->addForeignKey(
                'Refteachers50',
                'evaluation',
                'teacher_id',
                'teachers',
                'user_id',
                'NO ACTION',
                'NO ACTION'
            );
           }
        if ($exist_table === null || !array_key_exists('eval_fk',$exist_table->foreignKeys) || !array_key_exists('test_id',$exist_table->foreignKeys['eval_fk'])) 
            $this->addForeignKey(
                'eval_fk',
                'evaluation',
                'test_id',
                'tests',
                'id_test',
                'CASCADE',
                'CASCADE'
            );
           else {
            $this->dropForeignKey('eval_fk','evaluation' );
            $this->addForeignKey(
                'eval_fk',
                'evaluation',
                'test_id',
                'tests',
                'id_test',
                'CASCADE',
                'CASCADE'
            );
           }
        if ($exist_table === null || !array_key_exists('eval_fk1',$exist_table->foreignKeys) || !array_key_exists('level_id',$exist_table->foreignKeys['eval_fk1'])) 
            $this->addForeignKey(
                'eval_fk1',
                'evaluation',
                'level_id',
                'levels',
                'id_level',
                'CASCADE',
                'CASCADE'
            );
           else {
            $this->dropForeignKey('eval_fk1','evaluation' );
            $this->addForeignKey(
                'eval_fk1',
                'evaluation',
                'level_id',
                'levels',
                'id_level',
                'CASCADE',
                'CASCADE'
            );
           }
        if ($exist_table === null || !array_key_exists('eval_fk2',$exist_table->foreignKeys) || !array_key_exists('session_id',$exist_table->foreignKeys['eval_fk2'])) 
            $this->addForeignKey(
                'eval_fk2',
                'evaluation',
                'session_id',
                'sessions',
                'id_session',
                'CASCADE',
                'CASCADE'
            );
           else {
            $this->dropForeignKey('eval_fk2','evaluation' );
            $this->addForeignKey(
                'eval_fk2',
                'evaluation',
                'session_id',
                'sessions',
                'id_session',
                'CASCADE',
                'CASCADE'
            );
           }
        if ($exist_table === null || !array_key_exists('eval_fk3',$exist_table->foreignKeys) || !array_key_exists('student_id',$exist_table->foreignKeys['eval_fk3'])) 
            $this->addForeignKey(
                'eval_fk3',
                'evaluation',
                'student_id',
                'students',
                'user_id',
                'CASCADE',
                'CASCADE'
            );
           else {
            $this->dropForeignKey('eval_fk3','evaluation' );
            $this->addForeignKey(
                'eval_fk3',
                'evaluation',
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
        echo 'M210225_22939_Evaluation cannot be reverted.';


        return false;
    }
    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo M210225_22939_Evaluation cannot be reverted.


        return false;
    }
    */
}
