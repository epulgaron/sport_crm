<?php

namespace common\migrations\db;

use yii\db\Migration;

/**
 * Class M210225_220907_Sports
 */
class M210225_220907_Sports extends Migration
{

/**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table_name = $this->db->tablePrefix . 'sports';
        $exist_table = $this->getDb()->getTableSchema($table_name, true);
        /*Generating tables and columns*/
        if ($exist_table === null) {
            $this->createTable('sports',
            [
                'id_sport' =>$this->integer(10)->append('AUTO_INCREMENT')->notNull()->unique(),
                'sport_name' =>$this->string(50)->notNull(),
                 'PRIMARY KEY (`id_sport`)'
            ],'ENGINE=InnoDB'
            );

        } else {

            if (!$exist_table->getColumn('id_sport'))
                $this->addColumn('sports', 'id_sport', $this->integer(10)->append('AUTO_INCREMENT')->notNull()->unique());

            if (!$exist_table->getColumn('sport_name'))
                $this->addColumn('sports', 'sport_name', $this->string(50)->notNull());
             else{

                $this->alterColumn('sports', 'sport_name', 'VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL ');

                }
            }
        /*Generating index*/

        if ($exist_table === null || !array_key_exists('sport_name', $this->db->getSchema()->findUniqueIndexes($exist_table)))
        $this->createIndex(
                'sport_name',
                'sports',
                ['sport_name'],
                true
            );
        /*Generating foreignkey*/


    }

   public function down()
    {
        echo 'M210225_22939_Sports cannot be reverted.';


        return false;
    }
    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo M210225_22939_Sports cannot be reverted.


        return false;
    }
    */
}
