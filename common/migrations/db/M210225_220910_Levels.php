<?php

namespace common\migrations\db;

use yii\db\Migration;

/**
 * Class M210225_220910_Levels
 */
class M210225_220910_Levels extends Migration
{

/**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table_name = $this->db->tablePrefix . 'levels';
        $exist_table = $this->getDb()->getTableSchema($table_name, true);
        /*Generating tables and columns*/
        if ($exist_table === null) {
            $this->createTable('levels',
            [
                'id_level' =>$this->integer(10)->append('AUTO_INCREMENT')->notNull()->unique(),
                'level_acr' =>$this->string(10),
                'level_name' =>$this->string(30)->notNull(),
                'sport_id' =>$this->integer(10)->notNull(),
                 'PRIMARY KEY (`id_level`)'
            ],'ENGINE=InnoDB'
            );

        } else {

            if (!$exist_table->getColumn('id_level'))
                $this->addColumn('levels', 'id_level', $this->integer(10)->append('AUTO_INCREMENT')->notNull()->unique());

            if (!$exist_table->getColumn('level_acr'))
                $this->addColumn('levels', 'level_acr', $this->string(10));
             else{

                $this->alterColumn('levels', 'level_acr', 'VARCHAR(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci  ');

                }
            if (!$exist_table->getColumn('level_name'))
                $this->addColumn('levels', 'level_name', $this->string(30)->notNull());
             else{

                $this->alterColumn('levels', 'level_name', 'VARCHAR(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL ');

                }
            if (!$exist_table->getColumn('sport_id'))
                $this->addColumn('levels', 'sport_id', $this->integer(10)->notNull());

            }
        /*Generating index*/

        if ($exist_table === null || !array_key_exists('level_sport', $this->db->getSchema()->findUniqueIndexes($exist_table)))
        $this->createIndex(
                'level_sport',
                'levels',
                ['level_name','sport_id'],
                true
            );
        /*Generating foreignkey*/

        if ($exist_table === null || !array_key_exists('levels_fk',$exist_table->foreignKeys) || !array_key_exists('sport_id',$exist_table->foreignKeys['levels_fk'])) 
            $this->addForeignKey(
                'levels_fk',
                'levels',
                'sport_id',
                'sports',
                'id_sport',
                'CASCADE',
                'CASCADE'
            );
           else {
            $this->dropForeignKey('levels_fk','levels' );
            $this->addForeignKey(
                'levels_fk',
                'levels',
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
        echo 'M210225_22939_Levels cannot be reverted.';


        return false;
    }
    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo M210225_22939_Levels cannot be reverted.


        return false;
    }
    */
}
