<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLogDataTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'log_id'=>[
                'type' => 'int',
                'constraint' => '111'
            ],
            'log_type'=>[
                'type' => 'VARCHAR',
                'constraint' => '50'
            ],
            'log_data_from'=>[
                'type'=>'VARCHAR',
                'constraint'=>'255'
            ],
            'log_data_to'=>[
                'type'=>'VARCHAR',
                'constraint'=>'255'
            ],
            'log_date'=>[
                'type'=>'DATE'
            ],
            'is_use'=>[
                'type'=>'TINYINT',
                'constraint'=>'3'
            ],
            'create_by'=>[
                'type'=>'VARCHAR',
                'constraint'=>'255'
            ],
            'log_date timestamp default current_timestamp',
        ]);
        $this->forge->addPrimaryKey('log_id','pk_actions');
        $this->forge->createTable('log_data');
    }

    public function down()
    {
        $this->forge->dropTable('log_data');
    }
}
