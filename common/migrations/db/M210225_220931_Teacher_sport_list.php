<?php

namespace common\migrations\db;

use yii\db\Migration;

/**
 * Class M210225_220931_Teacher_sport_list
 */
class M210225_220931_Teacher_sport_list extends Migration
{

/**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table_name = $this->db->tablePrefix . 'teacher_sport_list';
        $exist_table = $this->getDb()->getTableSchema($table_name, true);
        /*Generating tables and columns*/
        if ($exist_table === null) {
            $this->createTable('teacher_sport_list',
            [
                'id_teacher_sport_list' =>$this->integer(10)->append('AUTO_INCREMENT')->notNull()->unique(),
                'teacher_id' =>$this->integer(10)->notNull(),
                'sport_id' =>$this->integer(10)->notNull(),
                 'PRIMARY KEY (`id_teacher_sport_list`)'
            ],'ENGINE=InnoDB'
            );

        } else {

            if (!$exist_table->getColumn('id_teacher_sport_list'))
                $this->addColumn('teacher_sport_list', 'id_teacher_sport_list', $this->integer(10)->append('AUTO_INCREMENT')->notNull()->unique());

            if (!$exist_table->getColumn('teacher_id'))
                $this->addColumn('teacher_sport_list', 'teacher_id', $this->integer(10)->notNull());

            if (!$exist_table->getColumn('sport_id'))
                $this->addColumn('teacher_sport_list', 'sport_id', $this->integer(10)->notNull());

            }
        /*Generating index*/

        if ($exist_table === null || !array_key_exists('teacher_sport', $this->db->getSchema()->findUniqueIndexes($exist_table)))
        $this->createIndex(
                'teacher_sport',
                'teacher_sport_list',
                ['teacher_id','sport_id'],
                true
            );
        /*Generating foreignkey*/

        if ($exist_table === null || !array_key_exists('teacher_sport_list_fk',$exist_table->foreignKeys) || !array_key_exists('teacher_id',$exist_table->foreignKeys['teacher_sport_list_fk'])) 
            $this->addForeignKey(
                'teacher_sport_list_fk',
                'teacher_sport_list',
                'teacher_id',
                'teachers',
                'user_id',
                'CASCADE',
                'CASCADE'
            );
           else {
            $this->dropForeignKey('teacher_sport_list_fk','teacher_sport_list' );
            $this->addForeignKey(
                'teacher_sport_list_fk',
                'teacher_sport_list',
                'teacher_id',
                'teachers',
                'user_id',
                'CASCADE',
                'CASCADE'
            );
           }
        if ($exist_table === null || !array_key_exists('teacher_sport_list_fk1',$exist_table->foreignKeys) || !array_key_exists('sport_id',$exist_table->foreignKeys['teacher_sport_list_fk1'])) 
            $this->addForeignKey(
                'teacher_sport_list_fk1',
                'teacher_sport_list',
                'sport_id',
                'sports',
                'id_sport',
                'CASCADE',
                'CASCADE'
            );
           else {
            $this->dropForeignKey('teacher_sport_list_fk1','teacher_sport_list' );
            $this->addForeignKey(
                'teacher_sport_list_fk1',
                'teacher_sport_list',
                'sport_id',
                'sports',
                'id_sport',
                'CASCADE',
                'CASCADE'
            );
           }

    }

   public function down()
    {
        echo 'M210225_22939_Teacher_sport_list cannot be reverted.';


        return false;
    }
    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo M210225_22939_Teacher_sport_list cannot be reverted.


        return false;
    }
    */
}
