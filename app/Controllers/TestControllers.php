<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class TestControllers extends BaseController
{
    protected $helper = ['url', 'form'];

    public function testDatabaseConnection()
    {
        // phpinfo();
        // die;
        try {
            // Load the database library
            $db = db_connect('default'); // Use the sqlsrv_tbt database configuration

            // Check if the database connection is successful
            if ($db->connect()) {
                echo 'Database connection successful!';
            } else {
                echo 'Database connection failed!';
                // Output the database error message for debugging
                print_r($db->error());
            }
        } catch (\Exception $e) {
            // Handle the exception
            echo 'Error connecting to the database: ' . $e->getMessage();
        }
    }
    
}
