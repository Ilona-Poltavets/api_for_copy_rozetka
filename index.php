<?php
require 'Config.php';
require 'Product.php';
require 'Category.php';
require 'Controller.php';

header("Content-type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Origin, Content-Type, X-AUTH-Token, Authorization");

$input = json_decode(file_get_contents('php://input'), true);

(new Controller())->run();