<?php

namespace common\migrations\db;

use yii\db\Migration;

/**
 * Class M210225_220919_Session_level_list
 */
class M210225_220919_Session_level_list extends Migration
{

/**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table_name = $this->db->tablePrefix . 'session_level_list';
        $exist_table = $this->getDb()->getTableSchema($table_name, true);
        /*Generating tables and columns*/
        if ($exist_table === null) {
            $this->createTable('session_level_list',
            [
                'id_session_level' =>$this->integer(10)->append('AUTO_INCREMENT')->notNull()->unique(),
                'session_id' =>$this->integer(10)->notNull(),
                'level_id' =>$this->integer(10)->notNull(),
                 'PRIMARY KEY (`id_session_level`)'
            ],'ENGINE=InnoDB'
            );

        } else {

            if (!$exist_table->getColumn('id_session_level'))
                $this->addColumn('session_level_list', 'id_session_level', $this->integer(10)->append('AUTO_INCREMENT')->notNull()->unique());

            if (!$exist_table->getColumn('session_id'))
                $this->addColumn('session_level_list', 'session_id', $this->integer(10)->notNull());

            if (!$exist_table->getColumn('level_id'))
                $this->addColumn('session_level_list', 'level_id', $this->integer(10)->notNull());

            }
        /*Generating index*/

        if ($exist_table === null || !array_key_exists('session_level', $this->db->getSchema()->findUniqueIndexes($exist_table)))
        $this->createIndex(
                'session_level',
                'session_level_list',
                ['session_id','level_id'],
                true
            );
        /*Generating foreignkey*/

        if ($exist_table === null || !array_key_exists('session_level_fk',$exist_table->foreignKeys) || !array_key_exists('session_id',$exist_table->foreignKeys['session_level_fk'])) 
            $this->addForeignKey(
                'session_level_fk',
                'session_level_list',
                'session_id',
                'sessions',
                'id_session',
                'CASCADE',
                'CASCADE'
            );
           else {
            $this->dropForeignKey('session_level_fk','session_level_list' );
            $this->addForeignKey(
                'session_level_fk',
                'session_level_list',
                'session_id',
                'sessions',
                'id_session',
                'CASCADE',
                'CASCADE'
            );
           }
        if ($exist_table === null || !array_key_exists('session_level_fk1',$exist_table->foreignKeys) || !array_key_exists('level_id',$exist_table->foreignKeys['session_level_fk1'])) 
            $this->addForeignKey(
                'session_level_fk1',
                'session_level_list',
                'level_id',
                'levels',
                'id_level',
                'CASCADE',
                'CASCADE'
            );
           else {
            $this->dropForeignKey('session_level_fk1','session_level_list' );
            $this->addForeignKey(
                'session_level_fk1',
                'session_level_list',
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
        echo 'M210225_22939_Session_level_list cannot be reverted.';


        return false;
    }
    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo M210225_22939_Session_level_list cannot be reverted.


        return false;
    }
    */
}
