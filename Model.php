<?php

abstract class Model
{
    protected $db;

    protected $table;

    public function __construct(DBConnector $db)
    {
        $this->db = $db;

        if (!$this->table) {
            $this->table = strtolower(get_class($this));
        }
    }

    public function findAll()
    {
        $sql = "SELECT * FROM {$this->table}";
        $result = $this->db->query($sql);

        $rows = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }

        return $rows;
    }

    public function findById($id)
    {
        $id = $this->db->escape($id);
        $sql = "SELECT * FROM {$this->table} WHERE id = {$id}";
        $result = $this->db->query($sql);

        return mysqli_fetch_assoc($result);
    }

    public function findByFilter($field,$value){
        $field=$this->db->escape($field);
        $value=$this->db->escape($value);
        $sql="SELECT * FROM {$this->table} WHERE {$field}={$value}";
        $result=$this->db->query($sql);
        $rows=[];

        while ($row=mysqli_fetch_assoc($result)){
            $rows[]=$row;
        }

        return $rows;
    }

    public function create($data)
    {
        $keys = array_keys($data);
        $values = array_map([$this->db, 'escape'], array_values($data));

        $sql = "INSERT INTO {$this->table} (" . implode(',', $keys) . ") VALUES ('" . implode("','", $values) . "')";
        $result = $this->db->query($sql);

        return $this->db->getLastInsertedId();
    }

    public function update($id, $data)
    {
        $pairs = [];

        foreach ($data as $key => $value) {
            $pairs[] = "{$key}='{$this->db->escape($value)}'";
        }

        $sql = "UPDATE {$this->table} SET " . implode(',', $pairs) . " WHERE id = {$this->db->escape($id)}";
        $result = $this->db->query($sql);

        return $result;
    }

    public function delete($id)
    {
        $id = $this->db->escape($id);
        $sql = "DELETE FROM {$this->table} WHERE id = {$id}";
        $result = $this->db->query($sql);

        return $result;
    }

    public function getTable()
    {
        return $this->table;
    }

    public function setTable($table)
    {
        $this->table = $table;
    }
}