<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Models
 *
 * @author Intel
 */
include_once './core/Db.php';
class Models extends Db{
    //put your code here
    public function __construct() {
        parent::__construct();
    }
    /**
     * Connection to database
     * @param type $db
     */
    public function connect($db = NULL) {
        parent::connect($db);
    }
    /**
     * select query with parameters
     * @param type $table
     * @param type $params1
     * @param type $params2
     * @return type
     */
    public static function select($table = NULL, $params1 = NULL, $params2 = NULL) {
        return DB::select($table, $params1, $params2);
    }
    /**
     * truncate data from the table
     * @param type $table
     */
    public static function truncate($table = NULL) {
        Db::truncate($table);
    }
    /**
     * insert data into table
     * @param type $data
     * @param type $table
     */
    public static function insert($data = array(), $table = NULL) {
        Db::insert($data, $table);
    }
}
