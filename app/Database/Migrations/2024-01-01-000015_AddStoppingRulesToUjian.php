<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStoppingRulesToUjian extends Migration
{
    public function up()
    {
        $this->forge->addColumn('ujian', [
            'use_waktu' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => false,
                'default'    => 1,
                'after'      => 'delta_se_minimum',
            ],
            'use_se_min' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => false,
                'default'    => 1,
                'after'      => 'use_waktu',
            ],
            'use_delta_se' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => false,
                'default'    => 1,
                'after'      => 'use_se_min',
            ],
            'use_max_soal' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => false,
                'default'    => 0,
                'after'      => 'use_delta_se',
            ],
            'tampilkan_pembahasan' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => false,
                'default'    => 0,
                'after'      => 'use_max_soal',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('ujian', ['use_waktu', 'use_se_min', 'use_delta_se', 'use_max_soal', 'tampilkan_pembahasan']);
    }
}
