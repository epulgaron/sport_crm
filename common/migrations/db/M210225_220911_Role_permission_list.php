<?php

namespace common\migrations\db;

use yii\db\Migration;

/**
 * Class M210225_220911_Role_permission_list
 */
class M210225_220911_Role_permission_list extends Migration
{

/**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table_name = $this->db->tablePrefix . 'role_permission_list';
        $exist_table = $this->getDb()->getTableSchema($table_name, true);
        /*Generating tables and columns*/
        if ($exist_table === null) {
            $this->createTable('role_permission_list',
            [
                'id_role_permission' =>$this->integer(10)->append('AUTO_INCREMENT')->notNull()->unique(),
                'role_id' =>$this->integer(10)->notNull(),
                'permission_id' =>$this->integer(10)->notNull(),
                 'PRIMARY KEY (`id_role_permission`)'
            ],'ENGINE=InnoDB'
            );

        } else {

            if (!$exist_table->getColumn('id_role_permission'))
                $this->addColumn('role_permission_list', 'id_role_permission', $this->integer(10)->append('AUTO_INCREMENT')->notNull()->unique());

            if (!$exist_table->getColumn('role_id'))
                $this->addColumn('role_permission_list', 'role_id', $this->integer(10)->notNull());

            if (!$exist_table->getColumn('permission_id'))
                $this->addColumn('role_permission_list', 'permission_id', $this->integer(10)->notNull());

            }
        /*Generating index*/

        if ($exist_table === null || !array_key_exists('role_permission', $this->db->getSchema()->findUniqueIndexes($exist_table)))
        $this->createIndex(
                'role_permission',
                'role_permission_list',
                ['role_id','permission_id'],
                true
            );
        /*Generating foreignkey*/

        if ($exist_table === null || !array_key_exists('role_permission_list_fk',$exist_table->foreignKeys) || !array_key_exists('role_id',$exist_table->foreignKeys['role_permission_list_fk'])) 
            $this->addForeignKey(
                'role_permission_list_fk',
                'role_permission_list',
                'role_id',
                'roles',
                'id_role',
                'CASCADE',
                'CASCADE'
            );
           else {
            $this->dropForeignKey('role_permission_list_fk','role_permission_list' );
            $this->addForeignKey(
                'role_permission_list_fk',
                'role_permission_list',
                'role_id',
                'roles',
                'id_role',
                'CASCADE',
                'CASCADE'
            );
           }
        if ($exist_table === null || !array_key_exists('role_permission_list_fk1',$exist_table->foreignKeys) || !array_key_exists('permission_id',$exist_table->foreignKeys['role_permission_list_fk1'])) 
            $this->addForeignKey(
                'role_permission_list_fk1',
                'role_permission_list',
                'permission_id',
                'permissions',
                'id_permission',
                'CASCADE',
                'CASCADE'
            );
           else {
            $this->dropForeignKey('role_permission_list_fk1','role_permission_list' );
            $this->addForeignKey(
                'role_permission_list_fk1',
                'role_permission_list',
                'permission_id',
                'permissions',
                'id_permission',
                'CASCADE',
                'CASCADE'
            );
           }

    }

   public function down()
    {
        echo 'M210225_22939_Role_permission_list cannot be reverted.';


        return false;
    }
    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo M210225_22939_Role_permission_list cannot be reverted.


        return false;
    }
    */
}
