<?php

namespace common\migrations\db;

use yii\db\Migration;

/**
 * Class M210225_220916_Contents
 */
class M210225_220916_Contents extends Migration
{

/**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table_name = $this->db->tablePrefix . 'contents';
        $exist_table = $this->getDb()->getTableSchema($table_name, true);
        /*Generating tables and columns*/
        if ($exist_table === null) {
            $this->createTable('contents',
            [
                'id_content' =>$this->integer(10)->append('AUTO_INCREMENT')->notNull()->unique(),
                'content_name' =>$this->string(50)->notNull(),
                'content_description' =>$this->text(),
                'sport_id' =>$this->integer(10)->notNull(),
                'session_id' =>$this->integer(10)->notNull(),
                 'PRIMARY KEY (`id_content`)'
            ],'ENGINE=InnoDB'
            );

        } else {

            if (!$exist_table->getColumn('id_content'))
                $this->addColumn('contents', 'id_content', $this->integer(10)->append('AUTO_INCREMENT')->notNull()->unique());

            if (!$exist_table->getColumn('content_name'))
                $this->addColumn('contents', 'content_name', $this->string(50)->notNull());
             else{

                $this->alterColumn('contents', 'content_name', 'VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL ');

                }
            if (!$exist_table->getColumn('content_description'))
                $this->addColumn('contents', 'content_description', $this->text());
             else{
                $this->alterColumn('contents', 'content_description', $this->text());
                }
            if (!$exist_table->getColumn('sport_id'))
                $this->addColumn('contents', 'sport_id', $this->integer(10)->notNull());

            if (!$exist_table->getColumn('session_id'))
                $this->addColumn('contents', 'session_id', $this->integer(10)->notNull());

            }
        /*Generating index*/

        if ($exist_table === null || !array_key_exists('session_sport', $this->db->getSchema()->findUniqueIndexes($exist_table)))
        $this->createIndex(
                'session_sport',
                'contents',
                ['content_name','sport_id','session_id'],
                true
            );
        /*Generating foreignkey*/

        if ($exist_table === null || !array_key_exists('contents_fk',$exist_table->foreignKeys) || !array_key_exists('sport_id',$exist_table->foreignKeys['contents_fk'])) 
            $this->addForeignKey(
                'contents_fk',
                'contents',
                'sport_id',
                'sports',
                'id_sport',
                'CASCADE',
                'CASCADE'
            );
           else {
            $this->dropForeignKey('contents_fk','contents' );
            $this->addForeignKey(
                'contents_fk',
                'contents',
                'sport_id',
                'sports',
                'id_sport',
                'CASCADE',
                'CASCADE'
            );
           }
        if ($exist_table === null || !array_key_exists('contents_fk1',$exist_table->foreignKeys) || !array_key_exists('session_id',$exist_table->foreignKeys['contents_fk1'])) 
            $this->addForeignKey(
                'contents_fk1',
                'contents',
                'session_id',
                'sessions',
                'id_session',
                'CASCADE',
                'CASCADE'
            );
           else {
            $this->dropForeignKey('contents_fk1','contents' );
            $this->addForeignKey(
                'contents_fk1',
                'contents',
                'session_id',
                'sessions',
                'id_session',
                'CASCADE',
                'CASCADE'
            );
           }

    }

   public function down()
    {
        echo 'M210225_22939_Contents cannot be reverted.';


        return false;
    }
    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo M210225_22939_Contents cannot be reverted.


        return false;
    }
    */
}
