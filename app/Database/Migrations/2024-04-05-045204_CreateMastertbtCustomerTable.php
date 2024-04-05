<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMastertbtCustomerTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'customer_code'=>[
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'name_ic'=>[
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'name_tbt'=>[
                'type'=>'VARCHAR',
                'constraint'=>'255'
            ],
            'is_use'=>[
                'type'=>'TINYINT',
                'constraint'=>'3',
            ],
            'create_by'=>[
                'type'=>'VARCHAR',
                'constraint'=>'50'
            ],
            'modify_by'=>[
                'type'=>'VARCHAR',
                'constraint'=>'50',
            ],
            'created_date timestamp default current_timestamp',
            'modify_date timestamp default current_timestamp on update current_timestamp'
        ]);
        $this->forge->addPrimaryKey('customer_code','pk_actions');
        $this->forge->createTable('mastertbt_customer');
    }

    public function down()
    {
        $this->forge->dropTable('mastertbt_customer');
    }
}
