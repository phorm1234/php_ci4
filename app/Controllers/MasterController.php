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


        $masterModel = new Master();

       
        $data['products'] = $masterModel->table_product();
        

        var_dump('<pre>',$data['products']);
        die;
        
        return $this->response->setJSON($data);
    }

    public function mastercustomer()
    {
        $data = [
            'pageTitle'=>'Master Customer',
        ];



        return view('backend/pages/master/master_customer',$data);
    }



}
