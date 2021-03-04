<?php

namespace common\migrations\db;

use yii\db\Migration;

/**
 * Class M210225_220930_Sport_student_list
 */
class M210225_220930_Sport_student_list extends Migration
{

/**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table_name = $this->db->tablePrefix . 'sport_student_list';
        $exist_table = $this->getDb()->getTableSchema($table_name, true);
        /*Generating tables and columns*/
        if ($exist_table === null) {
            $this->createTable('sport_student_list',
            [
                'id_sport_student_list' =>$this->integer(10)->append('AUTO_INCREMENT')->notNull()->unique(),
                'student_id' =>$this->integer(10)->notNull(),
                'sport_id' =>$this->integer(10)->notNull(),
                'level_id' =>$this->integer(10)->notNull(),
                 'PRIMARY KEY (`id_sport_student_list`)'
            ],'ENGINE=InnoDB'
            );

        } else {

            if (!$exist_table->getColumn('id_sport_student_list'))
                $this->addColumn('sport_student_list', 'id_sport_student_list', $this->integer(10)->append('AUTO_INCREMENT')->notNull()->unique());

            if (!$exist_table->getColumn('student_id'))
                $this->addColumn('sport_student_list', 'student_id', $this->integer(10)->notNull());

            if (!$exist_table->getColumn('sport_id'))
                $this->addColumn('sport_student_list', 'sport_id', $this->integer(10)->notNull());

            if (!$exist_table->getColumn('level_id'))
                $this->addColumn('sport_student_list', 'level_id', $this->integer(10)->notNull());

            }
        /*Generating index*/

        if ($exist_table === null || !array_key_exists('student_sport_level', $this->db->getSchema()->findUniqueIndexes($exist_table)))
        $this->createIndex(
                'student_sport_level',
                'sport_student_list',
                ['student_id','sport_id','level_id'],
                true
            );
        /*Generating foreignkey*/

        if ($exist_table === null || !array_key_exists('sport_student_list_fk',$exist_table->foreignKeys) || !array_key_exists('student_id',$exist_table->foreignKeys['sport_student_list_fk'])) 
            $this->addForeignKey(
                'sport_student_list_fk',
                'sport_student_list',
                'student_id',
                'students',
                'user_id',
                'CASCADE',
                'CASCADE'
            );
           else {
            $this->dropForeignKey('sport_student_list_fk','sport_student_list' );
            $this->addForeignKey(
                'sport_student_list_fk',
                'sport_student_list',
                'student_id',
                'students',
                'user_id',
                'CASCADE',
                'CASCADE'
            );
           }
        if ($exist_table === null || !array_key_exists('sport_student_list_fk1',$exist_table->foreignKeys) || !array_key_exists('sport_id',$exist_table->foreignKeys['sport_student_list_fk1'])) 
            $this->addForeignKey(
                'sport_student_list_fk1',
                'sport_student_list',
                'sport_id',
                'sports',
                'id_sport',
                'CASCADE',
                'CASCADE'
            );
           else {
            $this->dropForeignKey('sport_student_list_fk1','sport_student_list' );
            $this->addForeignKey(
                'sport_student_list_fk1',
                'sport_student_list',
                'sport_id',
                'sports',
                'id_sport',
                'CASCADE',
                'CASCADE'
            );
           }
        if ($exist_table === null || !array_key_exists('sport_student_list_fk2',$exist_table->foreignKeys) || !array_key_exists('level_id',$exist_table->foreignKeys['sport_student_list_fk2'])) 
            $this->addForeignKey(
                'sport_student_list_fk2',
                'sport_student_list',
                'level_id',
                'levels',
                'id_level',
                'CASCADE',
                'CASCADE'
            );
           else {
            $this->dropForeignKey('sport_student_list_fk2','sport_student_list' );
            $this->addForeignKey(
                'sport_student_list_fk2',
                'sport_student_list',
                'level_id',
                'levels',
                'id_level',
                'CASCADE',
                'CASCADE'
            );
           }

    }

   public function down()
    {
        echo 'M210225_22939_Sport_student_list cannot be reverted.';


        return false;
    }
    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo M210225_22939_Sport_student_list cannot be reverted.


        return false;
    }
    */
}
