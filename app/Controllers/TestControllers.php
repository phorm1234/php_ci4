<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class TestControllers extends BaseController
{
    protected $helper = ['url', 'form'];



    public function testDatabaseConnection()
    {

            // Usage in testdata:
            $config = [
                'DSN'         => '',
                'hostname'    => '192.168.1.2',
                'username'    => 'sa',
                'password'    => '',
                'database'    => 'TBT',
                'DBDriver'    => 'SQLSRV',
                'DBPrefix'    => '',
                'pConnect'    => false,
                'DBDebug'     => (ENVIRONMENT !== 'production'),
                'cacheOn'     => false,
                'cacheDir'    => '',
                'charset'     => 'utf8',
                'DBCollat'    => 'utf8_general_ci',
                'swapPre'     => '',
                'encrypt'     => false,
                'compress'    => false,
                'strictOn'    => false,
                'failover'    => [],
                'port'        => 1433, // Change this to your SQL Server port if needed
            ];
            // Create a new database connection sql_srver
            $db_srv = \Config\Database::connect($config);
        // phpinfo();
        // die;
        try {
            // Load the database library
            // $db_srv = db_connect('default'); // Use the sqlsrv_tbt database configuration

            // Check if the database connection is successful
            if ($db_srv->connect()) {
                    echo 'Database connection successful!';
                    // $y = $this->request->getPost('input_date_sale');
                    // $c = $this->request->getPost('input_customer_code');


                    // var_dump('<pre>',$y.' - '.$c);
                    // die;
        
                    $y = 2024;
                    $c = 'BOI0044';
                    // input datesale
                    // $y = $_POST['input_date_sale'];
                    // input customer code
                    // $c = $_POST['input_date_sale'];
                    //sql get data sale from sqlserver

                    // $sql = "SELECT SALINBFIL.INB_CUSTCODE, SALINBFIL.INB_CUSTPART,
                    // CASE
                    //     WHEN MONTH(SALINHFIL.INH_INVDATE) = 1 THEN SUM(INB_QTY)
                    //     ELSE 0
                    // END AS M1,
                    // CASE
                    //     WHEN MONTH(SALINHFIL.INH_INVDATE) = 2 THEN SUM(INB_QTY)
                    //     ELSE 0
                    // END AS M2,
                    // CASE
                    //     WHEN MONTH(SALINHFIL.INH_INVDATE) = 3 THEN SUM(INB_QTY)
                    //     ELSE 0
                    // END AS M3,
                    // CASE
                    //     WHEN MONTH(SALINHFIL.INH_INVDATE) = 4 THEN SUM(INB_QTY)
                    //     ELSE 0
                    // END AS M4,
                    // CASE
                    //     WHEN MONTH(SALINHFIL.INH_INVDATE) = 5 THEN SUM(INB_QTY)
                    //     ELSE 0
                    // END AS M5,
                    // CASE
                    //     WHEN MONTH(SALINHFIL.INH_INVDATE) = 6 THEN SUM(INB_QTY)
                    //     ELSE 0
                    // END AS M6,
                    // CASE
                    //     WHEN MONTH(SALINHFIL.INH_INVDATE) = 7 THEN SUM(INB_QTY)
                    //     ELSE 0
                    // END AS M7,
                    // CASE
                    //     WHEN MONTH(SALINHFIL.INH_INVDATE) = 8 THEN SUM(INB_QTY)
                    //     ELSE 0
                    // END AS M8,
                    // CASE
                    //     WHEN MONTH(SALINHFIL.INH_INVDATE) = 9 THEN SUM(INB_QTY)
                    //     ELSE 0
                    // END AS M9,
                    // CASE
                    //     WHEN MONTH(SALINHFIL.INH_INVDATE) = 10 THEN SUM(INB_QTY)
                    //     ELSE 0
                    // END AS M10,
                    // CASE
                    //     WHEN MONTH(SALINHFIL.INH_INVDATE) = 11 THEN SUM(INB_QTY)
                    //     ELSE 0
                    // END AS M11,
                    // CASE
                    //     WHEN MONTH(SALINHFIL.INH_INVDATE) = 12 THEN SUM(INB_QTY)
                    //     ELSE 0
                    // END AS M12
                    // FROM   SALINHFIL INNER JOIN
                    //             SALINBFIL ON SALINHFIL.INH_INVNO = SALINBFIL.INB_INVNO
                    // WHERE YEAR(SALINHFIL.INH_INVDATE) = $y
                    // GROUP BY SALINBFIL.INB_CUSTCODE, SALINBFIL.INB_CUSTPART,SALINHFIL.INH_INVDATE
                    // HAVING SALINBFIL.INB_CUSTCODE = '$c'
                    // ;
                    // ";
                    // $query = $db_srv->query($sql);
                    // print_r($query);
                    // result query from sqlserver
                    $sql = "SELECT SALINBFIL.INB_CUSTCODE, SALINBFIL.INB_CUSTPART,
                    SUM(CASE WHEN MONTH(SALINHFIL.INH_INVDATE) = 1 THEN INB_QTY ELSE 0 END) AS M1,
                    SUM(CASE WHEN MONTH(SALINHFIL.INH_INVDATE) = 2 THEN INB_QTY ELSE 0 END) AS M2,
                    SUM(CASE WHEN MONTH(SALINHFIL.INH_INVDATE) = 3 THEN INB_QTY ELSE 0 END) AS M3,
                    SUM(CASE WHEN MONTH(SALINHFIL.INH_INVDATE) = 4 THEN INB_QTY ELSE 0 END) AS M4,
                    SUM(CASE WHEN MONTH(SALINHFIL.INH_INVDATE) = 5 THEN INB_QTY ELSE 0 END) AS M5,
                    SUM(CASE WHEN MONTH(SALINHFIL.INH_INVDATE) = 6 THEN INB_QTY ELSE 0 END) AS M6,
                    SUM(CASE WHEN MONTH(SALINHFIL.INH_INVDATE) = 7 THEN INB_QTY ELSE 0 END) AS M7,
                    SUM(CASE WHEN MONTH(SALINHFIL.INH_INVDATE) = 8 THEN INB_QTY ELSE 0 END) AS M8,
                    SUM(CASE WHEN MONTH(SALINHFIL.INH_INVDATE) = 9 THEN INB_QTY ELSE 0 END) AS M9,
                    SUM(CASE WHEN MONTH(SALINHFIL.INH_INVDATE) = 10 THEN INB_QTY ELSE 0 END) AS M10,
                    SUM(CASE WHEN MONTH(SALINHFIL.INH_INVDATE) = 11 THEN INB_QTY ELSE 0 END) AS M11,
                    SUM(CASE WHEN MONTH(SALINHFIL.INH_INVDATE) = 12 THEN INB_QTY ELSE 0 END) AS M12
                    FROM SALINHFIL 
                    INNER JOIN SALINBFIL ON SALINHFIL.INH_INVNO = SALINBFIL.INB_INVNO
                    WHERE YEAR(SALINHFIL.INH_INVDATE) = $y
                    AND SALINBFIL.INB_CUSTCODE = '$c'
                    GROUP BY SALINBFIL.INB_CUSTCODE, SALINBFIL.INB_CUSTPART";
                    $query = $db_srv->query($sql);
                    
                    //Column [INB_CUSTCODE],[INB_CUSTPART],[M1],[M2],[M3],[M4],[M5],[M6],[M7],[M8],[M9],[M10],[M11],[M12]
                    //foreach data 
                    $data=[];
                    $result_data=[];
                    foreach($query->getResult('array') as $row){
                        // echo '<pre>';
                        //define var prepare to push in array
                        $INB_CUSTCODE= $row['INB_CUSTCODE'];
                        $INB_CUSTPART= $row['INB_CUSTPART'];
                        $sale_month1 = $row['M1'];
                        $sale_month2 = $row['M2'];
                        $sale_month3 = $row['M3'];
                        $sale_month4 = $row['M4'];
                        $sale_month5 = $row['M5'];
                        $sale_month6 = $row['M6'];
                        $sale_month7 = $row['M7'];
                        $sale_month8 = $row['M8'];
                        $sale_month9 = $row['M9'];
                        $sale_month10 = $row['M10'];
                        $sale_month11 = $row['M11'];
                        $sale_month12 = $row['M12'];

                        //
                        $data['customer_code']=$INB_CUSTCODE;
                        $data['customer_part']=$INB_CUSTPART;
                        $data['sale_month1']=$sale_month1;
                        $data['sale_month2']=$sale_month2;
                        $data['sale_month3']=$sale_month3;
                        $data['sale_month4']=$sale_month4;
                        $data['sale_month5']=$sale_month5;
                        $data['sale_month6']=$sale_month6;
                        $data['sale_month7']=$sale_month7;
                        $data['sale_month8']=$sale_month8;          
                        $data['sale_month9']=$sale_month9;
                        $data['sale_month10']=$sale_month10;
                        $data['sale_month11']=$sale_month11;
                        $data['sale_month12']=$sale_month12;
                        //push in result array
                        array_push($result_data,$data);

                    }
                    echo '<pre>';
                    print_r($query);
                    // die;
            } else {
                echo 'Database connection failed!';
                // Output the database error message for debugging
                print_r($db_srv->error());
            }
        } catch (\Exception $e) {
            // Handle the exception
            echo 'Error connecting to the database: ' . $e->getMessage();
        }
    }
    
}
