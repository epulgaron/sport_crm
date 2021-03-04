<?php

namespace common\migrations\db;

use yii\db\Migration;

/**
 * Class M210225_220915_Users
 */
class M210225_220915_Users extends Migration
{

/**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table_name = $this->db->tablePrefix . 'users';
        $exist_table = $this->getDb()->getTableSchema($table_name, true);
        /*Generating tables and columns*/
        if ($exist_table === null) {
            $this->createTable('users',
            [
                'id_user' =>$this->integer(10)->append('AUTO_INCREMENT')->notNull()->unique(),
                'user_first_name' =>$this->string(50)->notNull(),
                'user_last_name' =>$this->string(50)->notNull(),
                'user_email' =>$this->string(50)->notNull(),
                'user_phone' =>$this->string(30),
                'user_password' =>$this->string(50),
                'role_id' =>$this->integer(10)->notNull(),
                 'PRIMARY KEY (`id_user`)'
            ],'ENGINE=InnoDB'
            );

        } else {

            if (!$exist_table->getColumn('id_user'))
                $this->addColumn('users', 'id_user', $this->integer(10)->append('AUTO_INCREMENT')->notNull()->unique());

            if (!$exist_table->getColumn('user_first_name'))
                $this->addColumn('users', 'user_first_name', $this->string(50)->notNull());
             else{

                $this->alterColumn('users', 'user_first_name', 'VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL ');

                }
            if (!$exist_table->getColumn('user_last_name'))
                $this->addColumn('users', 'user_last_name', $this->string(50)->notNull());
             else{

                $this->alterColumn('users', 'user_last_name', 'VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL ');

                }
            if (!$exist_table->getColumn('user_email'))
                $this->addColumn('users', 'user_email', $this->string(50)->notNull());
             else{

                $this->alterColumn('users', 'user_email', 'VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL ');

                }
            if (!$exist_table->getColumn('user_phone'))
                $this->addColumn('users', 'user_phone', $this->string(30));
             else{

                $this->alterColumn('users', 'user_phone', 'VARCHAR(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci  ');

                }
            if (!$exist_table->getColumn('user_password'))
                $this->addColumn('users', 'user_password', $this->string(50));
             else{

                $this->alterColumn('users', 'user_password', 'VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci  ');

                }
            if (!$exist_table->getColumn('role_id'))
                $this->addColumn('users', 'role_id', $this->integer(10)->notNull());

            }
        /*Generating index*/

        /*Generating foreignkey*/

        if ($exist_table === null || !array_key_exists('users_fk',$exist_table->foreignKeys) || !array_key_exists('role_id',$exist_table->foreignKeys['users_fk'])) 
            $this->addForeignKey(
                'users_fk',
                'users',
                'role_id',
                'roles',
                'id_role',
                'CASCADE',
                'CASCADE'
            );
           else {
            $this->dropForeignKey('users_fk','users' );
            $this->addForeignKey(
                'users_fk',
                'users',
                'role_id',
                'roles',
                'id_role',
                'CASCADE',
                'CASCADE'
            );
           }

    }

   public function down()
    {
        echo 'M210225_22939_Users cannot be reverted.';


        return false;
    }
    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo M210225_22939_Users cannot be reverted.


        return false;
    }
    */
}
