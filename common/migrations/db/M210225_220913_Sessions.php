<?php

namespace common\migrations\db;

use yii\db\Migration;

/**
 * Class M210225_220913_Sessions
 */
class M210225_220913_Sessions extends Migration
{

/**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table_name = $this->db->tablePrefix . 'sessions';
        $exist_table = $this->getDb()->getTableSchema($table_name, true);
        /*Generating tables and columns*/
        if ($exist_table === null) {
            $this->createTable('sessions',
            [
                'id_session' =>$this->integer(10)->append('AUTO_INCREMENT')->notNull()->unique(),
                'session_name' =>$this->string(50)->notNull(),
                'sport_id' =>$this->integer(10)->notNull(),
                 'PRIMARY KEY (`id_session`)'
            ],'ENGINE=InnoDB'
            );

        } else {

            if (!$exist_table->getColumn('id_session'))
                $this->addColumn('sessions', 'id_session', $this->integer(10)->append('AUTO_INCREMENT')->notNull()->unique());

            if (!$exist_table->getColumn('session_name'))
                $this->addColumn('sessions', 'session_name', $this->string(50)->notNull());
             else{

                $this->alterColumn('sessions', 'session_name', 'VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL ');

                }
            if (!$exist_table->getColumn('sport_id'))
                $this->addColumn('sessions', 'sport_id', $this->integer(10)->notNull());

            }
        /*Generating index*/

        if ($exist_table === null || !array_key_exists('session_name', $this->db->getSchema()->findUniqueIndexes($exist_table)))
        $this->createIndex(
                'session_name',
                'sessions',
                ['session_name','sport_id'],
                true
            );
        /*Generating foreignkey*/

        if ($exist_table === null || !array_key_exists('sessions_fk',$exist_table->foreignKeys) || !array_key_exists('sport_id',$exist_table->foreignKeys['sessions_fk'])) 
            $this->addForeignKey(
                'sessions_fk',
                'sessions',
                'sport_id',
                'sports',
                'id_sport',
                'CASCADE',
                'CASCADE'
            );
           else {
            $this->dropForeignKey('sessions_fk','sessions' );
            $this->addForeignKey(
                'sessions_fk',
                'sessions',
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
        echo 'M210225_22939_Sessions cannot be reverted.';


        return false;
    }
    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo M210225_22939_Sessions cannot be reverted.


        return false;
    }
    */
}
