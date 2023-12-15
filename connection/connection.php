<?php


class Basedonne {
    public $conn;
    public $servername = "localhost";
    public $username = "root";
    public $password = "";
    public $dbname = "jobeasy";
    public function connection(){
      return  $this->conn = mysqli_connect($this->servername, $this->username, $this->password, $this->dbname);
    }
}

