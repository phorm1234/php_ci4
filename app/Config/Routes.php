<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('/test', 'Home::Test');

$routes->get('/test-database', 'TestControllers::testDatabaseConnection');

//Master get_productbyid
$routes->post('getproductbyid', 'MasterController::get_product', ['as' => 'master.getproductbyid']);
//master get_datatable
$routes->post('gettablemasterproduct', 'MasterController::get_table_masterproduct', ['as' => 'master.get_table_masterproduct']);
//Master insetproduct
$routes->post('insertproduct', 'MasterController::insert_product');
//Master updateproduct
$routes->post('updateproduct', 'MasterController::update_product');
//Master deleteproduct
$routes->post('delete_product', 'MasterController::delete_product');





//master get_datatable
$routes->post('gettablecustomer', 'MasterController::get_table_mastercustomer', ['as' => 'master.get_table_mastercustomer']);
//Master insetcustomer
$routes->post('insertcustomer', 'MasterController::insert_customer');
//gen insert report v
$routes->post('gen_reportv','ReportvController::genreportv');
//gen show reportv
$routes->post('show_reportv','ReportvController::showreportv');







$routes->group('admin',static function($routes){

    $routes->group('',['filter'=>'cifilter:auth'],static function($routes){
        // $routes->view('example-page','example-page');
        $routes->get('home','AdminController::index',['as'=>'admin.home']);
        //route reportv for admin
        $routes->get('reportv','ReportvController::reportv',['as'=>'admin.reportv']);
        //route Master
        $routes->get('masterproduct','MasterController::masterproduct',['as'=>'admin.master.product']);
        $routes->get('mastercustomer','MasterController::mastercustomer',['as'=>'admin.master.customer']);
   

        // Define a route without query parameters
        // $routes->get('get_product?product_id(:any)', 'MasterController::get_product?product_id=$1', ['as' => 'admin.master.getproduct']);


        // $routes->get('get_product','MasterController::get_product',['as'=>'admin.master.getproduct']);

        // $routes->post('get_table_masterproduct','MasterController::table_product',['as'=>'admin.master.table_product']);
        //Gen report v
        // $routes->post('gen_reportv','ReportvController::gen_reportv',['as'=>'admin.reportv.genv']);
        //logout
        $routes->get('logout','AdminController::logoutHandler',['as'=>'admin.logout']);
    });

    $routes->group('',['filter'=>'cifilter:guest'],static function($routes){
        // $routes->view('example-auth','example-auth');
        //login
        $routes->get('login','AuthController::loginForm',['as'=>'admin.login.form']);
        $routes->post('login','AuthController::loginHandler',['as'=>'admin.login.handler']);
        //forgot password
        $routes->get('forgot-password','AuthController::forgotForm',['as'=>'admin.forgot.form']); 
        $routes->post('send-password-reset-link','AuthController::sendPasswordResetLink',['as'=>'send_password_reset_link']);

        //  $routes->post('forgot-password','AuthController::sendPasswordResetLink',['as'=>'admin.send_password_reset_link']);

        $routes->get('password/reset/(:any','AuthController::resetPassword/$i',['as'=>'admin.reset-password']);

    });

});




