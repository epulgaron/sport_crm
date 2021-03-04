<?php

namespace common\migrations\db;

use yii\db\Migration;

/**
 * Class M210225_220932_Error_level_list
 */
class M210225_220932_Error_level_list extends Migration
{

/**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table_name = $this->db->tablePrefix . 'error_level_list';
        $exist_table = $this->getDb()->getTableSchema($table_name, true);
        /*Generating tables and columns*/
        if ($exist_table === null) {
            $this->createTable('error_level_list',
            [
                'id_error_level_list' =>$this->integer(10)->append('AUTO_INCREMENT')->notNull()->unique(),
                'error_id' =>$this->integer(10)->notNull(),
                'error_level_id' =>$this->integer(10)->notNull(),
                'eval_id' =>$this->integer(10)->notNull(),
                 'PRIMARY KEY (`id_error_level_list`)'
            ],'ENGINE=InnoDB'
            );

        } else {

            if (!$exist_table->getColumn('id_error_level_list'))
                $this->addColumn('error_level_list', 'id_error_level_list', $this->integer(10)->append('AUTO_INCREMENT')->notNull()->unique());

            if (!$exist_table->getColumn('error_id'))
                $this->addColumn('error_level_list', 'error_id', $this->integer(10)->notNull());

            if (!$exist_table->getColumn('error_level_id'))
                $this->addColumn('error_level_list', 'error_level_id', $this->integer(10)->notNull());

            if (!$exist_table->getColumn('eval_id'))
                $this->addColumn('error_level_list', 'eval_id', $this->integer(10)->notNull());

            }
        /*Generating index*/

        /*Generating foreignkey*/

        if ($exist_table === null || !array_key_exists('Refeval48',$exist_table->foreignKeys) || !array_key_exists('eval_id',$exist_table->foreignKeys['Refeval48'])) 
            $this->addForeignKey(
                'Refeval48',
                'error_level_list',
                'eval_id',
                'evaluation',
                'id_eval',
                'NO ACTION',
                'NO ACTION'
            );
           else {
            $this->dropForeignKey('Refeval48','error_level_list' );
            $this->addForeignKey(
                'Refeval48',
                'error_level_list',
                'eval_id',
                'evaluation',
                'id_eval',
                'NO ACTION',
                'NO ACTION'
            );
           }
        if ($exist_table === null || !array_key_exists('error_level_list_fk',$exist_table->foreignKeys) || !array_key_exists('error_id',$exist_table->foreignKeys['error_level_list_fk'])) 
            $this->addForeignKey(
                'error_level_list_fk',
                'error_level_list',
                'error_id',
                'errors',
                'id_error',
                'CASCADE',
                'CASCADE'
            );
           else {
            $this->dropForeignKey('error_level_list_fk','error_level_list' );
            $this->addForeignKey(
                'error_level_list_fk',
                'error_level_list',
                'error_id',
                'errors',
                'id_error',
                'CASCADE',
                'CASCADE'
            );
           }
        if ($exist_table === null || !array_key_exists('error_level_list_fk1',$exist_table->foreignKeys) || !array_key_exists('error_level_id',$exist_table->foreignKeys['error_level_list_fk1'])) 
            $this->addForeignKey(
                'error_level_list_fk1',
                'error_level_list',
                'error_level_id',
                'error_level',
                'id_error_level',
                'CASCADE',
                'CASCADE'
            );
           else {
            $this->dropForeignKey('error_level_list_fk1','error_level_list' );
            $this->addForeignKey(
                'error_level_list_fk1',
                'error_level_list',
                'error_level_id',
                'error_level',
                'id_error_level',
                'CASCADE',
                'CASCADE'
            );
           }

    }

   public function down()
    {
        echo 'M210225_22939_Error_level_list cannot be reverted.';


        return false;
    }
    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo M210225_22939_Error_level_list cannot be reverted.


        return false;
    }
    */
}
