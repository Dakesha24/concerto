<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateJadwalUjianTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'jadwal_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'ujian_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,
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
            'tanggal_mulai' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'tanggal_selesai' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'durasi_menit' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,
            ],
            'kode_akses' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => false,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['belum_mulai', 'sedang_berlangsung', 'selesai'],
                'null'       => false,
                'default'    => 'belum_mulai',
            ],
        ]);

        $this->forge->addKey('jadwal_id', true);
        $this->forge->addKey('kelas_id');
        $this->forge->addKey('guru_id');
        $this->forge->addKey('ujian_id');
        $this->forge->addForeignKey('kelas_id', 'kelas', 'kelas_id', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('guru_id', 'guru', 'guru_id', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('ujian_id', 'ujian', 'id_ujian', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('jadwal_ujian', true, [
            'ENGINE'  => 'InnoDB',
            'CHARSET' => 'utf8mb4',
            'COLLATE' => 'utf8mb4_general_ci',
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('jadwal_ujian', true);
    }
}
