<?php
namespace App\Action;

use App\Action\Csv as CSVImporter;

use App\Action\FHelper as FHelper;

use App\Action\DBOperations as ImportDB;

class Actions {

  public $total_qty;


  public function process_action($action, $file)
  {
     switch ($action) {
         case 'import':

             $importer = new CSVImporter();

             $fhelper = new FHelper();

             $data = array();

             $less = array();

             $over = array();

             $error = array();

             $csvdata = $importer->readcsv($file);

             $counter = 0;



             $total_qty = 0;

             foreach ($csvdata as $row) {

               $status = true;

               if($counter>0){

               $product_code  = $row[0];

               $product_name  = $row[1];

               $product_desc  = $row[2];

               $product_stock = $row[3];

               $product_cost  = $fhelper->removeCurrency($row[4]);

               $discontinued = $row[5];


                   if(!is_numeric($product_stock) && empty($product_cost) && !empty($product_code))
                   {
                      array_push($error, array('product_code' => $product_code, 'line_number' => $counter + 1));
                     $status = false;
                   }

                   if($product_cost < 5 && $product_stock < 10 && !empty($product_code) && !empty($product_cost)) {

                      array_push($less, array('product_code' => $product_code, 'line_number' => $counter + 1));
                      $status = false;
                   }

                   if($product_cost > 1000 && !empty($product_code)) {

                      array_push($over, array('product_code' => $product_code, 'line_number' => $counter + 1));

                      $status = false;
                   }

                   if($status && !empty($product_code)){

                     $dtmAdded = date('Y-m-d H:i:s');

                     if(strtolower($discontinued)=='yes'){
                       $discontinued = date('Y-m-d H:i:s');
                     }else{
                       $discontinued = '';
                     } 

                     $importdb = new ImportDB();

                     $importdb->save_product($product_name, $product_desc, $product_code, $dtmAdded, $discontinued);

                     $total_qty += 1;

                   }

               }


               $counter +=1;

             }

             $data  = array_merge(array('total_qty' => $total_qty), array('error'=>$error), array('less'=>$less), array('over'=>$over));

             echo "Import Successfully data: " .$data['total_qty']."\n\n";

             echo "Stock Item has less 10 stock and Cost less £5: " .sizeof($data['less'])."\n";

             echo $fhelper->printTable($data['less'])."\n";

             echo "Stock Item Cost over £1000: " .sizeof($data['over'])."\n";

             echo $fhelper->printTable($data['over'])."\n";

             echo "Error Import Data\n";

             echo $fhelper->printTable($data['error']);

             break;

        case 'view':

              $fhelper = new FHelper();

              echo "Stored Data\n";

              $importdb = new ImportDB();

              echo $importdb->view_product();

             break;
         default:

             return "no matching values were sent to the function \n";
             break;
     }
 }

}
?>
