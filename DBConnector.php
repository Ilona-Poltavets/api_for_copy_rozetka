<?php


class DBConnector
{
    private $host;
    private $username;
    private $password;
    private $database;
    private $connection;

    public function __construct($host, $username, $password, $database)
    {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;

        $this->connect();
    }

    public function connect()
    {
        $this->connection = mysqli_connect($this->host, $this->username, $this->password, $this->database);

        if (!$this->connection) {
            die("Ошибка соединения: " . mysqli_connect_error());
        }
    }

    public function query($sql)
    {
        $result = mysqli_query($this->connection, $sql);

        if (!$result) {
            die("Ошибка запроса: " . mysqli_error($this->connection));
        }

        return $result;
    }

    public function escape($value)
    {
        return mysqli_real_escape_string($this->connection, $value);
    }

    public function getLastInsertedId()
    {
        return mysqli_insert_id($this->connection);
    }

    public function close()
    {
        mysqli_close($this->connection);
    }
}