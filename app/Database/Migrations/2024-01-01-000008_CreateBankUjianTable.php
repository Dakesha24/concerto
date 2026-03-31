<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBankUjianTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'bank_ujian_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'kategori' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => false,
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
            'deskripsi' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_by' => [
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

        $this->forge->addKey('bank_ujian_id', true);
        $this->forge->addUniqueKey(['kategori', 'jenis_ujian_id', 'nama_ujian', 'created_by'], 'unique_bank_ujian');
        $this->forge->addKey('jenis_ujian_id');
        $this->forge->addKey('created_by');
        $this->forge->addForeignKey('jenis_ujian_id', 'jenis_ujian', 'jenis_ujian_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('created_by', 'users', 'user_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('bank_ujian', true, [
            'ENGINE'  => 'InnoDB',
            'CHARSET' => 'utf8mb4',
            'COLLATE' => 'utf8mb4_general_ci',
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('bank_ujian', true);
    }
}
