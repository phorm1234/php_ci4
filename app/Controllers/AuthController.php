<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Libraries\CIAuth;
use App\Libraries\Hash;
use App\Models\User;

class AuthController extends BaseController
{
    protected $helper = ['url','form'];

    public function loginForm()
    {
        $data =[
            'pageTitle'=>'Login',
            'validation'=>null
        ];
        return view('backend/pages/auth/login',$data);
    }


     public function loginHandler() {
        $fieldType = filter_var($this->request->getVar('login_id'), FILTER_VALIDATE_EMAIL) ? 'email' :
        'username'; // Check email or username

        // echo $fieldType;

        // $request = \Config\Services::request();
        if ( $fieldType=='email') {
            $isValid = $this->validate([
                    'login_id'=>[
                        'rules'=>'required|valid_email|is_not_unique[users.email]',
                        'errors'=>[
                            'required'=>'Email is required',
                            'valid_email'=>'Plase, check the email field. It does not appears to be valid.',
                            'is_not_unique'=>'Email is not exists in out system.'
                        ]
                    ],
                    'password'=>[
                        'rules'=>'required|min_length[5]|max_length[45]',
                        'errors'=>[
                            'required'=>'Password is required',
                            'min_length'=>'Password must have atleast 5 characters in length.',
                            'max_length'=>'Password must not have characters more than 45 in length.'
                        ]
                    ]    
                ]);
        } else {
            $isValid = $this->validate([
                'login_id'=>[
                    'rules'=>'required|is_not_unique[users.username]',
                    'errors'=>[
                        'required'=>'Username is required',
                        'is_not_unique'=>'Username is not exists in out system.'
                    ]
                ],
                'password'=>[
                    'rules'=>'required|min_length[5]|max_length[45]',
                    'errors'=>[
                        'required'=>'Password is required',
                        'min_length'=>'Password must have atleast 5 characters in length.',
                        'max_length'=>'Password must not have characters more than 45 in length.'
                    ]
                ]    
            ]);

        }


        if ( !$isValid) {
            return view('backend/pages/auth/login',[
                'pageTitle'=>'Login',
                'validation'=>$this->validator
            ]);
        } else {

            // echo 'Form validated';
            $user = new User;

            $login_id = $this->request->getVar('login_id'); // var login_id

            $userInfo = $user->whereIn($fieldType,$login_id)->first(); //s
            // echo $user;
            // $login_id = $_POST['login_id'];
            // $pass = $_POST['password'];


        
            try {
                $user = new User();
                $userInfo = $user->where($fieldType, $login_id)->first();
            
                if ($userInfo) {
                    // User found, proceed with further actions
                    echo 'Found';
                } else {
                    echo 'User not found.';
                }
            } catch (\Exception $e) {
                echo 'Error: ' . $e->getMessage();
            }


            
            // $userInfo = $user->where($fieldType,$this->request->getVar('login_id'))->first();
        

            // $check_password = Hash::check($this->request->getVar('password'),$userInfo['password']);
            // // die;

            // if( !$check_password ){

            //     return redirect()->route('admin.login.form')->with('fail','Wrong password')->withInput();
            // } else {
            //     CIAuth::setCIAuth($userInfo); // Importtant line
            //     return redirect()->route('admin.home');
   
            // }

            //  log_message();
        }






     }   



}
