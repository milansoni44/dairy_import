<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once './models/Models.php';
$db = new Models();
$conn = $db->connect("master_data");

$res_low = Models::select("config_data","BUFFALO","SNF_LOW_LIMIT");
$res_high = Models::select("config_data","BUFFALO","SNF_HIGH_LIMIT");

if(mysqli_num_rows($res_low) > 0){
    $row_low = mysqli_fetch_row($res_low);
}

if(mysqli_num_rows($res_high) > 0){
    $row_high = mysqli_fetch_row($res_high);
}

//echo "<pre>";
//print_r($row_low);

$csvFile = "CLR.csv";