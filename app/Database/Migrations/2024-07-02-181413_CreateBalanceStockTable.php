<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBalanceStockTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'balance_id'=>[
                'type' => 'int',
                'constraint' => '111'
            ],
            'customer_code'=>[
                'type' => 'VARCHAR',
                'constraint' => '100'
            ],
            'ven_product_code'=>[
                'type'=>'VARCHAR',
                'constraint'=>'255'
            ],
            'tbt_group'=>[
                'type'=>'VARCHAR',
                'constraint'=>'255'
            ],
            'balance_stock_year'=>[
                'type'=>'VARCHAR',
                'constraint'=>'50'
            ],
            'balance_stock_quantity'=>[
                'type'=>'float',
            ],
            'create_date'=>[
                'type'=>'DATE'
            ],
            'create_by'=>[
                'type'=>'VARCHAR',
                'constraint'=>'255'
            ],
            'create_date timestamp default current_timestamp',
        ]);
        $this->forge->addPrimaryKey('id','pk_actions');
        $this->forge->createTable('balance_stock');
    }

    public function down()
    {
        $this->forge->dropTable('balance_stock');
    }
}