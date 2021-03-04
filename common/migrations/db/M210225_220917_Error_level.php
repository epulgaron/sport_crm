<?php

namespace common\migrations\db;

use yii\db\Migration;

/**
 * Class M210225_220917_Error_level
 */
class M210225_220917_Error_level extends Migration
{

/**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table_name = $this->db->tablePrefix . 'error_level';
        $exist_table = $this->getDb()->getTableSchema($table_name, true);
        /*Generating tables and columns*/
        if ($exist_table === null) {
            $this->createTable('error_level',
            [
                'id_error_level' =>$this->integer(10)->append('AUTO_INCREMENT')->notNull()->unique(),
                'error_level_name' =>$this->integer(10)->notNull(),
                'error_level_eval' =>$this->integer(10)->notNull(),
                'school_id' =>$this->integer(10)->notNull(),
                'sport_id' =>$this->integer(10)->notNull(),
                 'PRIMARY KEY (`id_error_level`)'
            ],'ENGINE=InnoDB'
            );

        } else {

            if (!$exist_table->getColumn('id_error_level'))
                $this->addColumn('error_level', 'id_error_level', $this->integer(10)->append('AUTO_INCREMENT')->notNull()->unique());

            if (!$exist_table->getColumn('error_level_name'))
                $this->addColumn('error_level', 'error_level_name', $this->integer(10)->notNull());
             else{
                $this->alterColumn('error_level', 'error_level_name', $this->integer(10)->notNull());
                }
            if (!$exist_table->getColumn('error_level_eval'))
                $this->addColumn('error_level', 'error_level_eval', $this->integer(10)->notNull());
             else{
                $this->alterColumn('error_level', 'error_level_eval', $this->integer(10)->notNull());
                }
            if (!$exist_table->getColumn('school_id'))
                $this->addColumn('error_level', 'school_id', $this->integer(10)->notNull());

            if (!$exist_table->getColumn('sport_id'))
                $this->addColumn('error_level', 'sport_id', $this->integer(10)->notNull());

            }
        /*Generating index*/

        /*Generating foreignkey*/

        if ($exist_table === null || !array_key_exists('Refschools49',$exist_table->foreignKeys) || !array_key_exists('school_id',$exist_table->foreignKeys['Refschools49'])) 
            $this->addForeignKey(
                'Refschools49',
                'error_level',
                'school_id',
                'schools',
                'id_school',
                'NO ACTION',
                'NO ACTION'
            );
           else {
            $this->dropForeignKey('Refschools49','error_level' );
            $this->addForeignKey(
                'Refschools49',
                'error_level',
                'school_id',
                'schools',
                'id_school',
                'NO ACTION',
                'NO ACTION'
            );
           }
        if ($exist_table === null || !array_key_exists('error_level_fk',$exist_table->foreignKeys) || !array_key_exists('sport_id',$exist_table->foreignKeys['error_level_fk'])) 
            $this->addForeignKey(
                'error_level_fk',
                'error_level',
                'sport_id',
                'sports',
                'id_sport',
                'CASCADE',
                'CASCADE'
            );
           else {
            $this->dropForeignKey('error_level_fk','error_level' );
            $this->addForeignKey(
                'error_level_fk',
                'error_level',
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
        echo 'M210225_22939_Error_level cannot be reverted.';


        return false;
    }
    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo M210225_22939_Error_level cannot be reverted.


        return false;
    }
    */
}
