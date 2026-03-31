<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSoalUjianTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'soal_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'kode_soal' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'ujian_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
            ],
            'bank_ujian_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
            ],
            'pertanyaan' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'pilihan_a' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'pilihan_b' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'pilihan_c' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'pilihan_d' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'pilihan_e' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'pembahasan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'foto' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'jawaban_benar' => [
                'type'       => 'ENUM',
                'constraint' => ['A', 'B', 'C', 'D', 'E'],
                'null'       => false,
            ],
            // parameter b (IRT) - tingkat kesulitan soal
            'tingkat_kesulitan' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,3',
                'null'       => false,
                'default'    => '0.000',
            ],
            'is_bank_soal' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => true,
                'default'    => 0,
            ],
            'created_by' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
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

        $this->forge->addKey('soal_id', true);
        $this->forge->addKey('ujian_id');
        $this->forge->addKey('bank_ujian_id');
        $this->forge->addForeignKey('ujian_id', 'ujian', 'id_ujian', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('bank_ujian_id', 'bank_ujian', 'bank_ujian_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('soal_ujian', true, [
            'ENGINE'  => 'InnoDB',
            'CHARSET' => 'utf8mb4',
            'COLLATE' => 'utf8mb4_general_ci',
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('soal_ujian', true);
    }
}
