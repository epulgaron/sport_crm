<?php

namespace common\migrations\db;

use yii\db\Migration;

/**
 * Class M210225_220912_Schools
 */
class M210225_220912_Schools extends Migration
{

/**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table_name = $this->db->tablePrefix . 'schools';
        $exist_table = $this->getDb()->getTableSchema($table_name, true);
        /*Generating tables and columns*/
        if ($exist_table === null) {
            $this->createTable('schools',
            [
                'id_school' =>$this->integer(10)->append('AUTO_INCREMENT')->notNull()->unique(),
                'school_name' =>$this->string(100)->notNull(),
                'school_email' =>$this->string(50)->notNull(),
                'school_phone' =>$this->string(30),
                'school_address1' =>$this->string(100)->notNull(),
                'school_address2' =>$this->string(100),
                'school_city' =>$this->string(50),
                'school_state' =>$this->string(50),
                'country_id' =>$this->integer(10),
                'school_zip_code' =>$this->integer(10),
                'school_logo' =>$this->string(50),
                 'PRIMARY KEY (`id_school`)'
            ],'ENGINE=InnoDB'
            );

        } else {

            if (!$exist_table->getColumn('id_school'))
                $this->addColumn('schools', 'id_school', $this->integer(10)->append('AUTO_INCREMENT')->notNull()->unique());

            if (!$exist_table->getColumn('school_name'))
                $this->addColumn('schools', 'school_name', $this->string(100)->notNull());
             else{

                $this->alterColumn('schools', 'school_name', 'VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL ');

                }
            if (!$exist_table->getColumn('school_email'))
                $this->addColumn('schools', 'school_email', $this->string(50)->notNull());
             else{

                $this->alterColumn('schools', 'school_email', 'VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL ');

                }
            if (!$exist_table->getColumn('school_phone'))
                $this->addColumn('schools', 'school_phone', $this->string(30));
             else{

                $this->alterColumn('schools', 'school_phone', 'VARCHAR(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci  ');

                }
            if (!$exist_table->getColumn('school_address1'))
                $this->addColumn('schools', 'school_address1', $this->string(100)->notNull());
             else{

                $this->alterColumn('schools', 'school_address1', 'VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL ');

                }
            if (!$exist_table->getColumn('school_address2'))
                $this->addColumn('schools', 'school_address2', $this->string(100));
             else{

                $this->alterColumn('schools', 'school_address2', 'VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci  ');

                }
            if (!$exist_table->getColumn('school_city'))
                $this->addColumn('schools', 'school_city', $this->string(50));
             else{

                $this->alterColumn('schools', 'school_city', 'VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci  ');

                }
            if (!$exist_table->getColumn('school_state'))
                $this->addColumn('schools', 'school_state', $this->string(50));
             else{

                $this->alterColumn('schools', 'school_state', 'VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci  ');

                }
            if (!$exist_table->getColumn('country_id'))
                $this->addColumn('schools', 'country_id', $this->integer(10));

            if (!$exist_table->getColumn('school_zip_code'))
                $this->addColumn('schools', 'school_zip_code', $this->integer(10));
             else{
                $this->alterColumn('schools', 'school_zip_code', $this->integer(10));
                }
            if (!$exist_table->getColumn('school_logo'))
                $this->addColumn('schools', 'school_logo', $this->string(50));
             else{

                $this->alterColumn('schools', 'school_logo', 'VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci  ');

                }
            }
        /*Generating index*/

        if ($exist_table === null || !array_key_exists('school_name', $this->db->getSchema()->findUniqueIndexes($exist_table)))
        $this->createIndex(
                'school_name',
                'schools',
                ['school_name'],
                true
            );
        if ($exist_table === null || !array_key_exists('school_email', $this->db->getSchema()->findUniqueIndexes($exist_table)))
        $this->createIndex(
                'school_email',
                'schools',
                ['school_email'],
                true
            );
        /*Generating foreignkey*/

        if ($exist_table === null || !array_key_exists('schools_fk',$exist_table->foreignKeys) || !array_key_exists('country_id',$exist_table->foreignKeys['schools_fk'])) 
            $this->addForeignKey(
                'schools_fk',
                'schools',
                'country_id',
                'countries',
                'id_country',
                'CASCADE',
                'CASCADE'
            );
           else {
            $this->dropForeignKey('schools_fk','schools' );
            $this->addForeignKey(
                'schools_fk',
                'schools',
                'country_id',
                'countries',
                'id_country',
                'CASCADE',
                'CASCADE'
            );
           }

    }

   public function down()
    {
        echo 'M210225_22939_Schools cannot be reverted.';


        return false;
    }
    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo M210225_22939_Schools cannot be reverted.


        return false;
    }
    */
}
