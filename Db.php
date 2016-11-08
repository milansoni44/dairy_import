<?php

class Db {

    public $localhost = "";
    public $user = "";
    public $pass = "";
    public $db = "";
    public $conn = "";
    
    public function __construct() {
        $this->localhost = "localhost";
        $this->user = "root";
        $this->pass = "";
        $this->db = "";
        $this->conn = "";
    }
    public function connect($db = NULL) {
        $this->db = $db;
        $this->conn = mysqli_connect($this->localhost, $this->user, $this->pass, $this->db);
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_errno();
            exit;
        }
        return $this->conn;
    }

    public function select($table = NULL, $params1 = NULL, $params2 = NULL) {
        $sql = "SELECT * FROM $table WHERE config_category = '$params1' AND config_name = '$params2'";
        $result = mysqli_query($this->conn, $sql);
        return $result;
    }

    public function truncate($table = NULL) {
        $sql = "TRUNCATE TABLE $table";
        $result = mysqli_query($this->conn, $sql);
    }

    public function insert($data = array(), $table) {
        if (is_array($data) && !empty($data)) {
            foreach ($data as $k => $v) {
                $keys[] = $k;
                $values[] = $v;
            }
            $k = implode("`,`", $keys);
            $v = implode("','", $values);
            $sql = "INSERT INTO $table (`$k`) VALUES('$v')";
            $result = mysqli_query($this->conn, $sql);
        }
    }
}
