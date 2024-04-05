<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMastertbtProductTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'product_code'=>[
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'product_group'=>[
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'product_name'=>[
                'type'=>'VARCHAR',
                'constraint'=>'255'
            ],
            'is_use'=>[
                'type'=>'TINYINT',
                'constraint'=>'3',
            ],
            'user_create'=>[
                'type'=>'VARCHAR',
                'constraint'=>'50'
            ],
            'user_modify'=>[
                'type'=>'VARCHAR',
                'constraint'=>'50',
                'null'=>true,
            ],
            'created_date timestamp default current_timestamp',
            'modify_date timestamp default current_timestamp on update current_timestamp'
        ]);
        $this->forge->addPrimaryKey('product_code','pk_actions');
        $this->forge->createTable('mastertbt_product');
    }

    public function down()
    {
        $this->forge->dropTable('mastertbt_product');
    }
}
