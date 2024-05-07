<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateNgFromSaleTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
    
            'runno'=>[
                'type' => 'int',
                'constraint' => '11',
            ],
            'ng_year'=>[
                'type'=>'VARCHAR',
                'constraint'=>'50'
            ],
            'ng_month'=>[
                'type'=>'VARCHAR',
                'constraint'=>'50'
            ],
            'ng_day'=>[
                'type'=>'VARCHAR',
                'constraint'=>'50'
            ],
            'customer_code'=>[
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'ng_part'=>[
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'ng_quantity'=>[
                'type' => 'float'
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
        $this->forge->addPrimaryKey('runno','pk_actions');
        $this->forge->createTable('ng_from_sale');
    }

    public function down()
    {
        $this->forge->dropTable('ng_from_sale');
    }
}
