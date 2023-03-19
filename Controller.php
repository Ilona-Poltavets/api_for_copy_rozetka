<?php
require "DBConnector.php";
require "Config.php";
require "Product.php";
require "Category.php";

class Controller
{
    private $data;
    private $action;
    private $db;
    private $protectedActions = [
        'get_categories',
        'get_category',
        'edit_category',
        'add_category',
        'delete_category',
        'get_products',
        'get_product',
        'add_product',
        'edit_product',
        'delete_product',
        'get_products_by_category',
    ];

    function __construct()
    {
        $this->db = new DBConnector(Config::$host, Config::$username, Config::$pwd, Config::$dbname);
        $this->action = $_GET['action'];
        $this->data = json_decode(file_get_contents('php://input'), true);
    }

    function run()
    {
        $res = [];
        if (in_array($this->action, $this->protectedActions)) {
            switch ($this->action) {
                case 'get_categories':
                    $category = new Category($this->db);
                    $res = $category->findAll();
                    break;
                case 'get_category':
                    $category = new Category($this->db);
                    $res = $category->findById($_GET['id']);
                    break;
                case 'edit_category':
                    $category = new Category($this->db);
                    $data = $this->data;
                    $category->update($_GET['id'], $data);
                    break;
                case 'add_category':
                    $category = new Category($this->db);
                    $data = $this->data;
                    $category->create($data);
                    break;
                case 'delete_category':
                    $category = new Category($this->db);
                    $category->delete($_GET['id']);
                    break;
                case 'get_products':
                    $product = new Product($this->db);
                    $res = $product->findAll();
                    break;
                case 'get_product':
                    $product = new Product($this->db);
                    $res = $product->findById($_GET['id']);
                    break;
                case 'get_products_by_category':
                    $product = new Product($this->db);
                    $res = $product->findByFilter("category_id", $_GET['id']);
                    break;
                case 'add_product':
                    $product = new Product($this->db);
                    $data = $this->data;
//                    foreach ($_POST as $key => $value) {
//                        echo "Field ".htmlspecialchars($key)." is ".htmlspecialchars($value)."<br>";
//                    }
                    $product->create($_POST);
                    break;
                case 'edit_product':
                    $product = new Product($this->db);
                    $data = $this->data;
                    $product->update($_GET['id'], $data);
                    break;
                case 'delete_product':
                    $product = new Product($this->db);
                    $res = $product->delete($_GET['id']);
                    break;
                default:
                    $res = ['error' => 'This route is incorrect'];
                    break;
            }
            echo json_encode($res);
        }
    }
}
