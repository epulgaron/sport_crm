<?php

namespace common\migrations\db;

use yii\db\Migration;

/**
 * Class M210225_220918_Principals
 */
class M210225_220918_Principals extends Migration
{

/**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table_name = $this->db->tablePrefix . 'principals';
        $exist_table = $this->getDb()->getTableSchema($table_name, true);
        /*Generating tables and columns*/
        if ($exist_table === null) {
            $this->createTable('principals',
            [
                'user_id' =>$this->integer(10)->notNull()->unique(),
                 'PRIMARY KEY (`user_id`)'
            ],'ENGINE=InnoDB'
            );

        } else {

            if (!$exist_table->getColumn('user_id'))
                $this->addColumn('principals', 'user_id', $this->integer(10)->notNull()->unique());

            }
        /*Generating index*/

        /*Generating foreignkey*/

        if ($exist_table === null || !array_key_exists('principals_fk1',$exist_table->foreignKeys) || !array_key_exists('user_id',$exist_table->foreignKeys['principals_fk1'])) 
            $this->addForeignKey(
                'principals_fk1',
                'principals',
                'user_id',
                'users',
                'id_user',
                'CASCADE',
                'CASCADE'
            );
           else {
            $this->dropForeignKey('principals_fk1','principals' );
            $this->addForeignKey(
                'principals_fk1',
                'principals',
                'user_id',
                'users',
                'id_user',
                'CASCADE',
                'CASCADE'
            );
           }

    }

   public function down()
    {
        echo 'M210225_22939_Principals cannot be reverted.';


        return false;
    }
    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo M210225_22939_Principals cannot be reverted.


        return false;
    }
    */
}
