<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateGuruTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'guru_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,
            ],
            'sekolah_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,
            ],
            'nip' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => false,
            ],
            'nama_lengkap' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => false,
            ],
            'mata_pelajaran' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => false,
            ],
        ]);

        $this->forge->addKey('guru_id', true);
        $this->forge->addKey('user_id');
        $this->forge->addKey('sekolah_id');
        $this->forge->addForeignKey('user_id', 'users', 'user_id', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('sekolah_id', 'sekolah', 'sekolah_id', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('guru', true, [
            'ENGINE'  => 'InnoDB',
            'CHARSET' => 'utf8mb4',
            'COLLATE' => 'utf8mb4_general_ci',
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('guru', true);
    }
}
