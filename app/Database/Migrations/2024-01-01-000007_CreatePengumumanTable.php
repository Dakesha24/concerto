<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePengumumanTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'pengumuman_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'judul' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
                'null'       => false,
            ],
            'isi_pengumuman' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'tanggal_publish' => [
                'type'    => 'DATETIME',
                'null'    => true,
                'default' => 'CURRENT_TIMESTAMP',
            ],
            'tanggal_berakhir' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'created_by' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,
            ],
        ]);

        $this->forge->addKey('pengumuman_id', true);
        $this->forge->addKey('created_by');
        $this->forge->addForeignKey('created_by', 'users', 'user_id', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('pengumuman', true, [
            'ENGINE'  => 'InnoDB',
            'CHARSET' => 'utf8mb4',
            'COLLATE' => 'utf8mb4_general_ci',
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('pengumuman', true);
    }
}
