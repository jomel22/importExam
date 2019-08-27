<?php
require('../vendor/autoload.php');

use App\Action\Actions as Actions;
use App\Action\FHelper as FHelper;

$arguments = $argv;

$action = strtolower($arguments[1]);

$file = $arguments[2];

$action_checker = new Actions();

$fhelper        = new FHelper();

$data = $action_checker->process_action($action, $file);


print $data;

 ?>
