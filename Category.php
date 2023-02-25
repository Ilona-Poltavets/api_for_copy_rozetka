<?php
require_once "Model.php";

class Category extends Model
{
    protected $table = 'categories';

    public $id;
    public $name;
}
