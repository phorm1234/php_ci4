<?php

namespace App\Controllers;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\ReportvModel;
class Home extends BaseController
{
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->mastertbt_customer = $this->db->table('mastertbt_customer');
    }

    public function index(): string
    {
        $this->mastertbt_customer->select('*');
        $this->mastertbt_customer->where("is_use",1);
        $result = $this->mastertbt_customer->get()->getResult();

        $data['result_cust']=$result;
        // print_r($result);

        // $model = new ReportvModel();
        // $model->selectQuery();



        return view('welcome_message',$data);
    }



    public function test(): string 
    {
        return view('test');
    }








}
