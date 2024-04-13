<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Master;


class MasterController extends BaseController
{
    // public function index(): string
    // {
    //     return view('welcome_message');
    // }
    protected $helper = ['url','form'];

    
    // view product
    public function masterproduct()
    {
        $data = [
            'pageTitle'=>'Master Product',
        ];



        return view('backend/pages/master/master_product',$data);
    }

    public function get_table_masterproduct() {
        // Get parameters sent by DataTables
        $request = $this->request;
    
     
        // Get draw counter
        $draw = $request->getPost('draw');
    
        // Get start position of records for the current page
        $start = $request->getPost('start');
    
        // Get number of records to fetch
        $length = $request->getPost('length');
    
        // Get order criteria
        $order = $request->getPost('order');
        // $orderBy = $order[0]['column'];
        $orderBy = 'product_code';
        $orderDir = $order[0]['dir'];
    
        // Get search value
        $searchValue = $request->getPost('search')['value'];
  
        // Load the Master model
        $masterModel = new Master();
        // $product_data = [];
        // Call the method to fetch paginated and sorted data
        $product_data = $masterModel->table_product($start, $length, $orderBy, $orderDir, $searchValue);
        // var_dump('<pre>',$product_data);
        // die;
        // Get total number of records in the database
        $totalRecords = $masterModel->countAll();
    
        // Get total number of filtered records
        $filteredRecords = $masterModel->countFiltered($searchValue);
    
        // Prepare response data
        $response = [
            "draw" => intval($draw),
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $filteredRecords,
            "data" => $product_data
        ];
    
        // Return JSON response
        // return $this->response->setJSON(['data' => $response]);
        return $this->response->setJSON($response);
    }
    // Controller method to handle the route
    public function get_product() {
        // Get the product_id from the query string
        $product_id = $this->request->getPost('product_id');
   
        // Load the Master model
        $masterModel = new Master();

        // Get product data by ID
        $productbyid_data = $masterModel->get_productbyid($product_id);

        // Prepare response data
        return $this->response->setJSON($productbyid_data);
    }

    // Method to handle inserting a new product
    public function insert_product()
    {
            // Get the data sent via POST request
            $product_code = $this->request->getPost('product_code');
            $product_group = $this->request->getPost('product_group');
            $product_name = $this->request->getPost('product_name');

            // Create an instance of the Master model
            $masterModel = new Master();

            //Check if the product code already exists
            if ($masterModel->checkCodeExists($product_code,1)) {
                // Product code already exists, return error response
                return $this->response->setJSON(['status_message'=>0,'message' => 'Product code already exists.']);
            } else {
                // Insert the new product into the database using the model method
                $result = $masterModel->insert_product($product_code, $product_group, $product_name);

                // Check if the insertion was successful
                if ($result) {
                    // Return a success response
                    return $this->response->setJSON(['status_message'=>1,'message' => 'Product inserted successfully']);
                } else {
                    // Return an error response
                    return $this->response->setJSON(['status_message'=>2,'message' => 'Failed to insert product']);
                }
            }           
    }
    

    // Method to handle updating an existing product
    public function update_product()
    {
        // Get the data sent via POST request
        // $product_id = $this->request->getPost('product_id');
        $product_code = $this->request->getPost('product_code');
        $product_group = $this->request->getPost('product_group');
        $product_name = $this->request->getPost('product_name');

        // Create an instance of the ProductModel
        $masterModel = new Master();
        

        $result = $masterModel->update_product($product_code, $product_group, $product_name);

        // Check if the insertion was successful
        if ($result) {
            // Return a success response
            return $this->response->setJSON(['message' => 'Product updated successfully']);
        } else {
            // Return an error response
            return $this->response->setJSON(['message' => 'Failed to updated product']);
        }


    }

 
    

    // Method to handle deleting a product
    public function delete_product()
    {
        // Get the product code sent via POST request
        $product_code = $this->request->getPost('product_code');

        // Create an instance of the Master model
        $masterModel = new Master();

        // Check if the product exists
        $existingProduct = $masterModel->where('product_code', $product_code)->first();

        // If the product doesn't exist, return error response
        if (!$existingProduct) {
            return $this->response->setJSON(['error' => 'Product not found.']);
        }

        // Perform soft delete by setting is_use to 0
        $masterModel->where('product_code', $product_code)->update(['is_use' => 0]);

        // Return success response
        return $this->response->setJSON(['message' => 'Product deleted successfully.']);
    }


    public function mastercustomer()
    {
        $data = [
            'pageTitle'=>'Master Customer',
        ];



        return view('backend/pages/master/master_customer',$data);
    }


    public function get_table_mastercustomer() {
        // Get parameters sent by DataTables
        $request = $this->request;
    
     

        // Get draw counter
        $draw = $request->getPost('draw');
    
        // Get start position of records for the current page
        $start = $request->getPost('start');
    
        // Get number of records to fetch
        $length = $request->getPost('length');
    
        // Get order criteria
        $order = $request->getPost('order');
        // $orderBy = $order[0]['column'];
        $orderBy = 'customer_code';
        $orderDir = $order[0]['dir'];
    
        // Get search value
        $searchValue = $request->getPost('search')['value'];
  
        // Load the Master model
        $masterModel = new Master();
        // $product_data = [];
        // Call the method to fetch paginated and sorted data
        $customer_data = $masterModel->table_customer($start, $length, $orderBy, $orderDir, $searchValue);
        // var_dump('<pre>',$product_data);
        // die;
        // Get total number of records in the database
        $totalRecords = $masterModel->countAll();
    
        // Get total number of filtered records
        $filteredRecords = $masterModel->countFilteredCust($searchValue);
    
        // Prepare response data
        $response = [
            "draw" => intval($draw),
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $filteredRecords,
            "data" => $customer_data
        ];
    
        // Return JSON response
        // return $this->response->setJSON(['data' => $response]);
        return $this->response->setJSON($response);
    }


    // Method to handle inserting a new product
    public function insert_customer()
    {
            // Get the data sent via POST request
            $customer_code = $this->request->getPost('customer_code');
            $name_ic = $this->request->getPost('name_ic');
            $name_tbt = $this->request->getPost('name_tbt');

            // Create an instance of the Master model
            $masterModel = new Master();
    
   
            //Check if the product code already exists
            if ($masterModel->checkCodeExists($customer_code,2)) {
                // Product code already exists, return error response
                return $this->response->setJSON(['status_message'=>0,'message' => 'Customer code already exists.']);
            } else {
                // Insert the new product into the database using the model method
                $result = $masterModel->insert_customer($customer_code, $name_ic, $name_tbt);

                // Check if the insertion was successful
                if ($result) {
                    // Return a success response
                    return $this->response->setJSON(['status_message'=>1,'message' => 'Customer inserted successfully']);
                } else {
                    // Return an error response
                    return $this->response->setJSON(['status_message'=>2,'message' => 'Failed to insert Customer']);
                }
            }           
    }

}
