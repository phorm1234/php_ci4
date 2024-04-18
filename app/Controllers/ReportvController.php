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

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->mastertbt_customer = $this->db->table('mastertbt_customer');
        $this->mastertbt_product = $this->db->table('mastertbt_product');
        $this->reportv_data = $this->db->table('reportv_data');
    }

    public function reportv() {
     


        $this->mastertbt_customer->select('customer_code,name_tbt');
        $this->mastertbt_customer->where("is_use",1);
        $result = $this->mastertbt_customer->get()->getResult();

        // $data['select_cust']=$result;


        $data = [
            'pageTitle'=>'ReportV',
            'select_cust'=>$result
        ];



        return view('backend/pages/reportv',$data);
    }

    public function genreportv()
    {
        // Get the input date and file
        $inputDate = $this->request->getPost('input_date');
        $uploadedFile = $this->request->getFile('input_icfile');
           // Initialize array_test as an associative array

        // var_dump('<pre>',$inputDate);
        // die;

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

        // Check if a file was uploaded
        if ($uploadedFile && $uploadedFile->isValid()) {
            // Read the Excel file
            $spreadsheet = IOFactory::load($uploadedFile->getTempName());
            $worksheet = $spreadsheet->getActiveSheet();

            // Parse the input date range
            $dateRange = explode(' - ', $inputDate);
            $startDate = date_create_from_format('m/d/Y', $dateRange[0]);
            $endDate = date_create_from_format('m/d/Y', $dateRange[1]);

            // Get the highest row number in column C
            $highestRow = $worksheet->getHighestDataRow('C');
            $monthlyData = [];
            // Iterate over cells in column C from C2 to the last non-empty cell
            for ($row = 2; $row <= $highestRow; $row++) {
                // Get the value of the cell in column C at the current row
                $dataB = $worksheet->getCell('B' . $row)->getValue();
                $dataC = $worksheet->getCell('C' . $row)->getValue();
                $dataD = $worksheet->getCell('D' . $row)->getValue();
                $dataE = $worksheet->getCell('E' . $row)->getValue();
                $dataF = $worksheet->getCell('F' . $row)->getValue();
                $dataG = $worksheet->getCell('G' . $row)->getValue();
                $dataH = $worksheet->getCell('H' . $row)->getValue();
                $dataI = $worksheet->getCell('I' . $row)->getValue();
                $dataJ = $worksheet->getCell('J' . $row)->getValue();
              
                // Parse the date value from column E
                $dateE = date_create_from_format('d/m/Y', $dataE);


                // var_dump('<pre>',$jsonData);
                // die;
        
                if (!empty($dataC)  && $dateE >= $startDate && $dateE <= $endDate ) {

                     // Construct an associative array representing the data for all 12 months
                    $jan_sale=0;
                    $feb_sale=0;
                    $mar_sale=0;
                    $apr_sale=0;
                    $may_sale=0;
                    $jun_sale=0;
                    $jul_sale=0;
                    $aug_sale=0;
                    $sep_sale=0;
                    $oct_sale=0;
                    $nov_sale=0;
                    $dec_sale=0;

                    $jan_rtn=0;
                    $feb_rtn=0;
                    $mar_rtn=0;
                    $apr_rtn=0;
                    $may_rtn=0;
                    $jun_rtn=0;
                    $jul_rtn=0;
                    $aug_rtn=0;
                    $sep_rtn=0;
                    $oct_rtn=0;
                    $nov_rtn=0;
                    $dec_rtn=0;


                    $rowData = [
                        'january_sale' => $jan_sale,
                        'febuary_sale' => $feb_sale,
                        'march_sale' => $mar_sale,
                        'april_sale' => $apr_sale,
                        'may_sale' => $may_sale,
                        'june_sale' => $jun_sale,
                        'july_sale' => $jul_sale,
                        'august_sale' => $aug_sale,
                        'september_sale' => $sep_sale,
                        'october_sale' => $oct_sale,
                        'november_sale' => $nov_sale,
                        'december_sale' => $dec_sale,

                        'january_return' => $jan_rtn,
                        'febuary_return' => $feb_rtn,
                        'march_return' => $mar_rtn,
                        'april_return' => $apr_rtn,
                        'may_return' => $may_rtn,
                        'june_return' => $jun_rtn,
                        'july_return' => $jul_rtn,
                        'august_return' => $aug_rtn,
                        'september_return' => $sep_rtn,
                        'october_return' => $oct_rtn,
                        'november_return' => $nov_rtn,
                        'december_return' => $dec_rtn,
                        // Add data for the remaining months...
                    ];
                    // Push the row data into the monthlyData array
                    $monthlyData[] = $rowData;
                    // Convert the monthlyData array to JSON format
                    $jsonData = json_encode($monthlyData);
                    
                    array_push($array_test['COLUMN_B'], $dataB);
                    array_push($array_test['COLUMN_C'], $dataC);
                    array_push($array_test['COLUMN_D'], $dataD);
                    array_push($array_test['COLUMN_E'], $dataE);
                    array_push($array_test['COLUMN_F'], $dataF);
                    array_push($array_test['COLUMN_G'], $dataG);
                    array_push($array_test['COLUMN_H'], $dataH);
                    $format_I=number_format((float) $dataI, 8, '.', '');
                    array_push($array_test['COLUMN_I'], $format_I);
                    array_push($array_test['COLUMN_J'], $dataJ);
                      // Trim the value of $dataC
                    $trimmedDataC = trim($dataC);
                    // If the cell is not empty, push its value into the array
                    // Query the mastertbt_customer table for records where name_ic matches $trimmedDataC
                    $customerRecord = $this->mastertbt_customer->where('name_ic', $trimmedDataC)->get()->getRow();

                    if ($customerRecord) {
                        $customerData = [
                            'customer_code' => $customerRecord->customer_code,
                            'name_ic' => $customerRecord->name_ic,
                            'name_tbt' => $customerRecord->name_tbt
                        ];
                
                        array_push($array_test['CUSTOMER_DATA'], $customerData);
                    }else{
                        $customerData = [
                            'customer_code' =>'NONE DATA',
                            'name_ic' => 'NONE DATA',
                            'name_tbt' => 'NONE DATA'
                        ];
                        array_push($array_test['CUSTOMER_DATA'], $customerData);
                    }

                    $trimmedDataH = trim($dataH);
                    // If the cell is not empty, push its value into the array
                    // Query the mastertbt_customer table for records where product_name matches $trimmedDataC
                    $productRecord = $this->mastertbt_product->where('product_name', $trimmedDataH)->get()->getRow();

                    if ($productRecord) {
                        $productData = [
                            'product_code' => $productRecord->product_code,
                            'product_name' => $productRecord->product_name,
                            'product_group' => $productRecord->product_group
                        ];
                
                        array_push($array_test['PRODUCT_DATA'], $productData);
                    }else{
                        $productData = [
                            'product_code' =>'NONE DATA',
                            'product_name' => 'NONE DATA',
                            'product_group' => 'NONE DATA'
                        ];
                        array_push($array_test['PRODUCT_DATA'], $productData);
                    }


                    $explode_dateE = explode('/', $dataE);
                    // $startDate = date_create_from_format('m/d/Y', $dateRange[0]);
                    // $endDate = date_create_from_format('m/d/Y', $dateRange[1]);

                    $format_db_date = $explode_dateE[2].'-'.$explode_dateE[1].'-'.$explode_dateE[0];

                    // var_dump('<pre>',$format_db_date);
                    // die;

                    $this->reportv_data->insert([
                                'tbt_com_name' => $dataB,
                                'customer_code' => $customerData['customer_code'],
                                'customer_name' => $customerData['name_tbt'],
                                'ven_product_code' => $dataG,
                                'tbt_product_group' => $productData['product_group'],
                                'ven_eng_desc' => $dataH,
                                'exp_name' => $dataC,
                                'exp_entry' => $dataD,
                                'exp_date' => $format_db_date,
                                'exp_declare_line' => $dataF,
                                'quantity' => $format_I,
                                'uop' => $dataJ,
                                'tbt_product_code' => $productData['product_code'],
                                'summary_json' => $jsonData,
                                'create_by' => 'admin',
                                'modify_by' => 'admin'
                                // Add more columns as needed
                    ]);

                } else {
                    // If an empty cell is encountered, break out of the loop
                    break;
                }
            }
            // Process the data further as needed
        } else {
            // File not uploaded or invalid
            return redirect()->back()->with('error', 'Please upload a valid Excel file.');
        }
        // var_dump('<pre>',$array_test);
        // die;
    }

    public function showreportv() {
             // Get the input date and file
            $inputYear = $this->request->getPost('input_year');
            $inputCust = $this->request->getPost('select_cust');
            // Load the template file
            $templateFile = 'templates/template_boi_result.xls';
            $spreadsheet = IOFactory::load($templateFile);

            // Modify the data in the template file (for example)
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue('B9', 'New Value');

            // Save the modified file
            $modifiedFilePath = 'downloads/modified_template.xlsx';
            $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save($modifiedFilePath);
            // Set the modified file to download
            return $this->response->download($modifiedFilePath, null);
            // Convert the modified Excel file to HTML
            // $htmlContent = $this->convertExcelToHtml($modifiedFilePath);

            // // Fetch customer data
            // $this->mastertbt_customer->select('customer_code, name_tbt');
            // $this->mastertbt_customer->where("is_use", 1);
            // $result = $this->mastertbt_customer->get()->getResult();

            // // Pass necessary data to the view
            // $data = [
            //     'pageTitle' => 'ReportV',
            //     'select_cust' => $result,
            //     'htmlContent' => $htmlContent, // Pass HTML content to view
            // ];

            // // Load the view and pass data to it
            // return view('backend/pages/reportv', $data);

        // Provide a download link for the modified Excel file
        // echo '<a href="download.php?file=' . urlencode($modifiedFilePath) . '">Download Modified Excel</a>';


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
