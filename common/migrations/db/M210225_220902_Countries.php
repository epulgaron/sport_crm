<?php

namespace common\migrations\db;

use yii\db\Migration;

/**
 * Class M210225_220902_Countries
 */
class M210225_220902_Countries extends Migration
{

/**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table_name = $this->db->tablePrefix . 'countries';
        $exist_table = $this->getDb()->getTableSchema($table_name, true);
        /*Generating tables and columns*/
        if ($exist_table === null) {
            $this->createTable('countries',
            [
                'id_country' =>$this->integer(10)->append('AUTO_INCREMENT')->notNull()->unique(),
                'country_acr' =>$this->string(10),
                'country_name' =>$this->string(50)->notNull(),
                 'PRIMARY KEY (`id_country`)'
            ],'ENGINE=InnoDB'
            );

        } else {

            if (!$exist_table->getColumn('id_country'))
                $this->addColumn('countries', 'id_country', $this->integer(10)->append('AUTO_INCREMENT')->notNull()->unique());

            if (!$exist_table->getColumn('country_acr'))
                $this->addColumn('countries', 'country_acr', $this->string(10));
             else{

                $this->alterColumn('countries', 'country_acr', 'VARCHAR(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci  ');

                }
            if (!$exist_table->getColumn('country_name'))
                $this->addColumn('countries', 'country_name', $this->string(50)->notNull());
             else{

                $this->alterColumn('countries', 'country_name', 'VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL ');

                }
            }
        /*Generating index*/

        if ($exist_table === null || !array_key_exists('country_name', $this->db->getSchema()->findUniqueIndexes($exist_table)))
        $this->createIndex(
                'country_name',
                'countries',
                ['country_name'],
                true
            );
        /*Generating foreignkey*/


    }

   public function down()
    {
        echo 'M210225_22939_Countries cannot be reverted.';


        return false;
    }
    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo M210225_22939_Countries cannot be reverted.


        return false;
    }
    */
}
