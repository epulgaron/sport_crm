<?php

namespace common\migrations\db;

use yii\db\Migration;

/**
 * Class M210225_220926_Content_error_list
 */
class M210225_220926_Content_error_list extends Migration
{

/**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table_name = $this->db->tablePrefix . 'content_error_list';
        $exist_table = $this->getDb()->getTableSchema($table_name, true);
        /*Generating tables and columns*/
        if ($exist_table === null) {
            $this->createTable('content_error_list',
            [
                'id_content_error_list' =>$this->integer(10)->append('AUTO_INCREMENT')->notNull()->unique(),
                'content_id' =>$this->integer(10)->notNull(),
                'error_id' =>$this->integer(10)->notNull(),
                 'PRIMARY KEY (`id_content_error_list`)'
            ],'ENGINE=InnoDB'
            );

        } else {

            if (!$exist_table->getColumn('id_content_error_list'))
                $this->addColumn('content_error_list', 'id_content_error_list', $this->integer(10)->append('AUTO_INCREMENT')->notNull()->unique());

            if (!$exist_table->getColumn('content_id'))
                $this->addColumn('content_error_list', 'content_id', $this->integer(10)->notNull());

            if (!$exist_table->getColumn('error_id'))
                $this->addColumn('content_error_list', 'error_id', $this->integer(10)->notNull());

            }
        /*Generating index*/

        if ($exist_table === null || !array_key_exists('content_error', $this->db->getSchema()->findUniqueIndexes($exist_table)))
        $this->createIndex(
                'content_error',
                'content_error_list',
                ['content_id','error_id'],
                true
            );
        /*Generating foreignkey*/

        if ($exist_table === null || !array_key_exists('content_error_list_fk',$exist_table->foreignKeys) || !array_key_exists('content_id',$exist_table->foreignKeys['content_error_list_fk'])) 
            $this->addForeignKey(
                'content_error_list_fk',
                'content_error_list',
                'content_id',
                'contents',
                'id_content',
                'CASCADE',
                'CASCADE'
            );
           else {
            $this->dropForeignKey('content_error_list_fk','content_error_list' );
            $this->addForeignKey(
                'content_error_list_fk',
                'content_error_list',
                'content_id',
                'contents',
                'id_content',
                'CASCADE',
                'CASCADE'
            );
           }
        if ($exist_table === null || !array_key_exists('content_error_list_fk1',$exist_table->foreignKeys) || !array_key_exists('error_id',$exist_table->foreignKeys['content_error_list_fk1'])) 
            $this->addForeignKey(
                'content_error_list_fk1',
                'content_error_list',
                'error_id',
                'errors',
                'id_error',
                'CASCADE',
                'CASCADE'
            );
           else {
            $this->dropForeignKey('content_error_list_fk1','content_error_list' );
            $this->addForeignKey(
                'content_error_list_fk1',
                'content_error_list',
                'error_id',
                'errors',
                'id_error',
                'CASCADE',
                'CASCADE'
            );
           }

    }

   public function down()
    {
        echo 'M210225_22939_Content_error_list cannot be reverted.';


        return false;
    }
    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo M210225_22939_Content_error_list cannot be reverted.


        return false;
    }
    */
}
