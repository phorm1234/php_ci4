<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateReportvDataTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'tbt_com_name'=>[
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'customer_code'=>[
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'customer_name'=>[
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'customer_name'=>[
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'ven_product_code'=>[
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'tbt_product_group'=>[
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'ven_eng_desc'=>[
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'exp_name'=>[
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'exp_entry'=>[
                'type'=>'VARCHAR',
                'constraint'=>'255'
            ],
            'exp_date'=>[
                'type'=>'DATE',
            ],
            'exp_declare_line'=>[
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'quantity'=>[
                'type'=>'float',
            ],
            'uop'=>[
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'tbt_product_code'=>[
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'summary_json'=>[
                'type'=>'text',
            ],
            'create_by'=>[
                'type'=>'VARCHAR',
                'constraint'=>'50'
            ],
            'modify_by'=>[
                'type'=>'VARCHAR',
                'constraint'=>'50',
            ],
            'create_date timestamp default current_timestamp',
            'modify_date timestamp default current_timestamp on update current_timestamp'
        ]);
        // $this->forge->addPrimaryKey('customer_code','pk_actions');
        $this->forge->createTable('reportv_data');
    }

    public function down()
    {
        $this->forge->dropTable('reportv_data');
    }
}
