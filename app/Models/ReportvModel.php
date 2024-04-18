<?php

namespace App\Models;

use CodeIgniter\Model;

class ReportvModel extends Model
{


   public function test()
   {
        $builder = $this->db->table('mastertbt_customer');
        $builder->select("*");
        $builder->where("is_use",1);
        $result = $builder->get();
       
        echo $this->db->getLastQuery();

       return $result->getResult();
   }



}
