<?php 

include_once("./models/Models.php");
$db = new Models();
$conn = $db->connect("master_data");
$res_low = Models::select("config_data","COW","FAT_LOW_LIMIT");
$res_high = Models::select("config_data","COW","FAT_HIGH_LIMIT");
if(mysqli_num_rows($res_low) > 0){
    $row_low = mysqli_fetch_row($res_low);
}

if(mysqli_num_rows($res_high) > 0){
    $row_high = mysqli_fetch_row($res_high);
}
//echo "<pre>";
//print_r($row_low);exit;
$csv_file = "./CFAT.csv";

$db_up = new Models();
$conn_rate = $db_up->connect("rate_tables");
if (($getfile = fopen($csv_file, "r")) !== FALSE) {
    $data = fgetcsv($getfile, 1000, ",");
    $fat1 = $row_low[3];
    $i = 0;
    Models::truncate("cow_fat");
    while (($data = fgetcsv($getfile, 1000, ",")) !== FALSE) {
        array_push($data, $fat1);
        $result = $data;
        if($i > $row_low[3] && $i <= $row_high[3]){
            $cow_fat_data = array(
                "Fat"=>$i,
                "Rate"=>$result[0]
            );
            Models::insert($cow_fat_data,"cow_fat");
        }
        $i += 0.1;
        $fat1 += 0.1;
    }
}