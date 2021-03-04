<?php

namespace common\migrations\db;

use yii\db\Migration;

/**
 * Class M210225_220920_Students
 */
class M210225_220920_Students extends Migration
{

/**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table_name = $this->db->tablePrefix . 'students';
        $exist_table = $this->getDb()->getTableSchema($table_name, true);
        /*Generating tables and columns*/
        if ($exist_table === null) {
            $this->createTable('students',
            [
                'user_id' =>$this->integer(10)->notNull()->unique(),
                'student_address1' =>$this->string(100)->notNull(),
                'student_address2' =>$this->string(100),
                'student_city' =>$this->string(50),
                'student_state' =>$this->string(50),
                'student_zip_code' =>$this->integer(10),
                'student_dob' =>$this->date(),
                'student_picture' =>$this->string(50),
                'student_legal_age' =>$this->tinyInteger(3),
                'student_tutor_first_name' =>$this->string(50)->notNull(),
                'student_tutor_last_name' =>$this->string(50),
                'studen_tutor_email' =>$this->string(50),
                'school_id' =>$this->integer(10)->notNull(),
                 'PRIMARY KEY (`user_id`)'
            ],'ENGINE=InnoDB'
            );

        } else {

            if (!$exist_table->getColumn('user_id'))
                $this->addColumn('students', 'user_id', $this->integer(10)->notNull()->unique());

            if (!$exist_table->getColumn('student_address1'))
                $this->addColumn('students', 'student_address1', $this->string(100)->notNull());
             else{

                $this->alterColumn('students', 'student_address1', 'VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL ');

                }
            if (!$exist_table->getColumn('student_address2'))
                $this->addColumn('students', 'student_address2', $this->string(100));
             else{

                $this->alterColumn('students', 'student_address2', 'VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci  ');

                }
            if (!$exist_table->getColumn('student_city'))
                $this->addColumn('students', 'student_city', $this->string(50));
             else{

                $this->alterColumn('students', 'student_city', 'VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci  ');

                }
            if (!$exist_table->getColumn('student_state'))
                $this->addColumn('students', 'student_state', $this->string(50));
             else{

                $this->alterColumn('students', 'student_state', 'VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci  ');

                }
            if (!$exist_table->getColumn('student_zip_code'))
                $this->addColumn('students', 'student_zip_code', $this->integer(10));
             else{
                $this->alterColumn('students', 'student_zip_code', $this->integer(10));
                }
            if (!$exist_table->getColumn('student_dob'))
                $this->addColumn('students', 'student_dob', $this->date());
             else{
                $this->alterColumn('students', 'student_dob', $this->date());
                }
            if (!$exist_table->getColumn('student_picture'))
                $this->addColumn('students', 'student_picture', $this->string(50));
             else{

                $this->alterColumn('students', 'student_picture', 'VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci  ');

                }
            if (!$exist_table->getColumn('student_legal_age'))
                $this->addColumn('students', 'student_legal_age', $this->tinyInteger(3));
             else{
                $this->alterColumn('students', 'student_legal_age', $this->tinyInteger(3));
                }
            if (!$exist_table->getColumn('student_tutor_first_name'))
                $this->addColumn('students', 'student_tutor_first_name', $this->string(50)->notNull());
             else{

                $this->alterColumn('students', 'student_tutor_first_name', 'VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL ');

                }
            if (!$exist_table->getColumn('student_tutor_last_name'))
                $this->addColumn('students', 'student_tutor_last_name', $this->string(50));
             else{

                $this->alterColumn('students', 'student_tutor_last_name', 'VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci  ');

                }
            if (!$exist_table->getColumn('studen_tutor_email'))
                $this->addColumn('students', 'studen_tutor_email', $this->string(50));
             else{

                $this->alterColumn('students', 'studen_tutor_email', 'VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci  ');

                }
            if (!$exist_table->getColumn('school_id'))
                $this->addColumn('students', 'school_id', $this->integer(10)->notNull());

            }
        /*Generating index*/

        /*Generating foreignkey*/

        if ($exist_table === null || !array_key_exists('students_fk3',$exist_table->foreignKeys) || !array_key_exists('school_id',$exist_table->foreignKeys['students_fk3'])) 
            $this->addForeignKey(
                'students_fk3',
                'students',
                'school_id',
                'schools',
                'id_school',
                'CASCADE',
                'CASCADE'
            );
           else {
            $this->dropForeignKey('students_fk3','students' );
            $this->addForeignKey(
                'students_fk3',
                'students',
                'school_id',
                'schools',
                'id_school',
                'CASCADE',
                'CASCADE'
            );
           }
        if ($exist_table === null || !array_key_exists('students_fk4',$exist_table->foreignKeys) || !array_key_exists('user_id',$exist_table->foreignKeys['students_fk4'])) 
            $this->addForeignKey(
                'students_fk4',
                'students',
                'user_id',
                'users',
                'id_user',
                'CASCADE',
                'CASCADE'
            );
           else {
            $this->dropForeignKey('students_fk4','students' );
            $this->addForeignKey(
                'students_fk4',
                'students',
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
        echo 'M210225_22939_Students cannot be reverted.';


        return false;
    }
    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo M210225_22939_Students cannot be reverted.


        return false;
    }
    */
}
