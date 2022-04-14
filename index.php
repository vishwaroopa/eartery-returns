
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap css cdn -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

    <!-- proj Css -->
    <link href="css/style.css" rel='stylesheet' type='text/css' />
    <title>Restaurant Revenue Prediction</title>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #000000;">
            <div class=" container-fluid">
                <a class="navbar-brand text-sm-center" href="/">Eatary Returns</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav ms-auto text-center">
                        <a class="nav-link" href="/">Home</a>
                        <a class="nav-link" href="about-us.php">About Us</a>
                        <a class="nav-link" href="contact-us.php">Contact us</a>
                    </div>
                </div>
            </div>
        </nav>
    </header>

  <?php 
  $file = fopen('csv/test.csv', 'r');
  $city_values = array();
  $restaurant_type = array();
  $i=0;
while (($line = fgetcsv($file)) !== FALSE) {
  //$line is an array of the csv elements
    if($line[2] != "City") {
    $city_values[] = $line[2];
    }       
    if($line[4] != "Type") {
    $restaurant_type[] = $line[4];
    }
    if($i >  5){
        break;
    }
    $i++;
}
//$city_values = array_unique($city_values);
$city_values = array_values($city_values);
$restaurant_type = array_unique($restaurant_type);
$restaurant_type = array_values($restaurant_type);
//print_r($city_values);
fclose($file);
  ?>  
  <script>
   // let cities = <?php echo json_encode($city_values); ?>;
    let cities = new Array('İstanbul', 'Ankara', 'Diyarbakır', 'Tokat', 'Gaziantep',
    'Afyonkarahisar', 'Edirne', 'Kocaeli', 'Bursa', 'İzmir', 'Sakarya',
    'Elazığ', 'Kayseri', 'Eskişehir', 'Şanlıurfa', 'Samsun', 'Adana',
    'Antalya', 'Kastamonu', 'Uşak', 'Muğla', 'Kırklareli', 'Konya',
    'Karabük', 'Tekirdağ', 'Denizli', 'Balıkesir', 'Aydın', 'Amasya',
    'Kütahya', 'Bolu', 'Trabzon', 'Isparta', 'Osmaniye');
    const showCities = (target_id) => {
    let option_str = document.getElementById(target_id);
    option_str.length = 0;
    option_str.options[0] = new Option('Select City', '');
    option_str.selectedIndex = 0;
    for (var i = 0; i < cities.length; i++) {
        option_str.options[option_str.length] = new Option(cities[i], cities[i]);
    }
}
 //let resTypes = <?php echo json_encode($restaurant_type); ?>;
let resTypes = new Array('Food Court', 'In line', 'Mobile', 'Drive Thru');

const showResTyps = (target_id) => {
    let option_str = document.getElementById(target_id);
    option_str.length = 0;
    option_str.options[0] = new Option('Select Restaurant type', '');
    option_str.selectedIndex = 0;
    for (var i = 0; i < resTypes.length; i++) {
        option_str.options[option_str.length] = new Option(resTypes[i], resTypes[i]);
    }
}
let cityTypes = new Array('Big Cities', 'Other');

const showCityTyps = (target_id) => {
    let option_str = document.getElementById(target_id);
    option_str.length = 0;
    option_str.options[0] = new Option('Select location group', '');
    option_str.selectedIndex = 0;
    for (var i = 0; i < cityTypes.length; i++) {
        option_str.options[option_str.length] = new Option(cityTypes[i], cityTypes[i]);
    }
}

function myFunction() {
var restaurant= $("#restaurant :selected").text();
var city= $("#city :selected").text();
var cityTypes= $("#city_group :selected").text();
// Returns successful data submission message when the entered information is stored in database.
var dataString = 'restaurant=' + restaurant + '&city=' + city + '&cityTypes=' + cityTypes;
if (restaurant == '' || city == ''  || cityTypes == '') {
alert("Please Fill All Fields");
} else {
// AJAX code to submit form.
$.ajax({
type: "POST",
url: "predict.php",
data: dataString,
cache: false,
success: function(html) {
    $("#result").show();
$("#result").html("Approximate Annual Revenue is : <b>"+html+"</b>");
}
});
}
return false;
}
  </script>
<section class="banner">
    <h1 class="text-center pt-4">Forecasting Eatery Returns</h1>
    <div>
        <form method="post" class="main-form">
            <div class="fcontainer">
                <div class="form-group">
                    <label for="formGroupExampleInput2">Location</label>
                    <select class="form-select" aria-label="Default select example" id="city" name="city" required>
                        <script>
                            showCities("city")
                        </script>
                    </select>
                </div>
                <div class="form-group fg1 gap-2">
                    <label for="formGroupExampleInput">Location Group</label>
                    <select class="form-select" aria-label="Default select example" id="city_group" name="city_group" required>
                        required>
                        <script>
                            showCityTyps("city_group")
                        </script>
                    </select>
                </div>
                 <div class="form-group fg1 gap-2">
                    <label for="formGroupExampleInput">Restaurant</label>
                    <select class="form-select" aria-label="Default select example" id="restaurant" name="restaurant"
                        required>
                        <script>
                            showResTyps("restaurant")
                        </script>
                    </select>
                </div>
                <div class="form-group mt-4">
                    <button type="button" onclick="myFunction()" class="btn btn-dark btn-lg"><b>Predict</b></button>
                </div>
            </div>
        </form>
        
        <div class="end">
            <form action="?" method="get" class="subm">
                <button type="submit" class="btn btn-warning">Refresh</button>
            </form>
            <div id="result" class="result">
                
            </div>
        </div>
    </div>
</section>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" >
        </script>
</body>

</html>