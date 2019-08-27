<?php

namespace App\Action;

class Csv {

    public function readcsv($file) {

      $file_handle = fopen($file, 'r');


      while (!feof($file_handle) ) {

        //skip first line, header
          $line_of_text[] = fgetcsv($file_handle, 1024);


      }
      fclose($file_handle);
      return $line_of_text;

    }

}
?>
