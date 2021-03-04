<?php

namespace common\migrations\db;

use yii\db\Migration;

/**
 * Class M210225_220905_Permissions
 */
class M210225_220905_Permissions extends Migration
{

/**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table_name = $this->db->tablePrefix . 'permissions';
        $exist_table = $this->getDb()->getTableSchema($table_name, true);
        /*Generating tables and columns*/
        if ($exist_table === null) {
            $this->createTable('permissions',
            [
                'id_permission' =>$this->integer(10)->append('AUTO_INCREMENT')->notNull()->unique(),
                'permission_name' =>$this->string(50)->notNull(),
                'permission_description' =>$this->text(),
                 'PRIMARY KEY (`id_permission`)'
            ],'ENGINE=InnoDB'
            );

        } else {

            if (!$exist_table->getColumn('id_permission'))
                $this->addColumn('permissions', 'id_permission', $this->integer(10)->append('AUTO_INCREMENT')->notNull()->unique());

            if (!$exist_table->getColumn('permission_name'))
                $this->addColumn('permissions', 'permission_name', $this->string(50)->notNull());
             else{

                $this->alterColumn('permissions', 'permission_name', 'VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL ');

                }
            if (!$exist_table->getColumn('permission_description'))
                $this->addColumn('permissions', 'permission_description', $this->text());
             else{
                $this->alterColumn('permissions', 'permission_description', $this->text());
                }
            }
        /*Generating index*/

        if ($exist_table === null || !array_key_exists('permission_name', $this->db->getSchema()->findUniqueIndexes($exist_table)))
        $this->createIndex(
                'permission_name',
                'permissions',
                ['permission_name'],
                true
            );
        /*Generating foreignkey*/


    }

   public function down()
    {
        echo 'M210225_22939_Permissions cannot be reverted.';


        return false;
    }
    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo M210225_22939_Permissions cannot be reverted.


        return false;
    }
    */
}
