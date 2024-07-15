<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Libraries\CIAuth;
use App\Libraries\Hash;
use App\Models\User;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// Include PhpSpreadsheet autoload file
// require '../vendor/autoload.php';
class ReportvController extends BaseController
{
    protected $helper = ['url','form'];
    protected $db2;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->mastertbt_customer = $this->db->table('mastertbt_customer');
        $this->mastertbt_product = $this->db->table('mastertbt_product');
        $this->reportv_data = $this->db->table('reportv_data');
        $this->ng_from_sale = $this->db->table('ng_from_sale');
        $this->balance_stock = $this->db->table('balance_stock');
        $this->db2 = \Config\Database::connect('ErpDB');
        // $this->db2 = Database::connect('sqlsrErpDBv_tbt');
        
    }

    public function reportv() {
        $this->mastertbt_customer->select('customer_code,name_tbt');
        $this->mastertbt_customer->where("is_use",1);
        $result = $this->mastertbt_customer->get()->getResult();

        $this->mastertbt_customer->select('customer_code,name_tbt');
        $this->mastertbt_customer->like("name_tbt", 'MINEBEA', 'both');
        $this->mastertbt_customer->where("is_use",1);
        $result_cust_mb = $this->mastertbt_customer->get()->getResult();
        $data = [
            'pageTitle'=>'ReportV',
            'select_cust'=>$result,
            'select_custmb'=>$result_cust_mb
        ];
        return view('backend/pages/reportv',$data);
    }

    public function ngfromsale() {
        // $this->reportv_data->select('');

        $result_custpart = $this->get_srv_custpart(2024);

        $result_cust = $this->get_srv_cust(2024);

        $data = [
            'pageTitle'=>'FormNG',
            'cuspart_sale'=>$result_custpart,
            'cust_sale'=>$result_cust
            // 'select_custmb'=>$result_cust_mb
        ];
        return view('backend/pages/formng',$data);
    }
    // function call get cust sale
    public function get_srv_custpart($year) {


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

        try {
            // Load the database library
            // $db_srv = db_connect('default'); // Use the sqlsrv_tbt database configuration

            // Check if the database connection is successful
            if ($db_srv->connect()) {
                    // echo 'Database connection successful!';
                
                    $sql = "SELECT DISTINCT SALINBFIL.INB_CUSTPART,SALINBFIL.INB_CUSTCODE
                    FROM SALINHFIL 
                    INNER JOIN SALINBFIL ON SALINHFIL.INH_INVNO = SALINBFIL.INB_INVNO
                    WHERE YEAR(SALINHFIL.INH_INVDATE) = $year
                    GROUP BY SALINBFIL.INB_CUSTCODE, SALINBFIL.INB_CUSTPART";
                    $query = $db_srv->query($sql);
                    $result = $query->getResult('array');

                    // var_dump('<pre>',$result);
                    // die;
                    return $result;
            }
            else {
                echo 'Database connection failed!';
                // Output the database error message for debugging
                print_r($db_srv->error());
            }
        } catch (\Exception $e) {
            // Handle the exception
            echo 'Error connecting to the database: ' . $e->getMessage();
        }
    }
    public function get_srv_cust($year) {


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

        try {
            // Load the database library
            // $db_srv = db_connect('default'); // Use the sqlsrv_tbt database configuration

            // Check if the database connection is successful
            if ($db_srv->connect()) {
                    // echo 'Database connection successful!';
                
                    $sql = "SELECT DISTINCT SALINBFIL.INB_CUSTCODE
                    FROM SALINHFIL 
                    INNER JOIN SALINBFIL ON SALINHFIL.INH_INVNO = SALINBFIL.INB_INVNO
                    WHERE YEAR(SALINHFIL.INH_INVDATE) = $year
                    GROUP BY SALINBFIL.INB_CUSTCODE, SALINBFIL.INB_CUSTPART";
                    $query = $db_srv->query($sql);
                    $result = $query->getResult('array');
       
                    return $result;
            }
            else {
                echo 'Database connection failed!';
                // Output the database error message for debugging
                print_r($db_srv->error());
            }
        } catch (\Exception $e) {
            // Handle the exception
            echo 'Error connecting to the database: ' . $e->getMessage();
        }
    }

    public function ngfromsale_update() {
        $customer_part = $this->request->getPost('select_ng_part');

        $explode_select = explode("_",$customer_part);

        $customer_code = $explode_select[1];
        $cust_part = $explode_select[0];

        $date_ng = $this->request->getPost('date_ng');
        $ng_quantity = $this->request->getPost('ng_quantity');

        $test_input = $customer_part.' : '.$date_ng.' : '.$ng_quantity;
        $input_date = date('Y-m-d', strtotime($date_ng));
        $explode_date = explode("-",$input_date);


        // $this->$ng_from_sale->
        // Define data to be updated
        $data = array(
            'ng_year' => $explode_date[0], 
            'ng_month' => intval($explode_date[1]),
            'ng_day' => intval($explode_date[2]),
            'ng_part' => trim($cust_part),
            'customer_code' => trim($customer_code),
            'ng_quantity' => $ng_quantity,
            'create_by' => 'admin',
            'modify_by' => 'admin'
        );
        // Check if the combination of customer_code and ng_part exists in the database
        // $existing_record_count = $this->ng_from_sale->where('customer_code',trim($customer_code))
        //     ->where('ng_part', trim($cust_part))
        //     ->countAllResults();
        $existing_record_count = $this->ng_from_sale->where('customer_code', trim($customer_code))
                                            ->where('ng_part', trim($cust_part))
                                            ->where('ng_year', $explode_date[0])
                                            ->where('ng_month', intval($explode_date[1]))
                                            ->countAllResults();

        // var_dump('<pre>',$existing_record->num_rows());
        // die;

        if ($existing_record_count > 0) {
            // If record exists, update it
            $this->ng_from_sale->where('customer_code', trim($customer_code));
            $this->ng_from_sale->where('ng_part', trim($cust_part));
            $this->ng_from_sale->where('ng_year', $explode_date[0]);
            $this->ng_from_sale->where('ng_month', intval($explode_date[1]));
            $this->ng_from_sale->update($data);
            $message = "Update Success !!!";
        } else {
            // If record doesn't exist, insert it
            $this->ng_from_sale->insert($data);
            $message = "Insert Success !!!";
        }

        return $this->response->setJSON(['success' => true, 'message' => $message]);
    }

    public function genmbv() {

        //input company

        $company_name = $this->request->getPost('company_dup');

        $this->reportv_data->select('run_id,exp_entry,customer_code');
        // $this->reportv_data->like("customer_name", 'MINEBEA', 'both');
        $this->reportv_data->like("customer_name", $company_name , 'both');

        $this->reportv_data->where("minibea_updated",0);
        $this->reportv_data->groupBy("exp_entry");
        // $this->reportv_data->where("is_use",1);
        $result_mb_reportv= $this->reportv_data->get()->getResult();


        //Select company dup
        $this->mastertbt_customer->select('customer_code,name_tbt');
        // if ($company_name == 'CASIO') {
        //     $casio_codes = ['BOI9001', 'BOI9009'];
        //     $this->mastertbt_customer->whereIn(trim('customer_code'), $casio_codes);
            
        //     // $this->mastertbt_customer->like(trim("name_tbt"), trim('CASIO (THAILAND) CO.,LTD.') , 'both');
        // } else {
        //         $this->mastertbt_customer->like(trim("name_tbt"), trim($company_name) , 'both');
        // }
        $this->mastertbt_customer->like(trim("name_tbt"), trim($company_name) , 'both');
        $this->mastertbt_customer->where("is_use",1);
        // Print the compiled SQL query for debugging
        // echo $this->mastertbt_customer->getCompiledSelect();
        // die(); // Stop execution to inspect the output
        $result_cust_mb = $this->mastertbt_customer->get()->getResult();
        // echo $result_mb_reportv;
        // die();
        if (!empty($result_mb_reportv) || !empty($result_cust_mb) ) {
            return $this->response->setJSON(['select_cust_com_dup' => $result_cust_mb,'select_reportv_mb' => $result_mb_reportv, 'success' => true, 'message' => 'Get Data Success']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'No Data Found']);
        }
    }

    public function updatembv() {
        $project_code = $this->request->getPost('minibea_ic');
        $minibea_customer = $this->request->getPost('minibea_customer');

        // Fetch customer data
        $this->mastertbt_customer->select('customer_code, name_tbt');
        $this->mastertbt_customer->where("customer_code", $minibea_customer);
        $this->mastertbt_customer->where("is_use", 1);
        $cust_data = $this->mastertbt_customer->get()->getRow();

        // Define data to be updated
        $data = array(
            'customer_code' => $minibea_customer, 
            'customer_name' => $cust_data->name_tbt,
            'minibea_updated' => 1          // update this when minibea update
        );

        // Build and execute the UPDATE query
        $this->reportv_data->where('exp_entry', $project_code);
        $this->reportv_data->update($data);
        if ($cust_data) {
            // Define data to be updated
            $data = array(
                'customer_code' => $minibea_customer,
                'customer_name' => $cust_data->name_tbt
            );
        
            // Build and execute the UPDATE query
            $this->reportv_data->where('exp_entry', $project_code);
            $success = $this->reportv_data->update($data);
        
            if ($success) {
                // Respond with success message
                $message = 'Data updated successfully.';
                
            } else {
                // Respond with error message
                $message = 'Failed to update data.';
            }
        } else {
            // Respond with error message if customer data not found
            $message = 'Customer data not found.';
        }
        
    
        return $this->response->setJSON(['success' => true, 'message' => $message]);      
    }

    // public function genreportv()
    // {
    //     // Get the input date and file
    //     $inputDate = $this->request->getPost('input_date');
    //     $uploadedFile = $this->request->getFile('input_icfile');
    //     $specialCheck = $this->request->getPost('special_check');
    //     // Initialize array_test as an associative array


    //     $array_test = [
    //         'COLUMN_B' => [],
    //         'COLUMN_C' => [],
    //         'COLUMN_D' => [],
    //         'COLUMN_E' => [],
    //         'COLUMN_F' => [],
    //         'COLUMN_G' => [],
    //         'COLUMN_H' => [],
    //         'COLUMN_I' => [],
    //         'COLUMN_J' => [],
    //         'CUSTOMER_DATA' => [],
    //         'PRODUCT_DATA' => [],
    //     ];

    //     // Check if a file was uploaded
    //     if ($uploadedFile && $uploadedFile->isValid()) {
    //         // Read the Excel file
    //         $spreadsheet = IOFactory::load($uploadedFile->getTempName());
    //         $worksheet = $spreadsheet->getActiveSheet();

    //         // Parse the input date range
    //         $dateRange = explode(' - ', $inputDate);
    //         $startDate = date_create_from_format('m/d/Y', $dateRange[0]);
    //         $endDate = date_create_from_format('m/d/Y', $dateRange[1]);

    //         $explode_datest = explode('/', $dateRange[0]);
    //         $explode_dateend = explode('/', $dateRange[1]);
 
    //         $format_db_datestart = $explode_datest[2].'-'.$explode_datest[0].'-'.$explode_datest[1];
    //         $format_db_dateend = $explode_dateend[2].'-'.$explode_dateend[0].'-'.$explode_dateend[1];

    //         if(!isset($specialCheck) && $specialCheck != "on") {
    //             // clear data 
    //             // Delete data within the specified date range 
    //             $this->reportv_data->where('exp_date >=', $format_db_datestart);
    //             $this->reportv_data->where('exp_date <=', $format_db_dateend);
    //             $this->reportv_data->delete();
    //             // var_dump('<pre>','TESTTT');
    //             // die;
    //         } 
    //         // Get the highest row number in column C
    //         $highestRow = $worksheet->getHighestDataRow('C');
    //         $monthlyData = [];
    //         $count_row_excel =0;
    //         $highest_excel = $highestRow;
    //         $count_insert = 0;

    //         $text_error="";
    //         // Iterate over cells in column C from C2 to the last non-empty cell
    //         for ($row = 2; $row <= $highestRow; $row++) {
    //             // Get the value of the cell in column C at the current row
    //             $dataB = $worksheet->getCell('B' . $row)->getValue(); // tbt_com_name
    //             $dataC = $worksheet->getCell('C' . $row)->getValue(); // cust_com_name
    //             $dataD = $worksheet->getCell('D' . $row)->getValue(); // exp_entry
    //             $dataE = $worksheet->getCell('E' . $row)->getValue(); // exp_date
    //             $dataF = $worksheet->getCell('F' . $row)->getValue(); // exp_declare
    //             $dataG = $worksheet->getCell('G' . $row)->getValue(); // ven_product_code
    //             $dataH = $worksheet->getCell('H' . $row)->getValue(); // ven_english_desc
    //             $dataI = $worksheet->getCell('I' . $row)->getValue(); // qty 
    //             $dataJ = $worksheet->getCell('J' . $row)->getValue(); // UOP


    //             if($dataB == "" || $dataC == "" || $dataD == "" || $dataE == "" || $dataF == "" || $dataG == "" || $dataH == "" || $dataI == "" || $dataJ == "") {
    //                 $text_error = "Blank data in line".$row;

    //                 return $this->response->setJSON(['success' => false,'count_insert'=>$count_insert,'count_excel'=>$count_row_excel,'highest_row'=>$highest_excel, 'message' => $text_error]);
    //             }

              
    //             // var_dump('<pre>',$dataJ);
    //             // die;
    //             // Parse the date value from column E
    //             $dateE = date_create_from_format('d/m/Y', $dataE);


    //             // var_dump('<pre>',$jsonData);
    //             // die;
               
    //             if (!empty($dataC)  && $dateE >= $startDate && $dateE <= $endDate ) {
    //                 $count_row_excel++;
    //                 // Construct an associative array representing the data for all 12 months
    //                 $jan_sale=0;
    //                 $feb_sale=0;
    //                 $mar_sale=0;
    //                 $apr_sale=0;
    //                 $may_sale=0;
    //                 $jun_sale=0;
    //                 $jul_sale=0;
    //                 $aug_sale=0;
    //                 $sep_sale=0;
    //                 $oct_sale=0;
    //                 $nov_sale=0;
    //                 $dec_sale=0;

    //                 $jan_rtn=0;
    //                 $feb_rtn=0;
    //                 $mar_rtn=0;
    //                 $apr_rtn=0;
    //                 $may_rtn=0;
    //                 $jun_rtn=0;
    //                 $jul_rtn=0;
    //                 $aug_rtn=0;
    //                 $sep_rtn=0;
    //                 $oct_rtn=0;
    //                 $nov_rtn=0;
    //                 $dec_rtn=0;


    //                 $rowData = [
    //                     'january_sale' => $jan_sale,
    //                     'febuary_sale' => $feb_sale,
    //                     'march_sale' => $mar_sale,
    //                     'april_sale' => $apr_sale,
    //                     'may_sale' => $may_sale,
    //                     'june_sale' => $jun_sale,
    //                     'july_sale' => $jul_sale,
    //                     'august_sale' => $aug_sale,
    //                     'september_sale' => $sep_sale,
    //                     'october_sale' => $oct_sale,
    //                     'november_sale' => $nov_sale,
    //                     'december_sale' => $dec_sale,

    //                     'january_return' => $jan_rtn,
    //                     'febuary_return' => $feb_rtn,
    //                     'march_return' => $mar_rtn,
    //                     'april_return' => $apr_rtn,
    //                     'may_return' => $may_rtn,
    //                     'june_return' => $jun_rtn,
    //                     'july_return' => $jul_rtn,
    //                     'august_return' => $aug_rtn,
    //                     'september_return' => $sep_rtn,
    //                     'october_return' => $oct_rtn,
    //                     'november_return' => $nov_rtn,
    //                     'december_return' => $dec_rtn,
    //                     // Add data for the remaining months...
    //                 ];
    //                 // Push the row data into the monthlyData array
    //                 $monthlyData[] = $rowData;
    //                 // Convert the monthlyData array to JSON format
    //                 $jsonData = json_encode($monthlyData);
                    
    //                 array_push($array_test['COLUMN_B'], $dataB);
    //                 array_push($array_test['COLUMN_C'], $dataC);
    //                 array_push($array_test['COLUMN_D'], $dataD);
    //                 array_push($array_test['COLUMN_E'], $dataE);
    //                 array_push($array_test['COLUMN_F'], $dataF);
    //                 array_push($array_test['COLUMN_G'], $dataG);
    //                 array_push($array_test['COLUMN_H'], $dataH);
    //                 $format_I=number_format((float) $dataI, 8, '.', '');
    //                 array_push($array_test['COLUMN_I'], $format_I);
    //                 array_push($array_test['COLUMN_J'], $dataJ);
    //                   // Trim the value of $dataC
    //                 $trimmedDataC = trim($dataC);
    //                 // If the cell is not empty, push its value into the array
    //                 // Query the mastertbt_customer table for records where name_ic matches $trimmedDataC
    //                 $customerRecord = $this->mastertbt_customer->where('name_ic', $trimmedDataC)->get()->getRow();

    //                 if ($customerRecord) {
    //                     $customerData = [
    //                         'customer_code' => $customerRecord->customer_code,
    //                         'name_ic' => $customerRecord->name_ic,
    //                         'name_tbt' => $customerRecord->name_tbt
    //                     ];
                
    //                     array_push($array_test['CUSTOMER_DATA'], $customerData);
    //                 }else{
    //                     $customerData = [
    //                         'customer_code' =>'NONE DATA',
    //                         'name_ic' => 'NONE DATA',
    //                         'name_tbt' => 'NONE DATA'
    //                     ];
    //                     array_push($array_test['CUSTOMER_DATA'], $customerData);
    //                 }

    //                 $trimmedDataH = trim($dataH);
    //                 // If the cell is not empty, push its value into the array
    //                 // Query the mastertbt_customer table for records where product_name matches $trimmedDataC
    //                 $productRecord = $this->mastertbt_product->where('product_name', $trimmedDataH)->get()->getRow();

    //                 if ($productRecord) {
    //                     $productData = [
    //                         'product_code' => $productRecord->product_code,
    //                         'product_name' => $productRecord->product_name,
    //                         'product_group' => $productRecord->product_group
    //                     ];
                
    //                     array_push($array_test['PRODUCT_DATA'], $productData);
    //                 }else{
    //                     $productData = [
    //                         'product_code' =>'NONE DATA',
    //                         'product_name' => 'NONE DATA',
    //                         'product_group' => 'NONE DATA'
    //                     ];
    //                     array_push($array_test['PRODUCT_DATA'], $productData);
    //                 }

    //                 $explode_dateE = explode('/', $dataE);
    //                 // $startDate = date_create_from_format('m/d/Y', $dateRange[0]);
    //                 // $endDate = date_create_from_format('m/d/Y', $dateRange[1]);
    //                 $format_db_date = $explode_dateE[2].'-'.$explode_dateE[1].'-'.$explode_dateE[0];
               
    //                 //Test new function
    //                 try {
    //                     $this->reportv_data->insert([
    //                         'tbt_com_name' => $dataB,
    //                         'customer_code' => $customerData['customer_code'],
    //                         'customer_name' => $customerData['name_tbt'],
    //                         'ven_product_code' => $dataG,
    //                         'tbt_product_group' => $productData['product_group'],
    //                         'ven_eng_desc' => $dataH,
    //                         'exp_name' => $dataC,
    //                         'exp_entry' => $dataD,
    //                         'exp_date' => $format_db_date,
    //                         'exp_declare_line' => $dataF,
    //                         'quantity' => $format_I,
    //                         'uop' => $dataJ,
    //                         'tbt_product_code' => $productData['product_code'],
    //                         'summary_json' => $jsonData,
    //                         'create_by' => 'admin',
    //                         'modify_by' => 'admin'
    //                         // Add more columns as needed
    //                     ]);
    //                     $count_insert++;
    //                 } catch (\Exception $e) {
    //                     // Handle the error here, for example:
    //                     // Log the error
    //                     // Return an error response
    //                     // Rollback transaction if applicable
    //                     // etc.
    //                     return $this->response->setJSON(['success' => false,'count_insert'=>$count_insert,'count_excel'=>$count_row_excel,'highest_row'=>$highest_excel, 'message' => 'Please Check Row Excel'.$row]);
    //                     // return response()->json(['error' => 'Failed to insert row: ' . $e->getMessage()], 500);
    //                 }

    //                 //Test new function
    //                 // session()->setFlashdata('success', 'Data deleted successfully.');
    //             } else {
    //                 // If an empty cell is encountered, break out of the loop
    //                 break;
    //             }
    //         }
    //         // Process the data further as needed
    //     } else {
    //         // session()->setFlashdata('error', 'Please upload a valid Excel file.');
    //         // File not uploaded or invalid
    //         return $this->response->setJSON(['success' => false, 'message' => 'Please upload a valid Excel file.']);
    //         // return redirect()->back()->with('error', 'Please upload a valid Excel file.');
    //     }



    //     return $this->response->setJSON(['count_insert'=>$count_insert,'count_excel'=>$count_row_excel,'highest_row'=>$highest_excel,'success' => true, 'message' => 'Report generated successfully.']);
    
    // }
    public function genreportv()
    {
        $inputDate = $this->request->getPost('input_date');
        $uploadedFile = $this->request->getFile('input_icfile');
        $specialCheck = $this->request->getPost('special_check');

        $array_test = [
            'COLUMN_B' => [],
            'COLUMN_C' => [],
            'COLUMN_D' => [],
            'COLUMN_E' => [],
            'COLUMN_F' => [],
            'COLUMN_G' => [],
            'COLUMN_H' => [],
            'COLUMN_I' => [],
            'COLUMN_J' => [],
            'CUSTOMER_DATA' => [],
            'PRODUCT_DATA' => [],
        ];

        if ($uploadedFile && $uploadedFile->isValid()) {
            $spreadsheet = IOFactory::load($uploadedFile->getTempName());
            $worksheet = $spreadsheet->getActiveSheet();

            $dateRange = explode(' - ', $inputDate);
            $startDate = date_create_from_format('m/d/Y', $dateRange[0]);
            $endDate = date_create_from_format('m/d/Y', $dateRange[1]);

            $explode_datest = explode('/', $dateRange[0]);
            $explode_dateend = explode('/', $dateRange[1]);

            $format_db_datestart = $explode_datest[2] . '-' . $explode_datest[0] . '-' . $explode_datest[1];
            $format_db_dateend = $explode_dateend[2] . '-' . $explode_dateend[0] . '-' . $explode_dateend[1];

            if (!isset($specialCheck) && $specialCheck != "on") {
                $this->reportv_data->where('exp_date >=', $format_db_datestart)
                                ->where('exp_date <=', $format_db_dateend)
                                ->delete();
            }

            $highestRow = $worksheet->getHighestDataRow('C');
            $monthlyData = [];
            $count_insert = 0;
            $text_error = "";

            $customerCache = [];
            $productCache = [];

            for ($row = 2; $row <= $highestRow; $row++) {
                $data = [];
                foreach (range('B', 'J') as $col) {
                    $data[$col] = $worksheet->getCell($col . $row)->getValue();
                }

                if (in_array("", $data, true)) {
                    $text_error = "Blank data in line " . $row;
                    return $this->response->setJSON(['success' => false, 'count_insert' => $count_insert, 'highest_row' => $highestRow, 'message' => $text_error]);
                }

                $dateE = date_create_from_format('d/m/Y', $data['E']);
                if (!empty($data['C']) && $dateE >= $startDate && $dateE <= $endDate) {
            

                    foreach (range('B', 'J') as $col) {
                        $array_test['COLUMN_' . $col][] = $data[$col];
                    }

                    $trimmedDataC = trim($data['C']);
                    if (!isset($customerCache[$trimmedDataC])) {
                        $customerRecord = $this->mastertbt_customer->where('name_ic', $trimmedDataC)->get()->getRow();
                        $customerCache[$trimmedDataC] = $customerRecord ? [
                            'customer_code' => $customerRecord->customer_code,
                            'name_ic' => $customerRecord->name_ic,
                            'name_tbt' => $customerRecord->name_tbt
                        ] : [
                            'customer_code' => 'NONE DATA',
                            'name_ic' => 'NONE DATA',
                            'name_tbt' => 'NONE DATA'
                        ];
                    }
                    $array_test['CUSTOMER_DATA'][] = $customerCache[$trimmedDataC];

                    $trimmedDataH = trim($data['H']);
                    if (!isset($productCache[$trimmedDataH])) {
                        $productRecord = $this->mastertbt_product->where('product_name', $trimmedDataH)->get()->getRow();
                        $productCache[$trimmedDataH] = $productRecord ? [
                            'product_code' => $productRecord->product_code,
                            'product_name' => $productRecord->product_name,
                            'product_group' => $productRecord->product_group
                        ] : [
                            'product_code' => 'NONE DATA',
                            'product_name' => 'NONE DATA',
                            'product_group' => 'NONE DATA'
                        ];
                    }
                    $array_test['PRODUCT_DATA'][] = $productCache[$trimmedDataH];

                    $format_db_date = $dateE->format('Y-m-d');

                    try {
                        //database transaction
                        $this->db->transBegin();  

                        $this->reportv_data->insert([
                            'tbt_com_name' => $data['B'],
                            'customer_code' => $customerCache[$trimmedDataC]['customer_code'],
                            'customer_name' => $customerCache[$trimmedDataC]['name_tbt'],
                            'ven_product_code' => $data['G'],
                            'tbt_product_group' => $productCache[$trimmedDataH]['product_group'],
                            'ven_eng_desc' => $data['H'],
                            'exp_name' => $data['C'],
                            'exp_entry' => $data['D'],
                            'exp_date' => $format_db_date,
                            'exp_declare_line' => $data['F'],
                            'quantity' => number_format((float)$data['I'], 8, '.', ''),
                            'uop' => $data['J'],
                            'tbt_product_code' => $productCache[$trimmedDataH]['product_code'],
                            'create_by' => 'admin',
                            'modify_by' => 'admin'
                        ]);
                        $count_insert++;

                        $this->db->transCommit();
                        
                    } catch (\Exception $e) {

                        // Rollback transaction on error
                        $this->db->transRollback();

                        return $this->response->setJSON(['success' => false, 'count_insert' => $count_insert, 'highest_row' => $highestRow, 'message' => 'Please Check Row Excel ' . $row]);
                    }
                }
            }
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Please upload a valid Excel file.']);
        }

        return $this->response->setJSON(['count_insert' => $count_insert, 'highest_row' => $highestRow, 'success' => true, 'message' => 'Report generated successfully.']);
    }
    public function importBalanceStock()
    {
  

        $file = $this->request->getFile('excel_file');
        $input_year = $this->request->getPost('input_year');
        
        $this->db->table('balance_stock')->where('balance_stock_year', $input_year)
        ->delete();

        if ($file->isValid() && !$file->hasMoved()) {
            $spreadsheet = IOFactory::load($file->getTempName());
            $sheet = $spreadsheet->getActiveSheet();
            // $stock_year = '2024';
            $stock_year = $input_year;

            // var_dump('<pre>',$stock_year);
            // die;

            $data = [];
            foreach ($sheet->getRowIterator() as $row) {
                $rowIndex = $row->getRowIndex();
                if ($rowIndex == 1) {
                    continue; // Skip the first row
                }
                $customerCode = $sheet->getCell('A'.$rowIndex)->getValue();
                $vendorProductCode = $sheet->getCell('C'.$rowIndex)->getValue(); // Adjusted to correct column
                $tbtGroup = $sheet->getCell('D'.$rowIndex)->getValue();
                $balanceStockQuantity = $sheet->getCell('F'.$rowIndex)->getValue();
                $data[] = [
                    'customer_code' => $customerCode,
                    'ven_product_code' => $vendorProductCode,
                    'tbt_group' => $tbtGroup,
                    'balance_stock_year' => $stock_year,
                    'balance_stock_quantity' => $balanceStockQuantity,
                ];
            }
            $this->db->table('balance_stock')->insertBatch($data);
            return $this->response->setJSON(['message' => 'Data imported successfully.']);
        }
        return $this->response->setJSON(['message' => 'Failed to import data.'], 400);
    }
      // Define the all_null function
    private function all_null($data) {
        foreach ($data as $value) {
            if (!is_null($value)) {
                return false;
            }
        }
        return true;
    }

    public function showreportv() { //version news
           
        // Get the input date and file
       $inputYear = $this->request->getPost('input_year');
       $inputCust = $this->request->getPost('select_cust');
       // Load the template file
       $templateFile = 'templates/template_boi_result.xls';
       $spreadsheet = IOFactory::load($templateFile);
       $spreadsheet->setActiveSheetIndex(0);
       $sheet = $spreadsheet->getActiveSheet();
       
       // Fetch data from the new database
        //    $query = $this->db2->query("SELECT CustCode, Code, Name, TBTCode FROM custpartmst WHERE CustCode = ? AND (status = 5 OR status <> 81)", [$inputCust]);
        //    $newData = $query->getResultArray();
        // $query = $this->db2->query("SELECT CustCode, Code, Name, TBTCode FROM custpartmst WHERE CustCode = ? AND (status = 5 OR status <> 81)", [$inputCust]);
        // $mainData = $query->getResultArray();

        $mainData = $this->get_partmst($inputCust);

        // var_dump('<pre>',$mainData);
        // die;

        $this->reportv_data->select('tbt_com_name, customer_code, customer_name, ven_product_code, tbt_product_group, ven_eng_desc, exp_name, exp_entry, exp_date, exp_declare_line, quantity, uop, tbt_product_code, summary_json');
        $this->reportv_data->where("YEAR(exp_date) =", $inputYear);
        $this->reportv_data->where("customer_code", $inputCust);
        $this->reportv_data->orderBy('exp_date', 'asc');
        $additionalData = $this->reportv_data->get()->getResultArray();



        // For sheet3 
        $this->reportv_data->select('tbt_com_name, customer_code,customer_name,ven_product_code,tbt_product_group,ven_eng_desc,exp_name,exp_entry,exp_date,exp_declare_line,quantity,uop,tbt_product_code,summary_json');
        $this->reportv_data->where("YEAR(exp_date) =", $inputYear); // Assuming 'date_column' is the column where the year is stored
        $this->reportv_data->where("customer_code", $inputCust);
        $this->reportv_data->orderBy('exp_date', 'asc');
        $v_data2 = $this->reportv_data->get()->getResult();
        // For sheet3


        // compare item from iv file intersact and foreach after finish
        $dataMap = [];

        // Add main data to the map
        foreach ($mainData as $item) {
            $trimmedCode = trim($item['Code']);
            $dataMap[$trimmedCode] = $item;
        }
        
        // Add additional data to the map
        foreach ($additionalData as $item) {
            $trimmedCode = trim($item['ven_product_code']);
            if (!isset($dataMap[$trimmedCode])) {
                $dataMap[$trimmedCode] = $item;
            } else {
                // Merge additional data fields if necessary
                $dataMap[$trimmedCode] = array_merge($dataMap[$trimmedCode], $item);
            }
        }
        
        // Convert map to a list of items
        $mergedData = array_values($dataMap);

        // var_dump('<pre>',$mergedData);
        // die;
        
       // Fetch customer data
       $this->mastertbt_customer->select('customer_code, name_tbt');
       $this->mastertbt_customer->where("customer_code", $inputCust);
       $this->mastertbt_customer->where("is_use", 1);

       $cust_data = $this->mastertbt_customer->get()->getRow();
       $sheet->setCellValue('C3', $cust_data->customer_code);
       $sheet->setCellValue('C4', $cust_data->name_tbt);
       $sheet->setCellValue('F5', "ACTUAL SALE QUANTITY YEAR'".$inputYear);
       $sheet->setCellValue('AD8', $inputYear);
       $month_array = [1 => 'G', 2 => 'I', 3 => 'K'  , 4 => 'M', 5 => 'O', 6 => 'Q', 7 => 'S', 8 => 'U', 9 => 'W', 10 => 'Y', 11 => 'AA', 12 => 'AC']; 
       // Modify the data in the template file (for example)
       $month_array_sale = ['M1' => 'F', 'M2' => 'H', 'M3' => 'J'  , 'M4' => 'L', 'M5' => 'N', 'M6' => 'P', 'M7' => 'R', 'M8' => 'T', 'M9' => 'V', 'M10' => 'X', 'M11' => 'Z', 'M12' => 'AB'];
       // Set starting row for data appending
       $startRow = 9;
       $run_no = 1;
       $row = $startRow;
       $row_sheet2 = 3;
       $row_sheet3 = 3;

        // foreach ($newData as $newRow) {
        //         $trim_custpart = trim($newRow['Code']);
        //         $spreadsheet->setActiveSheetIndex(0);
        //         $sheet = $spreadsheet->getActiveSheet();
        //         $c = $inputCust;
        //         $y = $inputYear;
        //         // Fetch balance data
        //         $this->balance_stock->select('balance_stock_quantity');
        //         $this->balance_stock->where("customer_code",trim($inputCust));
        //         $this->balance_stock->where("ven_product_code",$trim_custpart);
        //         $this->balance_stock->where("balance_stock_year",$y );
        //         $balance_amt = $this->balance_stock->get()->getRow();
        //         if($balance_amt!=NULL) {
        //             $balance_amt = $balance_amt->balance_stock_quantity;
        //         } else {
        //             $balance_amt = 0;
        //         }
        //         // End Fetch balance data
        //         //Fetch data of Sale
        //         $result_sale = $this->get_srv_sale($c,$trim_custpart,$y);
        //         if (sizeof($result_sale)<=0) {
        //             // $sale_amt = 0;
        //             $sale_amt1=0;
        //             $sale_amt2=0;
        //             $sale_amt3=0;
        //             $sale_amt4=0;
        //             $sale_amt5=0;
        //             $sale_amt6=0;
        //             $sale_amt7=0;
        //             $sale_amt8=0;
        //             $sale_amt9=0;
        //             $sale_amt10=0;
        //             $sale_amt11=0;
        //             $sale_amt12=0;
        //         } else {
        //             // $sale_amt = $result_sale[0]['M'.$month];
        //             $sale_amt1=$result_sale[0]['M1'];
        //             $sale_amt2=$result_sale[0]['M2'];
        //             $sale_amt3=$result_sale[0]['M3'];
        //             $sale_amt4=$result_sale[0]['M4'];
        //             $sale_amt5=$result_sale[0]['M5'];
        //             $sale_amt6=$result_sale[0]['M6'];
        //             $sale_amt7=$result_sale[0]['M7'];
        //             $sale_amt8=$result_sale[0]['M8'];
        //             $sale_amt9=$result_sale[0]['M9'];
        //             $sale_amt10=$result_sale[0]['M10'];
        //             $sale_amt11=$result_sale[0]['M11'];
        //             $sale_amt12=$result_sale[0]['M12'];
        //         }
        //         //End Fetch Data of Sale
        //         for($i=1;$i<=12;$i++) {
        //             // Fetch RTN Data from month
        //             $this->reportv_data->select('tbt_com_name, customer_code,customer_name,ven_product_code,tbt_product_group,ven_eng_desc,exp_name,exp_entry,exp_date,exp_declare_line,SUM(quantity) as sumrtnquantity,uop,tbt_product_code');
        //             $this->reportv_data->where("MONTH(exp_date) =", $i);
        //             $this->reportv_data->where("YEAR(exp_date) =", $inputYear); // Assuming
        //             $this->reportv_data->where("customer_code", $inputCust);
        //             $this->reportv_data->where("ven_product_code",$trim_custpart);
        //             // $v_data = $this->reportv_data->get()->getResult();
        //             $v_data = $this->reportv_data->get()->getRow();
        //             //End Fetch RTN Data from month

        //             // Fetch ng data
        //             $this->ng_from_sale->select('ng_year,ng_month,ng_day,customer_code,ng_part,ng_quantity');                       
        //             $this->ng_from_sale->where("customer_code",trim($inputCust));
        //             $this->ng_from_sale->where("ng_part",$trim_custpart);
        //             $this->ng_from_sale->where("ng_month",$i );
        //             $ng_amt = $this->ng_from_sale->get()->getRow();                  
        //             if($ng_amt!=NULL) {
        //                 if($month==1){
        //                     $sale_amt=$sale_amt1;
        //                     $sale_amt1=$sale_amt1-$ng_amt->ng_quantity;
        //                 }else if($month==2) {
        //                     $sale_amt=$sale_amt2;
        //                     $sale_amt2=$sale_amt2-$ng_amt->ng_quantity;
        //                 }else if($month==3) {
        //                     $sale_amt=$sale_amt3;
        //                     $sale_amt3=$sale_amt3-$ng_amt->ng_quantity;
        //                 }else if($month==4) {
        //                     $sale_amt=$sale_amt4;
        //                     $sale_amt4=$sale_amt4-$ng_amt->ng_quantity;
        //                 }else if($month==5) {
        //                     $sale_amt=$sale_amt5;
        //                     $sale_amt5=$sale_amt5-$ng_amt->ng_quantity;
        //                 }else if($month==6) {
        //                     $sale_amt=$sale_amt6;
        //                     $sale_amt6=$sale_amt6-$ng_amt->ng_quantity;
        //                 }else if($month==7) {
        //                     $sale_amt=$sale_amt7;
        //                     $sale_amt7=$sale_amt7-$ng_amt->ng_quantity;
        //                 }else if($month==8) {
        //                     $sale_amt=$sale_amt8;
        //                     $sale_amt8=$sale_amt8-$ng_amt->ng_quantity;
        //                 }else if($month==9) {
        //                     $sale_amt=$sale_amt9;
        //                     $sale_amt9=$sale_amt9-$ng_amt->ng_quantity;
        //                 }else if($month==10) {
        //                     $sale_amt=$sale_amt10;
        //                     $sale_amt10=$sale_amt10-$ng_amt->ng_quantity;
        //                 }else if($month==11) {
        //                     $sale_amt=$sale_amt11;
        //                     $sale_amt11=$sale_amt11-$ng_amt->ng_quantity;
        //                 }else if($month==12) {
        //                     $sale_amt=$sale_amt12;
        //                     $sale_amt12=$sale_amt12-$ng_amt->ng_quantity;
        //                 }
        //                 // $sale_amt_include_ng = $sale_amt-$ng_amt->ng_quantity;
        //             }


        //             if(empty($v_data) || $v_data->tbt_product_group===NULL) {
        //                 // $rowC = "-";
        //                 // $rowD = "-";
        //                 // $sheet->setCellValue('C' . $row, "-");
        //                 // $sheet->setCellValue('D' . $row, "-");
        //             } else {
                    
        //                 $sheet->setCellValue('C' . $row, $v_data->tbt_product_group);
        //                 $sheet->setCellValue('D' . $row, $v_data->ven_eng_desc);
        //                 $rowC = $v_data->tbt_product_group;
        //                 $rowD = $v_data->ven_eng_desc;
        //                 $sheet->setCellValue($month_array[$i] . $row, $v_data->sumrtnquantity);
        //                 //     var_dump('<pre>',$rowC);
        //                 // die;
                
        //             }


                    
        //         }
        //         $sheet->setCellValue('A' . $row, $run_no);
        //         $sheet->setCellValue('B' . $row, $trim_custpart);
         
        //         $sheet->setCellValue('E' . $row, $balance_amt);

        //         //in excel sale
        //         $sheet->setCellValue($month_array_sale['M1'] . $row, $sale_amt1);
        //         $sheet->setCellValue($month_array_sale['M2'] . $row, $sale_amt2);
        //         $sheet->setCellValue($month_array_sale['M3'] . $row, $sale_amt3);
        //         $sheet->setCellValue($month_array_sale['M4'] . $row, $sale_amt4);
        //         $sheet->setCellValue($month_array_sale['M5'] . $row, $sale_amt5);
        //         $sheet->setCellValue($month_array_sale['M6'] . $row, $sale_amt6);
        //         $sheet->setCellValue($month_array_sale['M7'] . $row, $sale_amt7);
        //         $sheet->setCellValue($month_array_sale['M8'] . $row, $sale_amt8);
        //         $sheet->setCellValue($month_array_sale['M9'] . $row, $sale_amt9);
        //         $sheet->setCellValue($month_array_sale['M10'] . $row,$sale_amt10);
        //         $sheet->setCellValue($month_array_sale['M11'] . $row, $sale_amt11);
        //         $sheet->setCellValue($month_array_sale['M12'] . $row, $sale_amt12);
        //         //in excel sale

         
        //     $row++;
        //     $run_no++;
        // }
        foreach ($mergedData as $newRow) {
            $trim_custpart = trim($newRow['Code']?? $newRow['ven_product_code']);
            if(isset($newRow['PRI_BOICAT'])) {
                $pri_boicat = $newRow['PRI_BOICAT'];
            } else {
                $pri_boicat = 0;
            }

            if(isset($newRow['PRI_CRDATE'])) {
                $rowAH = $newRow['PRI_CRDATE'];
                $rowAI = $newRow['PRI_STATUS'];
            }
           
            $spreadsheet->setActiveSheetIndex(0);
            $sheet = $spreadsheet->getActiveSheet();
            $c = $inputCust;
            $y = $inputYear;
            // Fetch balance data
            $this->balance_stock->select('balance_stock_quantity');
            $this->balance_stock->where("customer_code",trim($inputCust));
            $this->balance_stock->where("ven_product_code",$trim_custpart);
            $this->balance_stock->where("balance_stock_year",$y );
            $balance_amt = $this->balance_stock->get()->getRow();
            if($balance_amt!=NULL) {
                $balance_amt = $balance_amt->balance_stock_quantity;
            } else {
                $balance_amt = 0;
            }
            // End Fetch balance data
            //Fetch data of Sale
            $result_sale = $this->get_srv_sale($c,$trim_custpart,$y);
            if (sizeof($result_sale)<=0) {
                // $sale_amt = 0;
                $sale_amt1=0;
                $sale_amt2=0;
                $sale_amt3=0;
                $sale_amt4=0;
                $sale_amt5=0;
                $sale_amt6=0;
                $sale_amt7=0;
                $sale_amt8=0;
                $sale_amt9=0;
                $sale_amt10=0;
                $sale_amt11=0;
                $sale_amt12=0;
            } else {
                // $sale_amt = $result_sale[0]['M'.$month];
                $sale_amt1=$result_sale[0]['M1'];
                $sale_amt2=$result_sale[0]['M2'];
                $sale_amt3=$result_sale[0]['M3'];
                $sale_amt4=$result_sale[0]['M4'];
                $sale_amt5=$result_sale[0]['M5'];
                $sale_amt6=$result_sale[0]['M6'];
                $sale_amt7=$result_sale[0]['M7'];
                $sale_amt8=$result_sale[0]['M8'];
                $sale_amt9=$result_sale[0]['M9'];
                $sale_amt10=$result_sale[0]['M10'];
                $sale_amt11=$result_sale[0]['M11'];
                $sale_amt12=$result_sale[0]['M12'];
            }
            //End Fetch Data of Sale
            for($i=1;$i<=12;$i++) {
                // Fetch RTN Data from month
                $this->reportv_data->select('tbt_com_name, customer_code,customer_name,ven_product_code,tbt_product_group,ven_eng_desc,exp_name,exp_entry,exp_date,exp_declare_line,SUM(quantity) as sumrtnquantity,uop,tbt_product_code');
                $this->reportv_data->where("MONTH(exp_date) =", $i);
                $this->reportv_data->where("YEAR(exp_date) =", $inputYear); // Assuming
                $this->reportv_data->where("customer_code", $inputCust);
                $this->reportv_data->where("ven_product_code",$trim_custpart);
                // $v_data = $this->reportv_data->get()->getResult();
                $v_data = $this->reportv_data->get()->getRow();
                //End Fetch RTN Data from month

                // Fetch ng data
                $this->ng_from_sale->select('ng_year,ng_month,ng_day,customer_code,ng_part,ng_quantity');                       
                $this->ng_from_sale->where("customer_code",trim($inputCust));
                $this->ng_from_sale->where("ng_part",$trim_custpart);
                $this->ng_from_sale->where("ng_month",$i );
                $ng_amt = $this->ng_from_sale->get()->getRow();                  
                if($ng_amt!=NULL) {
                    if($month==1){
                        $sale_amt=$sale_amt1;
                        $sale_amt1=$sale_amt1-$ng_amt->ng_quantity;
                    }else if($month==2) {
                        $sale_amt=$sale_amt2;
                        $sale_amt2=$sale_amt2-$ng_amt->ng_quantity;
                    }else if($month==3) {
                        $sale_amt=$sale_amt3;
                        $sale_amt3=$sale_amt3-$ng_amt->ng_quantity;
                    }else if($month==4) {
                        $sale_amt=$sale_amt4;
                        $sale_amt4=$sale_amt4-$ng_amt->ng_quantity;
                    }else if($month==5) {
                        $sale_amt=$sale_amt5;
                        $sale_amt5=$sale_amt5-$ng_amt->ng_quantity;
                    }else if($month==6) {
                        $sale_amt=$sale_amt6;
                        $sale_amt6=$sale_amt6-$ng_amt->ng_quantity;
                    }else if($month==7) {
                        $sale_amt=$sale_amt7;
                        $sale_amt7=$sale_amt7-$ng_amt->ng_quantity;
                    }else if($month==8) {
                        $sale_amt=$sale_amt8;
                        $sale_amt8=$sale_amt8-$ng_amt->ng_quantity;
                    }else if($month==9) {
                        $sale_amt=$sale_amt9;
                        $sale_amt9=$sale_amt9-$ng_amt->ng_quantity;
                    }else if($month==10) {
                        $sale_amt=$sale_amt10;
                        $sale_amt10=$sale_amt10-$ng_amt->ng_quantity;
                    }else if($month==11) {
                        $sale_amt=$sale_amt11;
                        $sale_amt11=$sale_amt11-$ng_amt->ng_quantity;
                    }else if($month==12) {
                        $sale_amt=$sale_amt12;
                        $sale_amt12=$sale_amt12-$ng_amt->ng_quantity;
                    }
                    // $sale_amt_include_ng = $sale_amt-$ng_amt->ng_quantity;
                }


                if(empty($v_data) || $v_data->tbt_product_group===NULL) {
                    $productRecord = $this->mastertbt_product->where('product_code', $pri_boicat)->get()->getRow();

                   
                    // $productCache[$trimmedDataH] = $productRecord ? [
                    //     'product_code' => $productRecord->product_code,
                    //     'product_name' => $productRecord->product_name,
                    //     'product_group' => $productRecord->product_group
                    // ] : [
                    //     'product_code' => 'NONE DATA',
                    //     'product_name' => 'NONE DATA',
                    //     'product_group' => 'NONE DATA'
                    // ];
                    // var_dump('<pre>',$productDate);
                    // die;
                    if ($productRecord) {
                        $rowC = $productRecord->product_group;
                        $rowD = $productRecord->product_name;
                    } 
                 
                    // $rowC = "-";
                    // $rowD = "-";
                    // $sheet->setCellValue('C' . $row, "-");
                    // $sheet->setCellValue('D' . $row, "-");
                } else {
                
                    $productDate=$this->get_pricrdate($inputCust,$trim_custpart);
                    $rowC = $v_data->tbt_product_group;
                    $rowD = $v_data->ven_eng_desc;
                    if($productDate) {
                        $rowAH = $productDate[0]['PRI_CRDATE'];
                        $rowAI = $productDate[0]['PRI_STATUS'];
                    }
                    $sheet->setCellValue($month_array[$i] . $row, $v_data->sumrtnquantity);
                    //     var_dump('<pre>',$rowC);
                    // die;
            
                }


                
            }
            $sheet->setCellValue('A' . $row, $run_no);
            $sheet->setCellValue('B' . $row, $trim_custpart);
            // $sheet->setCellValue('C' . $row, $v_data->tbt_product_group);
            // $sheet->setCellValue('D' . $row, $v_data->ven_eng_desc);
            $sheet->setCellValue('C' . $row, $rowC);
            $sheet->setCellValue('D' . $row, $rowD);
            $sheet->setCellValue('E' . $row, $balance_amt);

            //in excel sale
            $sheet->setCellValue($month_array_sale['M1'] . $row, $sale_amt1);
            $sheet->setCellValue($month_array_sale['M2'] . $row, $sale_amt2);
            $sheet->setCellValue($month_array_sale['M3'] . $row, $sale_amt3);
            $sheet->setCellValue($month_array_sale['M4'] . $row, $sale_amt4);
            $sheet->setCellValue($month_array_sale['M5'] . $row, $sale_amt5);
            $sheet->setCellValue($month_array_sale['M6'] . $row, $sale_amt6);
            $sheet->setCellValue($month_array_sale['M7'] . $row, $sale_amt7);
            $sheet->setCellValue($month_array_sale['M8'] . $row, $sale_amt8);
            $sheet->setCellValue($month_array_sale['M9'] . $row, $sale_amt9);
            $sheet->setCellValue($month_array_sale['M10'] . $row,$sale_amt10);
            $sheet->setCellValue($month_array_sale['M11'] . $row, $sale_amt11);
            $sheet->setCellValue($month_array_sale['M12'] . $row, $sale_amt12);
            //in excel sale

            // New insert Pri_CRDate and Status
            $sheet->setCellValue('AH' . $row, $rowAH);
            $sheet->setCellValue('AI' . $row, $rowAI);
            // New insert Pri_CRDate and Status

     
        $row++;
        $run_no++;
     }




        if($v_data2!=NULL) {
            foreach ($v_data2 as $data2) {  
                $spreadsheet->setActiveSheetIndex(1);
                $sheet = $spreadsheet->getActiveSheet();
                $sheet->setCellValue('A' . $row_sheet2, $data2->exp_date);
                $sheet->setCellValue('C' . $row_sheet2, $cust_data->customer_code);
                $sheet->setCellValue('D' . $row_sheet2, $data2->exp_name);
                $sheet->setCellValue('E' . $row_sheet2, $data2->exp_entry);
                $sheet->setCellValue('F' . $row_sheet2, $data2->exp_date);
                $sheet->setCellValue('G' . $row_sheet2, $data2->exp_declare_line);
                $sheet->setCellValue('H' . $row_sheet2, $data2->ven_product_code);
                $sheet->setCellValue('I' . $row_sheet2, $data2->ven_eng_desc);
                $sheet->setCellValue('J' . $row_sheet2, $data2->quantity);
                $row_sheet2++;
            }
        }
           
       
       // Save the modified file
       $modifiedFilePath = 'downloads/'.$cust_data->customer_code.'_Confirm Balance '.$inputYear.'.xlsx';
       $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
       $writer->save($modifiedFilePath);
       // Set the modified file to download
       return $this->response->download($modifiedFilePath, null);
       // Convert the modified Excel file to HTML
       // $htmlContent = $this->convertExcelToHtml($modifiedFilePath);
    }


    public function search_ng_table() {
        // Assuming you are using CodeIgniter or similar framework
        // You might need to adjust this based on your framework's conventions
    
        // Retrieve the date and part parameters from the AJAX request
        $date = $this->request->getPost('date');
        // $part = $this->request->getPost('part');
        $cust = $this->request->getPost('cust');

        
        $input_date = date('Y-m-d', strtotime($date));
        $explode_date = explode("-",$input_date);
        $explode_year = $explode_date[0];
        $explode_month = intval($explode_date[1]);
        $explode_day = intval($explode_date[2]);

        $this->ng_from_sale->select('customer_code,ng_part,ng_quantity,ng_year,ng_month,ng_day');

        if($cust!="all") {
            $explode_cust = explode("_",$cust);
            $cust_code  = $explode_cust[1];
            $part = trim($explode_cust[0]);

            $this->ng_from_sale->where('customer_code',$cust_code);
            $this->ng_from_sale->where('ng_part',$part);
        } 

        if($date!="") {
            $this->ng_from_sale->where('ng_year',$explode_year);
            $this->ng_from_sale->where('ng_month',$explode_month);
        }

       
        $data_array = array();
        $result_data = $this->ng_from_sale->get()->getResult();

        foreach ($result_data as $data) {
            // $data
            $data_to_push = [
                'ng_date'=> intval($explode_date[2]).'/'.$explode_date[1].'/'.$explode_date[0],
                'ng_customer'=>$data->customer_code,
                'ng_part'=>$data->ng_part,
                'ng_quantity'=>$data->ng_quantity
            ];
            array_push($data_array,$data_to_push);
        }
        // Perform your database query or any other data retrieval logic here
        // For demonstration, let's just echo a simple response
        // var_dump('<pre>',$data_array);
        // die;
        echo json_encode($data_array);
        // Ensure that you exit after sending the response
        exit;
    }

    // function call get sale 
    public function get_srv_sale($cust_code,$ven_product,$year) {
            // Usage in testdata:
            $c = $cust_code;
            $y = $year;
            $v = $ven_product;

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

            try {
                // Load the database library
                // $db_srv = db_connect('default'); // Use the sqlsrv_tbt database configuration
    
                // Check if the database connection is successful
                if ($db_srv->connect()) {
                        echo 'Database connection successful!';
                       
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
                        AND SALINBFIL.INB_CUSTCODE = '$c' AND SALINBFIL.INB_CUSTPART = '$v'
                        GROUP BY SALINBFIL.INB_CUSTCODE, SALINBFIL.INB_CUSTPART";
                        $query = $db_srv->query($sql);
                        $result = $query->getResult('array');
                        // var_dump('<pre>',$sql);
                        // die;
                        return $result;
                }
                else {
                    echo 'Database connection failed!';
                    // Output the database error message for debugging
                    print_r($db_srv->error());
                }
            } catch (\Exception $e) {
                // Handle the exception
                echo 'Error connecting to the database: ' . $e->getMessage();
            }
    }

    //function call get masterpart tbt
    public function get_partmst($cust_code) {
        // Usage in testdata:
        $c = $cust_code;
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

        try {
            // Load the database library
            // $db_srv = db_connect('default'); // Use the sqlsrv_tbt database configuration

            // Check if the database connection is successful
            if ($db_srv->connect()) {
                    echo 'Database connection successful!';
                    $sql = "SELECT [PRI_CSCODE] as CustCode
                    ,[PRI_PARTCODE] as Code
                    ,[PRI_PARTNAME] as Name
                    ,[PRI_NAME]
                    ,[PRI_BOICAT]
                    ,[PRI_STATUS]                                                          
                    ,[PRI_REMARK]
                    ,[PRI_CRDATE]
                FROM [TBT].[dbo].[MSTPRI] 
                WHERE [PRI_STATUS] != 5  AND [PRI_CSCODE] = '$c'
                ORDER BY [PRI_CRDATE] ASC";

                $query = $db_srv->query($sql);
                $result = $query->getResult('array');
                // var_dump('<pre>', $result);
                // die;
                return $result;
            }
            else {
                echo 'Database connection failed!';
                // Output the database error message for debugging
                print_r($db_srv->error());
            }
        } catch (\Exception $e) {
            // Handle the exception
            echo 'Error connecting to the database: ' . $e->getMessage();
        }
    }

    //function call get masterpart tbt
    public function get_pricrdate($cust_code,$product_code) {
        // Usage in testdata:
        $c = $cust_code;
        $p = $product_code;
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

        try {
            // Load the database library
            // $db_srv = db_connect('default'); // Use the sqlsrv_tbt database configuration

            // Check if the database connection is successful
            if ($db_srv->connect()) {
                    echo 'Database connection successful!';
                    $sql = "SELECT [PRI_CSCODE] as CustCode
                    ,[PRI_PARTCODE] as Code
                    ,[PRI_PARTNAME] as Name
                    ,[PRI_NAME]
                    ,[PRI_BOICAT]
                    ,[PRI_STATUS]                                                          
                    ,[PRI_REMARK]
                    ,[PRI_CRDATE]
                FROM [TBT].[dbo].[MSTPRI] 
                WHERE [PRI_CSCODE] = '$c' AND [PRI_PARTCODE] = '$p'
                ";

                $query = $db_srv->query($sql);
                $result = $query->getResult('array');
                // var_dump('<pre>', $result);
                // die;
                return $result;
            }
            else {
                echo 'Database connection failed!';
                // Output the database error message for debugging
                print_r($db_srv->error());
            }
        } catch (\Exception $e) {
            // Handle the exception
            echo 'Error connecting to the database: ' . $e->getMessage();
        }
    }

    protected function convertExcelToHtml($filePath)
    {
        // Load Excel file
        $spreadsheet = IOFactory::load($filePath);
        // Convert Excel to HTML
        $htmlContent = IOFactory::createWriter($spreadsheet, 'Html')->save('php://output');
        return $htmlContent;
    }

  
}