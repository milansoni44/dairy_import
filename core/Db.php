<?php

class Db {
    // define all static variables
    public static $localhost = "";
    public static $user = "";
    public static $pass = "";
    public static $db = "";
    public static $conn = "";
    
    public function __construct() {
        //initialize with data
        self::$localhost = "localhost";
        self::$user = "root";
        self::$pass = "";
        self::$db = "";
        self::$conn = "";
    }
    /**
     * connection to database
     * @param type $db
     * @return type
     */
    public function connect($db = NULL) {
        self::$db = $db;
        self::$conn = mysqli_connect(self::$localhost, self::$user, self::$pass, self::$db);
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_errno();
            exit;
        }
        return self::$conn;
    }
    /**
     * select query
     * @param type $table
     * @param type $params1
     * @param type $params2
     * @return type
     */
    public static function select($table = NULL, $params1 = NULL, $params2 = NULL) {
        $sql = "SELECT * FROM $table WHERE config_category = '$params1' AND config_name = '$params2'";
        $result = mysqli_query(self::$conn, $sql);
        return $result;
    }
    /**
     * truncate data from the table
     * @param type $table
     */
    public static function truncate($table = NULL) {
        $sql = "TRUNCATE TABLE $table";
        $result = mysqli_query(self::$conn, $sql);
    }
    /**
     * insert data to table
     * @param type $data
     * @param type $table
     */
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
