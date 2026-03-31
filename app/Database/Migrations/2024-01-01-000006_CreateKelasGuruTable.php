<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKelasGuruTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'kelas_guru_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'kelas_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,
            ],
            'guru_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,
            ],
            'created_at' => [
                'type'    => 'TIMESTAMP',
                'null'    => false,
                'default' => 'CURRENT_TIMESTAMP',
            ],
            'updated_at' => [
                'type'    => 'TIMESTAMP',
                'null'    => false,
                'default' => 'CURRENT_TIMESTAMP',
            ],
        ]);

        $this->forge->addKey('kelas_guru_id', true);
        $this->forge->addKey('guru_id');
        $this->forge->addKey('kelas_id');
        $this->forge->addForeignKey('guru_id', 'guru', 'guru_id', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('kelas_id', 'kelas', 'kelas_id', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('kelas_guru', true, [
            'ENGINE'  => 'InnoDB',
            'CHARSET' => 'utf8mb4',
            'COLLATE' => 'utf8mb4_general_ci',
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('kelas_guru', true);
    }
}
