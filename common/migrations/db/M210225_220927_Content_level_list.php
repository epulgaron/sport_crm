<?php

namespace common\migrations\db;

use yii\db\Migration;

/**
 * Class M210225_220927_Content_level_list
 */
class M210225_220927_Content_level_list extends Migration
{

/**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table_name = $this->db->tablePrefix . 'content_level_list';
        $exist_table = $this->getDb()->getTableSchema($table_name, true);
        /*Generating tables and columns*/
        if ($exist_table === null) {
            $this->createTable('content_level_list',
            [
                'id_content_level_list' =>$this->integer(10)->append('AUTO_INCREMENT')->notNull()->unique(),
                'content_id' =>$this->integer(10)->notNull(),
                'level_id' =>$this->integer(10)->notNull(),
                 'PRIMARY KEY (`id_content_level_list`)'
            ],'ENGINE=InnoDB'
            );

        } else {

            if (!$exist_table->getColumn('id_content_level_list'))
                $this->addColumn('content_level_list', 'id_content_level_list', $this->integer(10)->append('AUTO_INCREMENT')->notNull()->unique());

            if (!$exist_table->getColumn('content_id'))
                $this->addColumn('content_level_list', 'content_id', $this->integer(10)->notNull());

            if (!$exist_table->getColumn('level_id'))
                $this->addColumn('content_level_list', 'level_id', $this->integer(10)->notNull());

            }
        /*Generating index*/

        if ($exist_table === null || !array_key_exists('content_level', $this->db->getSchema()->findUniqueIndexes($exist_table)))
        $this->createIndex(
                'content_level',
                'content_level_list',
                ['content_id','level_id'],
                true
            );
        /*Generating foreignkey*/

        if ($exist_table === null || !array_key_exists('content_level_list_fk',$exist_table->foreignKeys) || !array_key_exists('content_id',$exist_table->foreignKeys['content_level_list_fk'])) 
            $this->addForeignKey(
                'content_level_list_fk',
                'content_level_list',
                'content_id',
                'contents',
                'id_content',
                'CASCADE',
                'CASCADE'
            );
           else {
            $this->dropForeignKey('content_level_list_fk','content_level_list' );
            $this->addForeignKey(
                'content_level_list_fk',
                'content_level_list',
                'content_id',
                'contents',
                'id_content',
                'CASCADE',
                'CASCADE'
            );
           }
        if ($exist_table === null || !array_key_exists('content_level_list_fk1',$exist_table->foreignKeys) || !array_key_exists('level_id',$exist_table->foreignKeys['content_level_list_fk1'])) 
            $this->addForeignKey(
                'content_level_list_fk1',
                'content_level_list',
                'level_id',
                'levels',
                'id_level',
                'CASCADE',
                'CASCADE'
            );
           else {
            $this->dropForeignKey('content_level_list_fk1','content_level_list' );
            $this->addForeignKey(
                'content_level_list_fk1',
                'content_level_list',
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
        echo 'M210225_22939_Content_level_list cannot be reverted.';


        return false;
    }
    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo M210225_22939_Content_level_list cannot be reverted.


        return false;
    }
    */
}
