<?php
use mysqli;
namespace App\Action;

class DbConfig{

        private $con;

        function connect(){

          $servername = "localhost";
          $database = "wrenTest";
          $username = "root";
          $password = "root";

            $this->con = new \mysqli($servername, $username, $password, $database);
            if(mysqli_connect_errno()){
                echo "Failed  to connect " . mysqli_connect_error();
                return null;
            }
            return $this->con;
        }


}

?>
