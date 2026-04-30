<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FixStoppingRuleDefaults extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('ujian', [
            'use_waktu' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => false,
                'default'    => 0,
            ],
            'use_se_min' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => false,
                'default'    => 0,
            ],
            'use_delta_se' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => false,
                'default'    => 0,
            ],
            'use_max_soal' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => false,
                'default'    => 0,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->modifyColumn('ujian', [
            'use_waktu'    => ['type' => 'TINYINT', 'constraint' => 1, 'null' => false, 'default' => 1],
            'use_se_min'   => ['type' => 'TINYINT', 'constraint' => 1, 'null' => false, 'default' => 1],
            'use_delta_se' => ['type' => 'TINYINT', 'constraint' => 1, 'null' => false, 'default' => 1],
            'use_max_soal' => ['type' => 'TINYINT', 'constraint' => 1, 'null' => false, 'default' => 0],
        ]);
    }
}
