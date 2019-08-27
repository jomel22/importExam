<?php
require('../vendor/autoload.php');

use App\Database\DBOperations as ImportDB;

$stmt = $this->con->prepare("SELECT * FROM tblProductData");
 
$stmt->execute();


 ?>
