<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('/test', 'Home::Test');

$routes->get('/test-database', 'TestControllers::testDatabaseConnection');


$routes->group('admin',static function($routes){

    $routes->group('',['filter'=>'cifilter:auth'],static function($routes){
        // $routes->view('example-page','example-page');
        $routes->get('home','AdminController::index',['as'=>'admin.home']);
        //route reportv for admin
        $routes->get('reportv','AdminController::reportv',['as'=>'admin.reportv']);
        //Gen report v
        $routes->post('gen_reportv','ReportvController::gen_reportv',['as'=>'admin.reportv.genv']);
        //logout
        $routes->get('logout','AdminController::logoutHandler',['as'=>'admin.logout']);
    });

    $routes->group('',['filter'=>'cifilter:guest'],static function($routes){
        // $routes->view('example-auth','example-auth');
        $routes->get('login','AuthController::loginForm',['as'=>'admin.login.form']);
        $routes->post('login','AuthController::loginHandler',['as'=>'admin.login.handler']);

        
    });

});




