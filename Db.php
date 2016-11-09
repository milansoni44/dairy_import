<?php

class Db {

    public static $localhost = "";
    public static $user = "";
    public static $pass = "";
    public static $db = "";
    public static $conn = "";
    
    public function __construct() {
        self::$localhost = "localhost";
        self::$user = "root";
        self::$pass = "";
        self::$db = "";
        self::$conn = "";
    }
    public function connect($db = NULL) {
        self::$db = $db;
        self::$conn = mysqli_connect(self::$localhost, self::$user, self::$pass, self::$db);
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_errno();
            exit;
        }
        return self::$conn;
    }

    public static function select($table = NULL, $params1 = NULL, $params2 = NULL) {
        $sql = "SELECT * FROM $table WHERE config_category = '$params1' AND config_name = '$params2'";
        $result = mysqli_query(self::$conn, $sql);
        return $result;
    }

    public static function truncate($table = NULL) {
        $sql = "TRUNCATE TABLE $table";
        $result = mysqli_query(self::$conn, $sql);
    }

    public static function insert($data = array(), $table = NULL) {
        if (is_array($data) && !empty($data)) {
            foreach ($data as $k => $v) {
                $keys[] = $k;
                $values[] = $v;
            }
            $k = implode("`,`", $keys);
            $v = implode("','", $values);
            $sql = "INSERT INTO $table (`$k`) VALUES('$v')";
            $result = mysqli_query(self::$conn, $sql);
        }
    }
}
