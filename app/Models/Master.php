<?php

namespace App\Models;

use CodeIgniter\Model;

class Master extends Model
{

    public function table_product() {

        $db_product = \Config\Database::connect('default');
         // Select specific columns from the 'mastertbt_product' table
        // $this->db->select('product_code, product_group, product_name, create_by');
        $sql = 'SELECT * FROM mastertbt_product';
        $db_product->query($sql);
        // Get the results from the table
        // $query = $this->db->get('mastertbt_product');

        // Check if there are any results
        if ($query->num_rows() > 0) {
            // Return the result set as an array of objects
            return $query->result();
        } else {
            // If no results found, return an empty array
            return [];
        }
    }



}
