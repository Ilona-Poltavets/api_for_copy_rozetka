<?php

class Database
{
    private $link;
    public $error;

    public function connect()
    {
        $this->link=new \mysqli(\Config::$host,\Config::$username,\Config::$pwd,\Config::$dbname);
        if(!$this->error){
            return false;
        }
        $this->runQuery("SET NAMES 'utf-8'");
        return true;
    }

    public function disconnect(){
        $this->link->close();
        unset($this->link);
    }

    public function runQuery($sql){
        if(!$this->link){
            $this->connect();
        }
        $res=$this->link->query($sql);
        if(!$res){
            $this->error=$this->link->error;
        }
        return $res;
    }

    public function getArrFromQuery($sql){
        $res_arr=[];
        $rs=$this->runQuery($sql);
        while($row=$rs->fetch_assoc()){
            $res_arr[]=$row;
        }
        return $res_arr;
    }
}
