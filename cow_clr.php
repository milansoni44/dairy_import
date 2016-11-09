<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once './models/Models.php';
$db = new Models();
$conn = $db->connect("master_data");

$res_low = Models::select("config_data","COW","SNF_LOW_LIMIT");
$res_high = Models::select("config_data","COW","SNF_HIGH_LIMIT");

if(mysqli_num_rows($res_low) > 0){
    $row_low = mysqli_fetch_row($res_low);
}

if(mysqli_num_rows($res_high) > 0){
    $row_high = mysqli_fetch_row($res_high);
}

//echo "<pre>";
//print_r($row_low);

$csv_file = "CLR.csv";

$db_up = new Models();
$conn_rate = $db_up->connect("rate_tables");

if (($getfile = fopen($csv_file, "r")) !== FALSE) {
    $fat_low = $row_low[3];
    $fat_high = $row_high[3];
    
    $f_start = $fat_low * 10;
    $f_end = $fat_high * 10;
    Models::truncate("cow_fat_clr");
    while (($data = fgetcsv($getfile, 1000, ",")) !== FALSE) {
        $data1[] = $data;
    }
    for($i = $f_start; $i < $f_end; $i++){
        $clr = $row_low[3];
        for($j = $f_start; $j < count($data1[$i]); $j++){
//            echo "Row $i AND Column $j Value=".$data1[$i][$j];
//            echo "<br>";
            $arr = array(
                "Fat"=>$fat_low,
                "Clr"=>$clr,
                "Rate"=>  (number_format((float)$data1[$i][$j],3,'.','')/100)
            );
            $clr = $clr + 0.1;
//            echo "<pre>";
//            print_r($arr);
            Models::insert($arr,"cow_fat_clr");
        }
        $fat_low = $fat_low + 0.1;
    }
}