<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStudentsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'student_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'unique'     => true,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'unique'     => true,
            ],
            'phone' => [
                'type'       => 'VARCHAR',
                'constraint' => 15,
                'null'      => true,
            ],
            'branch' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'      => true,
            ],
            'faculty' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'      => true,
            ],
            'created_at' => [
                'type'    => 'TIMESTAMP',
                'null'    => true,
            ],
            'updated_at' => [
                'type'    => 'TIMESTAMP',
                'null'    => true,
            ],
        ]);
        
        $this->forge->addKey('id', true);
        $this->forge->createTable('students', true);  // true means it will drop the table first if it exists
    }

    public function down()
    {
        $this->forge->dropTable('students');
    }
}