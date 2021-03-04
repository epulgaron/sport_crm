<?php

namespace common\migrations\db;

use yii\db\Migration;

/**
 * Class M210225_220914_Tests
 */
class M210225_220914_Tests extends Migration
{

/**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table_name = $this->db->tablePrefix . 'tests';
        $exist_table = $this->getDb()->getTableSchema($table_name, true);
        /*Generating tables and columns*/
        if ($exist_table === null) {
            $this->createTable('tests',
            [
                'id_test' =>$this->integer(10)->append('AUTO_INCREMENT')->notNull()->unique(),
                'test_name' =>$this->integer(10)->notNull(),
                'test_date' =>$this->date()->notNull(),
                'flow_id' =>$this->integer(10)->notNull(),
                'sport_id' =>$this->integer(10)->notNull(),
                'type_id' =>$this->integer(10)->notNull(),
                'school_id' =>$this->integer(10)->notNull(),
                'status_id' =>$this->integer(10)->notNull(),
                'final_date' =>$this->date(),
                 'PRIMARY KEY (`id_test`)'
            ],'ENGINE=InnoDB'
            );

        } else {

            if (!$exist_table->getColumn('id_test'))
                $this->addColumn('tests', 'id_test', $this->integer(10)->append('AUTO_INCREMENT')->notNull()->unique());

            if (!$exist_table->getColumn('test_name'))
                $this->addColumn('tests', 'test_name', $this->integer(10)->notNull());
             else{
                $this->alterColumn('tests', 'test_name', $this->integer(10)->notNull());
                }
            if (!$exist_table->getColumn('test_date'))
                $this->addColumn('tests', 'test_date', $this->date()->notNull());
             else{
                $this->alterColumn('tests', 'test_date', $this->date()->notNull());
                }
            if (!$exist_table->getColumn('flow_id'))
                $this->addColumn('tests', 'flow_id', $this->integer(10)->notNull());

            if (!$exist_table->getColumn('sport_id'))
                $this->addColumn('tests', 'sport_id', $this->integer(10)->notNull());

            if (!$exist_table->getColumn('type_id'))
                $this->addColumn('tests', 'type_id', $this->integer(10)->notNull());

            if (!$exist_table->getColumn('school_id'))
                $this->addColumn('tests', 'school_id', $this->integer(10)->notNull());

            if (!$exist_table->getColumn('status_id'))
                $this->addColumn('tests', 'status_id', $this->integer(10)->notNull());

            if (!$exist_table->getColumn('final_date'))
                $this->addColumn('tests', 'final_date', $this->date());
             else{
                $this->alterColumn('tests', 'final_date', $this->date());
                }
            }
        /*Generating index*/

        /*Generating foreignkey*/

        if ($exist_table === null || !array_key_exists('tests_fk',$exist_table->foreignKeys) || !array_key_exists('status_id',$exist_table->foreignKeys['tests_fk'])) 
            $this->addForeignKey(
                'tests_fk',
                'tests',
                'status_id',
                'status',
                'id_status',
                'CASCADE',
                'CASCADE'
            );
           else {
            $this->dropForeignKey('tests_fk','tests' );
            $this->addForeignKey(
                'tests_fk',
                'tests',
                'status_id',
                'status',
                'id_status',
                'CASCADE',
                'CASCADE'
            );
           }
        if ($exist_table === null || !array_key_exists('tests_fk1',$exist_table->foreignKeys) || !array_key_exists('flow_id',$exist_table->foreignKeys['tests_fk1'])) 
            $this->addForeignKey(
                'tests_fk1',
                'tests',
                'flow_id',
                'flows',
                'id_flow',
                'CASCADE',
                'CASCADE'
            );
           else {
            $this->dropForeignKey('tests_fk1','tests' );
            $this->addForeignKey(
                'tests_fk1',
                'tests',
                'flow_id',
                'flows',
                'id_flow',
                'CASCADE',
                'CASCADE'
            );
           }
        if ($exist_table === null || !array_key_exists('tests_fk2',$exist_table->foreignKeys) || !array_key_exists('school_id',$exist_table->foreignKeys['tests_fk2'])) 
            $this->addForeignKey(
                'tests_fk2',
                'tests',
                'school_id',
                'schools',
                'id_school',
                'CASCADE',
                'CASCADE'
            );
           else {
            $this->dropForeignKey('tests_fk2','tests' );
            $this->addForeignKey(
                'tests_fk2',
                'tests',
                'school_id',
                'schools',
                'id_school',
                'CASCADE',
                'CASCADE'
            );
           }
        if ($exist_table === null || !array_key_exists('tests_fk3',$exist_table->foreignKeys) || !array_key_exists('sport_id',$exist_table->foreignKeys['tests_fk3'])) 
            $this->addForeignKey(
                'tests_fk3',
                'tests',
                'sport_id',
                'sports',
                'id_sport',
                'CASCADE',
                'CASCADE'
            );
           else {
            $this->dropForeignKey('tests_fk3','tests' );
            $this->addForeignKey(
                'tests_fk3',
                'tests',
                'sport_id',
                'sports',
                'id_sport',
                'CASCADE',
                'CASCADE'
            );
           }
        if ($exist_table === null || !array_key_exists('tests_fk4',$exist_table->foreignKeys) || !array_key_exists('type_id',$exist_table->foreignKeys['tests_fk4'])) 
            $this->addForeignKey(
                'tests_fk4',
                'tests',
                'type_id',
                'types',
                'id_type',
                'CASCADE',
                'CASCADE'
            );
           else {
            $this->dropForeignKey('tests_fk4','tests' );
            $this->addForeignKey(
                'tests_fk4',
                'tests',
                'type_id',
                'types',
                'id_type',
                'CASCADE',
                'CASCADE'
            );
           }

    }

   public function down()
    {
        echo 'M210225_22939_Tests cannot be reverted.';


        return false;
    }
    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo M210225_22939_Tests cannot be reverted.


        return false;
    }
    */
}
