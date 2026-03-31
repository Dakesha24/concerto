<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKelasTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'kelas_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'sekolah_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,
            ],
            'nama_kelas' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => false,
            ],
            'tahun_ajaran' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
                'null'       => false,
            ],
        ]);

        $this->forge->addKey('kelas_id', true);
        $this->forge->addKey('sekolah_id');
        $this->forge->addForeignKey('sekolah_id', 'sekolah', 'sekolah_id', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('kelas', true, [
            'ENGINE'  => 'InnoDB',
            'CHARSET' => 'utf8mb4',
            'COLLATE' => 'utf8mb4_general_ci',
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('kelas', true);
    }
}
