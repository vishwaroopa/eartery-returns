<?php
// Fetching Values From URL
$city = $_POST['city'];
$restaurant = $_POST['restaurant'];
if($restaurant == "In line") {
    $restaurant = "IL";
}
else if($restaurant == "Food Court") {
    $restaurant = "FC";
}
else if($restaurant == "Mobile") {
    $restaurant = "MB";
}
else  {
    $restaurant = "DT";
}

if (isset($_POST['city'])) {
    $result  = [];
    if (($handle = fopen("csv/test.csv", "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
          if(($data[2] == $city) && ($data[4] == $restaurant)) {
              $id = $data[0];
              break;
          }
          
        }
        fclose($handle);
    }
    if($id != "") {
    if (($handle = fopen("csv/revenue.csv", "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
          if(($data[0] == $id) ) {
              echo $value = $data[1];
              break;
          }
          
        }
        fclose($handle);
    }
}
else {
   echo "No results found"; 
}
}

?>