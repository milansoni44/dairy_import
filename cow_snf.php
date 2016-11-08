<?php

include_once("./Db.php");
$db = new Db();
$conn = $db->connect("master_data");
$res_low = $db->select("config_data","COW","SNF_LOW_LIMIT");
$res_high = $db->select("config_data","COW","SNF_HIGH_LIMIT");

if(mysqli_num_rows($res_low) > 0){
    $row_low = mysqli_fetch_row($res_low);
}

if(mysqli_num_rows($res_high) > 0){
    $row_high = mysqli_fetch_row($res_high);
}

// Set path to CSV file
$csvFile = 'SNF.csv';

$db_up = new Db();

$conn_rate = $db_up->connect("rate_tables");
$s = 11;
if (($getfile = fopen($csvFile, "r")) !== FALSE) {
//    $data = fgetcsv($getfile, 1000, ",");
    $fat1 = $row_low[3];
    $fat2 = $row_high[3];
    $fat = $row_low[3];
//    $fat = $row_high[3];
    $db_up->truncate("cow_fat_snf");
    $f_start = $fat1 * 10;
    $f_end = $fat2 * 10;
    $row = 1;
    while (($data = fgetcsv($getfile, 1000, ",")) !== FALSE) {
        $data1[] = $data;
    }
//    echo "<pre>";
//    print_r($data1);
    //!------------------------------------------------!
    //| FOR ALL DATA INSERT -- 08/11/2016 BY MILAN SONI|
    //!------------------------------------------------!
    /*for($i = 0; $i < count($data1); $i++){
        $snf = $row_low[3];
        for($j = 0; $j < count($data1[$i]); $j++){
//            echo "Row $i AND Column $j Value=".$data1[$i][$j];
//            echo "<br>";
            $a = array(
                "Fat"=>$fat1,
                "Snf"=>$snf,
                "Rate"=>$data1[$i][$j]
            );
            $snf = $snf + 0.1;
//            echo "<pre>";
//            print_r($a);
            
        }
        $fat1 = $fat1 + 0.1;
    }
    fclose($getfile);*/
    for($i = $f_start; $i <= $f_end; $i++){
        $snf = $row_low[3];
        for($j = $f_start; $j <= $f_end; $j++){
//            echo "Row $i AND Column $j Value=".$data1[$i][$j];
//            echo "<br>";
//            echo $j;
//            echo "<br>";
            $a = array(
                "Fat"=>$fat1,
                "Snf"=>$snf,
                "Rate"=>  (number_format((float)$data1[$i][$j],3,'.','')/100)
            );
            $snf = $snf + 0.1;
//            echo "<pre>";
//            print_r($a);
            $db_up->insert($a,"cow_fat_snf");
        }
        $fat1 = $fat1 + 0.1;
    }
    fclose($getfile);
}