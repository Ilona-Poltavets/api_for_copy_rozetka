<?php
require "Database.php";

class Category
{
    protected $tableName = 'categories';

    public $id;
    public $name;

    public function save()
    {
        $propsToImplode = [];
        $class = new \ReflectionClass($this);
        foreach ($class->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
            $propertyName = $property->getName();
            if($property->getName()!='id'){
                $propsToImplode[] = '`' . $propertyName . '`="' . $this->{$propertyName} . '"';
            }
        }
        $setClause = implode(',', $propsToImplode);
        $sqlQuery = '';
        if ($this->id > 0) {
            $sqlQuery = 'UPDATE `' . $this->tableName . '` SET ' . $setClause . ' WHERE id = ' . $this->id;
        } else {
            $sqlQuery = 'INSERT INTO `' . $this->tableName . '` SET ' . $setClause;
        }
        var_dump($sqlQuery);
        return (new Database())->runQuery($sqlQuery);
    }
    public static function find($id){
        $sql='SELECT id,name from categories WHERE id='.$id;
        return (new Database())->getArrFromQuery($sql);
    }
    public static function getAll(){
        $sql='SELECT id,name FROM categories';
        return (new Database())->getArrFromQuery($sql);
    }
    public static function remove($id){
        $sql='DELETE FROM `categories` WHERE id='.$id;
        return (new Database())->runQuery($sql);
    }
}
