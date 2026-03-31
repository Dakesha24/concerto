<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateHasilUjianTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'jawaban_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'peserta_ujian_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,
            ],
            'soal_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,
            ],
            'jawaban_siswa' => [
                'type'       => 'ENUM',
                'constraint' => ['A', 'B', 'C', 'D', 'E'],
                'null'       => false,
            ],
            'is_correct' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => true,
            ],
            'waktu_menjawab' => [
                'type'    => 'TIMESTAMP',
                'null'    => false,
                'default' => 'CURRENT_TIMESTAMP',
            ],
            // Nilai estimasi kemampuan siswa (theta) dalam IRT/CAT
            'theta_saat_ini' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,3',
                'null'       => true,
            ],
            // Standard Error estimasi theta
            'se_saat_ini' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,3',
                'null'       => true,
            ],
            // Perubahan SE dari soal sebelumnya (kriteria berhenti)
            'delta_se_saat_ini' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,3',
                'null'       => false,
            ],
            // Probabilitas menjawab benar (P(theta))
            'pi_saat_ini' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,3',
                'null'       => true,
            ],
            // Probabilitas menjawab salah Q = 1 - P
            'qi_saat_ini' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,3',
                'null'       => true,
            ],
            // Fisher Information soal ke-i
            'ii_saat_ini' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,3',
                'null'       => true,
            ],
        ]);

        $this->forge->addKey('jawaban_id', true);
        $this->forge->addKey('peserta_ujian_id');
        $this->forge->addKey('soal_id');
        $this->forge->addForeignKey('peserta_ujian_id', 'peserta_ujian', 'peserta_ujian_id', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('soal_id', 'soal_ujian', 'soal_id', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('hasil_ujian', true, [
            'ENGINE'  => 'InnoDB',
            'CHARSET' => 'utf8mb4',
            'COLLATE' => 'utf8mb4_general_ci',
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('hasil_ujian', true);
    }
}
