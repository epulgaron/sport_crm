<?php

namespace common\migrations\db;

use yii\db\Migration;

/**
 * Class M210225_220929_Principal_school_list
 */
class M210225_220929_Principal_school_list extends Migration
{

/**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table_name = $this->db->tablePrefix . 'principal_school_list';
        $exist_table = $this->getDb()->getTableSchema($table_name, true);
        /*Generating tables and columns*/
        if ($exist_table === null) {
            $this->createTable('principal_school_list',
            [
                'id_principal_school_list' =>$this->integer(10)->append('AUTO_INCREMENT')->notNull()->unique(),
                'principal_id' =>$this->integer(10)->notNull(),
                'school_id' =>$this->integer(10)->notNull(),
                 'PRIMARY KEY (`id_principal_school_list`)'
            ],'ENGINE=InnoDB'
            );

        } else {

            if (!$exist_table->getColumn('id_principal_school_list'))
                $this->addColumn('principal_school_list', 'id_principal_school_list', $this->integer(10)->append('AUTO_INCREMENT')->notNull()->unique());

            if (!$exist_table->getColumn('principal_id'))
                $this->addColumn('principal_school_list', 'principal_id', $this->integer(10)->notNull());

            if (!$exist_table->getColumn('school_id'))
                $this->addColumn('principal_school_list', 'school_id', $this->integer(10)->notNull());

            }
        /*Generating index*/

        if ($exist_table === null || !array_key_exists('principal_school', $this->db->getSchema()->findUniqueIndexes($exist_table)))
        $this->createIndex(
                'principal_school',
                'principal_school_list',
                ['principal_id','school_id'],
                true
            );
        /*Generating foreignkey*/

        if ($exist_table === null || !array_key_exists('principal_school_list_fk',$exist_table->foreignKeys) || !array_key_exists('principal_id',$exist_table->foreignKeys['principal_school_list_fk'])) 
            $this->addForeignKey(
                'principal_school_list_fk',
                'principal_school_list',
                'principal_id',
                'principals',
                'user_id',
                'CASCADE',
                'CASCADE'
            );
           else {
            $this->dropForeignKey('principal_school_list_fk','principal_school_list' );
            $this->addForeignKey(
                'principal_school_list_fk',
                'principal_school_list',
                'principal_id',
                'principals',
                'user_id',
                'CASCADE',
                'CASCADE'
            );
           }
        if ($exist_table === null || !array_key_exists('principal_school_list_fk1',$exist_table->foreignKeys) || !array_key_exists('school_id',$exist_table->foreignKeys['principal_school_list_fk1'])) 
            $this->addForeignKey(
                'principal_school_list_fk1',
                'principal_school_list',
                'school_id',
                'schools',
                'id_school',
                'CASCADE',
                'CASCADE'
            );
           else {
            $this->dropForeignKey('principal_school_list_fk1','principal_school_list' );
            $this->addForeignKey(
                'principal_school_list_fk1',
                'principal_school_list',
                'school_id',
                'schools',
                'id_school',
                'CASCADE',
                'CASCADE'
            );
           }

    }

   public function down()
    {
        echo 'M210225_22939_Principal_school_list cannot be reverted.';


        return false;
    }
    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo M210225_22939_Principal_school_list cannot be reverted.


        return false;
    }
    */
}
