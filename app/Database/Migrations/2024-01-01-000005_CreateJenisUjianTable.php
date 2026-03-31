<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateJenisUjianTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'jenis_ujian_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'nama_jenis' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => false,
            ],
            'deskripsi' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'kelas_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
            ],
            'created_by' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
            ],
            'created_at' => [
                'type'    => 'DATETIME',
                'null'    => false,
                'default' => 'CURRENT_TIMESTAMP',
            ],
            'updated_at' => [
                'type'    => 'DATETIME',
                'null'    => false,
                'default' => 'CURRENT_TIMESTAMP',
            ],
        ]);

        $this->forge->addKey('jenis_ujian_id', true);
        $this->forge->addKey('kelas_id');
        $this->forge->addKey('created_by');
        $this->forge->addForeignKey('kelas_id', 'kelas', 'kelas_id', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('created_by', 'users', 'user_id', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('jenis_ujian', true, [
            'ENGINE'  => 'InnoDB',
            'CHARSET' => 'utf8mb4',
            'COLLATE' => 'utf8mb4_general_ci',
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('jenis_ujian', true);
    }
}
