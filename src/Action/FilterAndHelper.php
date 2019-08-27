<?php
namespace App\Action;

use mysqli;

use App\Action\DBOperations as ImportDB;

class FHelper {

  public function removeCurrency($amount) {

    $re = '/[^\d\.\,\s]+/m';

    $subst = '';

    $result = preg_replace($re, $subst, $amount);

    return  $result;
  }


  public function printTable($data){

    $mask = "|%5.5s | %15s|\n";

    printf($mask, 'Code', 'Line Number');

    foreach($data as  $row){
      printf($mask, $row['product_code'], $row['line_number']);
    }

  }

  public function clean_string($data) {

    return mysqli_real_escape_string($data);
  }

}

 ?>
