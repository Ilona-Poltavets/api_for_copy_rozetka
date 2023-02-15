<?php

abstract class Model
{
//    private static PDO $db;
    protected $tableName;
    protected static $db;

    public function __construct()
    {
        try {
            self::$db = new \PDO('mysql:host=' . \Config::$host . ';dbname=' . \Config::$dbname, \Config::$username, \Config::$pwd);
        } catch (\Exception $e) {
            throw new \Exception('Error creating a database connection');
        }
    }

    public function save()
    {
        $class = new \ReflectionClass($this);
        $tableName = "";

        if ($this->tableName != '') {
            $tableName = $this->tableName;
        } else {
            $tableName = strtolower($class->getShortName());
        }

        $propsToImplode = [];

        foreach ($class->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
            $propertyName = $property->getName();
            $propsToImplode[] = '`' . $propertyName . '` = "' . $this->{$propertyName} . '"';
        }

        $setClause = implode(',', $propsToImplode);
        $sqlQuery = '';

        if ($this->id > 0) {
            $sqlQuery = 'UPDATE `' . $tableName . '` SET ' . $setClause . ' WHERE id = ' . $this->id;
        } else {
            $sqlQuery = 'INSERT INTO `' . $tableName . '` SET ' . $setClause;
        }

        var_dump($sqlQuery);
        $result = self::$db->exec($sqlQuery);

        if (self::$db->errorCode()) {
            throw new \Exception(self::$db->errorInfo()[2]);
        }

        return $result;
    }

    public static function morph(array $object)
    {
        $class = new \ReflectionClass(get_called_class());
        $entity = $class->newInstance();

        foreach ($class->getProperties(\ReflectionProperty::IS_PUBLIC) as $prop) {
            if (isset($object[$prop->getName()])) {
                $prop->setValue($entity, $object[$prop->getName()]);
            }
        }

        $entity->initilize();

        return $entity;
    }
}
