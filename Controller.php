<?php

class Controller
{
    private $data;
    private $action;
    private $protectedActions=[
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
    function __construct(){
        $this->action=$_GET['action'];
        $this->data=json_decode(file_get_contents('php://input'),true);
    }
    function run(){
        $res=[];
        if(in_array($this->action,$this->protectedActions)){
            switch ($this->action){
                case 'get_categories':
                    $res=Category::getAll();
                    break;
                case 'get_category':
                    $res=Category::find($_GET['id']);
                    break;
                case 'edit_category':
                    $category=new Category();
                    $category=$this->data;
                    $category->save();
                    break;
                case 'add_category':
                    $category=new Category();
                    $category=$this->data;
                    $category->save();
                    break;
                case 'delete_category':
                    Category::remove($_GET['id']);
                    break;
                case 'get_products':
                    $res=Product::getAll();
                    break;
                case 'get_product':
                    $res=Product::find($_GET['id']);
                    break;
                case 'get_products_by_category':
                    $res=Product::getByCategory($_GET['id']);
                    break;
                case 'add_product':
                    $product=new Product();
                    $product=$this->data;
                    $product->save();
                    break;
                case 'edit_product':
                    $product=new Product();
                    $product=$this->data;
                    $product->save();
                    break;
                case 'delete_product':
                    $res=Product::remove($_GET['id']);
                    break;
                default:
                    $res=['error'=>'This route is incorrect'];
                    break;
            }
            echo json_encode($res);
        }
    }
}
