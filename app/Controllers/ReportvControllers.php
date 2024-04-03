<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Libraries\CIAuth;
use App\Libraries\Hash;
use App\Models\User;


class ReportvControllers extends BaseController
{
    protected $helper = ['url','form'];

    public function gen_reportv()
    {

        var_dump('<pre>',$_POST);
        die;
        // $data =[
        //     'pageTitle'=>'Login',
        //     'validation'=>null
        // ];
        // return view('backend/pages/auth/login',$data);
    }


   

  
}
