<?php
require_once "Model.php";

class Product extends Model
{
    protected $table = "products";

    public $id;
    public $name;
    public $description;
    public $price;
    public $category_id;
    public $image;
}
