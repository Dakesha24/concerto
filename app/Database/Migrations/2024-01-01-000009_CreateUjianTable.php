<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUjianTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_ujian' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'jenis_ujian_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,
            ],
            'nama_ujian' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => false,
            ],
            'kode_ujian' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'deskripsi' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'se_awal' => [
                'type'       => 'DECIMAL',
                'constraint' => '6,4',
                'null'       => false,
                'default'    => '1.0000',
            ],
            'se_minimum' => [
                'type'       => 'DECIMAL',
                'constraint' => '6,4',
                'null'       => false,
                'default'    => '0.2500',
            ],
            'delta_se_minimum' => [
                'type'       => 'DECIMAL',
                'constraint' => '6,4',
                'null'       => false,
                'default'    => '0.0100',
            ],
            'maksimal_soal_tampil' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
                'default'    => 20,
            ],
            'durasi' => [
                'type' => 'TIME',
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

        $this->forge->addKey('id_ujian', true);
        $this->forge->addKey('jenis_ujian_id');
        $this->forge->addKey('kelas_id');
        $this->forge->addKey('created_by');
        $this->forge->addForeignKey('jenis_ujian_id', 'jenis_ujian', 'jenis_ujian_id', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('kelas_id', 'kelas', 'kelas_id', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('created_by', 'users', 'user_id', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('ujian', true, [
            'ENGINE'  => 'InnoDB',
            'CHARSET' => 'utf8mb4',
            'COLLATE' => 'utf8mb4_general_ci',
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('ujian', true);
    }
}
