<?php

namespace App\Models;

use CodeIgniter\Model;

class Master extends Model
{

    protected $table = 'mastertbt_product'; // Specify the table name


    public function table_product($start, $length, $orderBy, $orderDir, $searchValue) {
        // Select specific columns from the 'mastertbt_product' table
        $this->select('product_code, product_group, product_name, create_by, DATE_FORMAT(created_date, "%d/%m/%Y") AS created_date');

        // $test_value = 'Start '.$start.'length '.$length.'orderBy '.$orderBy.'orderDir '.$orderDir.'searchValue '.$searchValue;
    
        // Apply search filter
        if (!empty($searchValue)) {
            $this->like('product_code', $searchValue);
            $this->orLike('product_group', $searchValue);
            $this->orLike('product_name', $searchValue);
            $this->orLike('create_by', $searchValue);
            $this->orLike('created_date', $searchValue);
        }
        // var_dump('<pre>',$test_value);
        // die;
        // Apply sorting
        $this->where('is_use',1);
        $this->orderBy($orderBy, $orderDir);
    
        // Limit results for pagination
        $this->limit($length, $start);
       
        // Get the results from the table
        $query = $this->get();
      
        // Return the result set as an array of objects
        return $query->getResult();
    }
    
    public function countFiltered($searchValue) {
        // Apply search filter
        if (!empty($searchValue)) {
            $this->like('product_code', $searchValue);
            $this->orLike('product_group', $searchValue);
            $this->orLike('product_name', $searchValue);
            $this->orLike('create_by', $searchValue);
            $this->orLike('created_date', $searchValue);
        }
    
        // Count the filtered records
        return $this->countAllResults();
    }


    public function get_productbyid($product_id) {


        // var_dump('<pre>',$product_id);
        // die;


        $this->select('product_code, product_group, product_name');

        $this->where('product_code',$product_id);

        $query = $this->get();

     

        return $query->getResult();
    }

    public function insert_product($product_code,$product_group,$product_name) {
        // Get the user_id from session
        $username = session()->get('userdata')['username'];

        // var_dump('<pre>',$user_id);
        // die;
        $data = [
            'product_code' => $product_code,
            'product_group' => $product_group,
            'product_name' => $product_name,
            'create_by' => $username,
            'is_use' => 1
        ];
        return $this->db->table('mastertbt_product')->insert($data);
    }

    public function update_product($product_code,$product_group,$product_name) {
             // Get the user_id from session
             $username = session()->get('userdata')['username'];

             // var_dump('<pre>',$user_id);
             // die;
             $data = [
                 'product_code' => $product_code,
                 'product_group' => $product_group,
                 'product_name' => $product_name,
                 'modify_by' => $username,
                 'is_use' => 1
             ];
            //  return $this->db->table('mastertbt_product')->update($data);
             // Perform the update based on product_code
          return $this->db->table('mastertbt_product')->where('product_code', $product_code)->update($data);
    }
    // Function to check if a product code already exists
    public function checkCodeExists($code,$type) // Status 0=Product Already exits ,1=Success,2=fail
    {
        //  $masterModel = new Master();
        $table = '';
        $column = '';
        if ($type == 1) {
            // Check master_product table
            $table = 'mastertbt_product';
            $column = 'product_code';
        } elseif ($type == 2) {
            // Check master_customer table
            $table = 'mastertbt_customer';
            $column = 'customer_code';
        } else {
            return false; // Invalid type
        }
    
        // Construct the query to check the specified table
        $query = $this->db->table($table)->where($column, $code)->get();
        
        // Fetch the result
        $existingRecord = $query->getRow();
    
        return $existingRecord !== null;
    }


    
    // public function delete_product($product_code) {
    //     // Get the user_id from session
    //     $username = session()->get('userdata')['username'];

    //     // var_dump('<pre>',$user_id);
    //     // die;
    //     $data = [
    //         'product_code' => $product_code,
    //         'product_group' => $product_group,
    //         'product_name' => $product_name,
    //         'modify_by' => $username,
    //         'is_use' => 1
    //     ];
    //    //  return $this->db->table('mastertbt_product')->update($data);
    //     // Perform the update based on product_code
    //  return $this->db->table('mastertbt_product')->where('product_code', $product_code)->update($data);
    // }

    public function another_table_function() {
        $this->table = 'another_table'; // Change the table name for this function
        
        // Your query logic for the 'another_table'
    }

    public function insert_customer($customer_code,$name_ic,$name_tbt) {
        // Get the user_id from session
        $username = session()->get('userdata')['username'];

        // var_dump('<pre>',$user_id);
        // die;
        $data = [
            'customer_code' => $customer_code,
            'name_ic' => $name_ic,
            'name_tbt' => $name_tbt,
            'create_by' => $username,
            'is_use' => 1
        ];
        return $this->db->table('mastertbt_customer')->insert($data);
    }


    public function table_customer($start, $length, $orderBy, $orderDir, $searchValue) {
        $this->table = 'mastertbt_customer';
        // Select specific columns from the 'mastertbt_product' table
        $this->select('customer_code, name_ic, name_tbt, create_by, DATE_FORMAT(created_date, "%d/%m/%Y") AS created_date');

        // $test_value = 'Start '.$start.'length '.$length.'orderBy '.$orderBy.'orderDir '.$orderDir.'searchValue '.$searchValue;
    
        // Apply search filter
        if (!empty($searchValue)) {
            $this->like('customer_code', $searchValue);
            $this->orLike('name_ic', $searchValue);
            $this->orLike('name_tbt', $searchValue);
            $this->orLike('create_by', $searchValue);
            $this->orLike('created_date', $searchValue);
        }
        // var_dump('<pre>',$test_value);
        // die;
        // Apply sorting
        $this->where('is_use',1);
        $this->orderBy($orderBy, $orderDir);
    
        // Limit results for pagination
        $this->limit($length, $start);
       
        // Get the results from the table
        $query = $this->get();
      
        // Return the result set as an array of objects
        return $query->getResult();
    }
    
    public function countFilteredCust($searchValue) {
        // Apply search filter
        if (!empty($searchValue)) {
            $this->like('customer_code', $searchValue);
            $this->orLike('name_ic', $searchValue);
            $this->orLike('name_tbt', $searchValue);
            $this->orLike('create_by', $searchValue);
            $this->orLike('created_date', $searchValue);
        }
    
        // Count the filtered records
        return $this->countAllResults();
    }



}
