<?php
use mysqli;
namespace App\Action;

use App\Action\DbConfig as configuration;

class DBOperations{
        //the database connection variable
        private $con;

        private $strProductName;

        private $strProductDesc;

        private $strProductCode;

        private $dtmAdded;

        private $dtmDiscontinued;


        //inside constructor
        //we are getting the connection link
        function __construct(){
            $db = new configuration();
            $this->con = $db->connect();
        }


        public function getProductName(): string
        {
            return $this->strProductName;
        }


        public function getProductDesc(): string
        {
            return $this->strProductDesc;
        }

        public function getProductCode(): string
        {
            return $this->strProductDesc;
        }

        public function getdtmAdded(): string
        {
            return $this->dtmAdded;
        }

        public function getdtmDiscontinued(): string
        {
            return $this->dtmDiscontinued;
        }


        /*  The Create Operation
            The function will insert a new product in  database
        */
        public function save_product($strProductName, $strProductDesc, $strProductCode, $dtmAdded, $dtmDiscontinued){

            $strProductDesc = mysqli_real_escape_string($this->con, $strProductDesc);

            if($dtmDiscontinued)
            {
              $stmt = $this->con->prepare("INSERT INTO tblProductData (strProductName, strProductDesc, strProductCode, dtmAdded, dtmDiscontinued) VALUES ('$strProductName', '$strProductDesc', '$strProductCode', '$dtmAdded', '$dtmDiscontinued')");

            }else{
              $stmt = $this->con->prepare("INSERT INTO tblProductData (strProductName, strProductDesc, strProductCode, dtmAdded) VALUES ('$strProductName', '$strProductDesc', '$strProductCode', '$dtmAdded')");
            }

            $stmt->execute();

        }


        public function view_product(){

            $stmt = $this->con->prepare("SELECT * FROM tblProductData");

            if($stmt->execute()){

              $result = $stmt->get_result();


              $mask = "|%5.5s | %20s |\n";

              printf($mask, 'Code', 'Discontinued');
              while ($row = $result->fetch_assoc()) {

                printf($mask, $row['strProductCode'], $row['dtmDiscontinued']);

              }

            }else{
                return false;
            }


        }


}
