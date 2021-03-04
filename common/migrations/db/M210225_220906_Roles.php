<?php

namespace common\migrations\db;

use yii\db\Migration;

/**
 * Class M210225_220906_Roles
 */
class M210225_220906_Roles extends Migration
{

/**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table_name = $this->db->tablePrefix . 'roles';
        $exist_table = $this->getDb()->getTableSchema($table_name, true);
        /*Generating tables and columns*/
        if ($exist_table === null) {
            $this->createTable('roles',
            [
                'id_role' =>$this->integer(10)->append('AUTO_INCREMENT')->notNull()->unique(),
                'role_name' =>$this->string(20)->notNull(),
                'role_description' =>$this->text(),
                 'PRIMARY KEY (`id_role`)'
            ],'ENGINE=InnoDB'
            );

        } else {

            if (!$exist_table->getColumn('id_role'))
                $this->addColumn('roles', 'id_role', $this->integer(10)->append('AUTO_INCREMENT')->notNull()->unique());

            if (!$exist_table->getColumn('role_name'))
                $this->addColumn('roles', 'role_name', $this->string(20)->notNull());
             else{

                $this->alterColumn('roles', 'role_name', 'VARCHAR(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL ');

                }
            if (!$exist_table->getColumn('role_description'))
                $this->addColumn('roles', 'role_description', $this->text());
             else{
                $this->alterColumn('roles', 'role_description', $this->text());
                }
            }
        /*Generating index*/

        if ($exist_table === null || !array_key_exists('role_name', $this->db->getSchema()->findUniqueIndexes($exist_table)))
        $this->createIndex(
                'role_name',
                'roles',
                ['role_name'],
                true
            );
        /*Generating foreignkey*/


    }

   public function down()
    {
        echo 'M210225_22939_Roles cannot be reverted.';


        return false;
    }
    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo M210225_22939_Roles cannot be reverted.


        return false;
    }
    */
}
