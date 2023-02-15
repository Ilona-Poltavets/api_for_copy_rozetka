<?php
require 'Config.php';
require 'Model.php';
require 'Product.php';
require 'Category.php';

//$category=new Category();
//$category->id=1;
//$category->name="laptop";
//$category->save();
echo json_encode(Category::getAll());
