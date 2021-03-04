<?php

namespace common\migrations\db;

use yii\db\Migration;

/**
 * Class M210225_220921_Teachers
 */
class M210225_220921_Teachers extends Migration
{

/**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table_name = $this->db->tablePrefix . 'teachers';
        $exist_table = $this->getDb()->getTableSchema($table_name, true);
        /*Generating tables and columns*/
        if ($exist_table === null) {
            $this->createTable('teachers',
            [
                'user_id' =>$this->integer(10)->notNull()->unique(),
                'teacher_address' =>$this->string(100),
                'school_id' =>$this->integer(10)->notNull(),
                'external' =>$this->tinyInteger(3),
                 'PRIMARY KEY (`user_id`)'
            ],'ENGINE=InnoDB'
            );

        } else {

            if (!$exist_table->getColumn('user_id'))
                $this->addColumn('teachers', 'user_id', $this->integer(10)->notNull()->unique());

            if (!$exist_table->getColumn('teacher_address'))
                $this->addColumn('teachers', 'teacher_address', $this->string(100));
             else{

                $this->alterColumn('teachers', 'teacher_address', 'VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci  ');

                }
            if (!$exist_table->getColumn('school_id'))
                $this->addColumn('teachers', 'school_id', $this->integer(10)->notNull());

            if (!$exist_table->getColumn('external'))
                $this->addColumn('teachers', 'external', $this->tinyInteger(3));
             else{
                $this->alterColumn('teachers', 'external', $this->tinyInteger(3));
                }
            }
        /*Generating index*/

        /*Generating foreignkey*/

        if ($exist_table === null || !array_key_exists('teachers_fk',$exist_table->foreignKeys) || !array_key_exists('school_id',$exist_table->foreignKeys['teachers_fk'])) 
            $this->addForeignKey(
                'teachers_fk',
                'teachers',
                'school_id',
                'schools',
                'id_school',
                'CASCADE',
                'CASCADE'
            );
           else {
            $this->dropForeignKey('teachers_fk','teachers' );
            $this->addForeignKey(
                'teachers_fk',
                'teachers',
                'school_id',
                'schools',
                'id_school',
                'CASCADE',
                'CASCADE'
            );
           }
        if ($exist_table === null || !array_key_exists('teachers_fk2',$exist_table->foreignKeys) || !array_key_exists('user_id',$exist_table->foreignKeys['teachers_fk2'])) 
            $this->addForeignKey(
                'teachers_fk2',
                'teachers',
                'user_id',
                'users',
                'id_user',
                'CASCADE',
                'CASCADE'
            );
           else {
            $this->dropForeignKey('teachers_fk2','teachers' );
            $this->addForeignKey(
                'teachers_fk2',
                'teachers',
                'user_id',
                'users',
                'id_user',
                'CASCADE',
                'CASCADE'
            );
           }

    }

   public function down()
    {
        echo 'M210225_22939_Teachers cannot be reverted.';


        return false;
    }
    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo M210225_22939_Teachers cannot be reverted.


        return false;
    }
    */
}
