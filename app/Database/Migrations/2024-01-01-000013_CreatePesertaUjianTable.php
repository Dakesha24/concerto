<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePesertaUjianTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'peserta_ujian_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'jadwal_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,
            ],
            'siswa_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['belum_mulai', 'sedang_mengerjakan', 'selesai'],
                'null'       => true,
                'default'    => 'belum_mulai',
            ],
            'waktu_mulai' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'waktu_selesai' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('peserta_ujian_id', true);
        $this->forge->addKey('jadwal_id');
        $this->forge->addKey('siswa_id');
        $this->forge->addForeignKey('jadwal_id', 'jadwal_ujian', 'jadwal_id', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('siswa_id', 'siswa', 'siswa_id', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('peserta_ujian', true, [
            'ENGINE'  => 'InnoDB',
            'CHARSET' => 'utf8mb4',
            'COLLATE' => 'utf8mb4_general_ci',
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('peserta_ujian', true);
    }
}
