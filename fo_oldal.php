<?php
$weather="";
$error="";
$records="";
$lat="";
$lon="";
$pol="";
$SO2="";
$NO2="";
$CO="";
$O3="";
$NO="";
$PM10="";
$PM25="";
$city="";

//Connection with DB

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'szakdolgozat');
$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

//$sql = "select * from air_pollution_db";
//Button Functions

if(isset($_POST['Qyear'])){
  $sql = "select * from air_pollution_db";
  $records = mysqli_query($connection, $sql);      
}

if(isset($_POST['lastDay'])){
  $sql = "select * FROM `air_pollution_db` ORDER BY `Dátum` DESC limit 1";
  $records = mysqli_query($connection, $sql);      
}

//Weather API

  if(array_key_exists('Idojaras', $_POST)){
    if(!$_POST['city']){
      $error = "Kérem adjon meg egy város nevet";
    }
  if($_POST['city']){
    $apiSubmit = file_get_contents("http://api.openweathermap.org/data/2.5/weather?q=".$_POST['city'].
                                    "&APPID=30c75d3c56d7565b2e6d578523ebebd5");
    $weatherArray = json_decode($apiSubmit, true);
    if ($weatherArray['cod'] == 200) {

        $tempCelsius = $weatherArray['main']['temp'] - 273;
        $weather .="<b>".$weatherArray['name'].", ".$weatherArray['sys']['country'].", ".intval($tempCelsius)."&deg;C</b><br>";
        $weather .="<b>Időjárás: </b>" .$weatherArray['weather']['0']['description']. "<br>";
        $weather .="<b>Légnyomás: </b>" .$weatherArray['main']['pressure']."hPA<br>";
        $weather .="<b>Szélerősség: </b>" .$weatherArray['wind']['speed']."meter/sec<br>";
        $weather .="<b>Felhők: </b>" .$weatherArray['clouds']['all']." %<br>";
        date_default_timezone_set('Europe/Budapest');
        $sunrise = $weatherArray['sys']['sunrise'];

        $lat = $weatherArray['coord']['lat'];
        $lon = $weatherArray['coord']['lon'];

        //$weather .= "<b>Napfelkelte: </b>" .date("H:i", $sunrise)."<br>";
        //$weather .= "<b>Pontos idő: </b>" .date("H:i")."<br>";
        //$weather .="<b>lat: </b>" .$weatherArray['coord']['lat']. "<br>";
        //$weather .="<b>lon: </b>" .$weatherArray['coord']['lon']. "<br>";
    } else{
        $error = "Nem sikerült, a város nem található";
    }
  }
  if($lat && $lon){
      $apiXY = file_get_contents("https://api.openweathermap.org/data/2.5/air_pollution?lat=".$lat."&lon=".$lon."&appid=30c75d3c56d7565b2e6d578523ebebd5");
      $weatherArray = json_decode($apiXY, true);
      $pol .="<b>SO<sub>2</sub> : </b>" .$weatherArray['list']['0']['components']['so2']."<br>";
      $pol .="<b>NO<sub>2</sub> : </b>" .$weatherArray['list']['0']['components']['no2']."<br>";
      $pol .="<b>CO : </b>" .$weatherArray['list']['0']['components']['co']."<br>";
      $pol .="<b>O<sub>3</sub> : </b>" .$weatherArray['list']['0']['components']['o3']."<br>";
      $pol .="<b>NO : </b>" .$weatherArray['list']['0']['components']['no']."<br>";
      $pol .="<b>PM<sub>10</sub> : </b>" .$weatherArray['list']['0']['components']['pm10']."<br>";
      $pol .="<b>PM<sub>2,5</sub> : </b>" .$weatherArray['list']['0']['components']['pm2_5']."<br>";  
      //$pol .="<b>NH<sub>3</sub> : </b>" .$weatherArray['list']['0']['components']['nh3']."<br>";

      $SO2 = $weatherArray['list']['0']['components']['so2'];
      $NO2 = $weatherArray['list']['0']['components']['no2'];
      $CO = $weatherArray['list']['0']['components']['co'];
      $O3 = $weatherArray['list']['0']['components']['o3'];
      $NO = $weatherArray['list']['0']['components']['no'];
      $PM10 = $weatherArray['list']['0']['components']['pm10'];
      $PM25 = $weatherArray['list']['0']['components']['pm2_5'];

  }else{
    $error = "Nem sikerült, a város nem található";
  }

  $city = $_POST['city'];
  $sql = "INSERT INTO air_pollution_db_cities (Dat, SO2, NO2, CO, O3, NOO, PM10, PM25, City)
  VALUES (now(), '$SO2', '$NO2', '$CO', '$O3', '$NO', '$PM10', '$PM25', '$city')";

  if ($connection->query($sql) === TRUE) {
    echo "New record created successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $connection->error;
  }
  

    switch ($SO2) {
      case 0:
        $SO2 = "SO2 nincs adat";
        echo $SO2;
        break;
      case $SO2 <= 50:
        $SO2 = "SO2 kiváló";
        echo $SO2;
        break;  
      case $SO2 <= 100:
        $SO2 = "S02 jó";
        echo $SO2;
        break;
      case $SO2 <= 125:
        $SO2 = "S02 megfelelő";
        echo $SO2;
        break;
      case $SO2 <= 200:
        $SO2 = "S02 szennyezett";
        echo $SO2;
        break;          
      case $SO2 > 200:
        $SO2 = "S02 erősen szennyezett";
        echo $SO2;
        break;         
    }
    switch ($NO2) {
      case 0:
        $NO2 = "NO2 nincs adat";
        echo $NO2;
        break;
      case $NO2 <= 34:
        $NO2 = "NO2 kiváló";
        echo $NO2;
        break;  
      case $NO2 <= 68:
        $NO2 = "NO2 jó";
        echo $NO2;
        break;
      case $NO2 <= 85:
        $NO2 = "NO2 megfelelő";
        echo $NO2;
        break;
      case $NO2 <= 130:
        $NO2 = "NO2 szennyezett";
        echo $NO2;
        break;          
      case $NO2 > 130:
        $NO2 = "NO2 erősen szennyezett";
        echo $NO2;
        break;
    }      
    switch ($CO) {
      case 0:
        $CO = "CO nincs adat";
        echo $CO;
        break;
      case $CO <= 2000:
        $CO = "CO kiváló";
        echo $CO;
        break;  
      case $CO <= 4000:
        $CO = "CO jó";
        echo $CO;
        break;
      case $CO <= 5000:
        $CO = "CO megfelelő";
        echo $CO;
        break;
      case $CO <= 10000:
        $CO = "CO szennyezett";
        echo $CO;
        break;          
      case $CO > 10000:
        $CO = "CO erősen szennyezett";
        echo $CO;
        break;              
    }
    switch ($O3) {
      case 0:
        $O3 = "O3 nincs adat";
        echo $O3;
        break;
      case $O3 <= 48:
        $O3 = "O3 kiváló";
        echo $O3;
        break;  
      case $O3 <= 96:
        $O3 = "O3 jó";
        echo $O3;
        break;
      case $O3 <= 120:
        $O3 = "O3 megfelelő";
        echo $O3;
        break;
      case $O3 <= 220:
        $O3 = "O3 szennyezett";
        echo $O3;
        break;          
      case $O3 > 220:
        $O3 = "O3 erősen szennyezett";
        echo $O3;
        break;              
    }
    switch ($NO) {
      case 0:
        $NO = "NO nincs adat";
        echo $NO;
        break;
      case $NO <= 20:
        $NO = "NO kiváló";
        echo $NO;
        break;  
      case $NO <= 40:
        $NO = "NO jó";
        echo $NO;
        break;
      case $NO <= 50:
        $NO = "NO megfelelő";
        echo $NO;
        break;
      case $NO <= 90:
        $NO = "NO szennyezett";
        echo $NO;
        break;          
      case $NO > 90:
        $NO = "NO erősen szennyezett";
        echo $NO;
        break;              
    }
    switch ($PM10) {
      case 0:
        $PM10 = "PM10 nincs adat";
        echo $PM10;
        break;  
      case $PM10 <= 25:
        $PM10 = "PM10 kiváló";
        echo $PM10;
        break;  
      case $PM10 <= 50:
        $PM10 = "PM10 jó";
        echo $PM10;
        break;
      case $PM10 <= 90:
        $PM10 = "PM10 megfelelő";
        echo $PM10;
        break;
      case $PM10 <= 180:
        $PM10 = "PM10 szennyezett";
        echo $PM10;
        break;          
      case $PM10 > 180:
        $PM10 = "PM10 erősen szennyezett";
        echo $PM10;
        break;              
    }
    switch ($PM25) {
      case 0:
        $PM25 = "PM25 nincs adat";
        echo $PM25;
        break;  
      case $PM25 <= 15:
        $PM25 = "PM25 kiváló";
        echo $PM25;
        break;
      case $PM25 <= 30:
        $PM25 = "PM25 jó";
        echo $PM25;
        break;
      case $PM25 <= 55:
        $PM25 = "PM25 megfelelő";
        echo $PM25;
        break;
      case $PM25 <= 110:
        $PM25 = "PM25 szennyezett";
        echo $PM25;
        break;          
      case $PM25 > 110:
        $PM25 = "PM25 erősen szennyezett";
        echo $PM25;
        break;              
    }
      if($NO == "NO erősen szennyezett")
       echo "<br>".$_POST['city']." erősen szennyezett, ne tartózkodjon ott!";
      if($CO == "CO kiváló" || $NO2 == "NO2 kiváló"){
        echo "<br>".$_POST['city']." levegőszintje nem káros";
      }
/*
      $sql = "select * from air_pollution_db_cities";
      $records = mysqli_query($connection, $sql);
      $chart_data = '';
      while($row = mysqli_fetch_array($records)){
        $chart_data .="{Dat:'".$row["Dat"]."',SO2:'".$row["SO2"]."', NO2:'".$row["NO2"]."', CO:'".$row["CO"]."', O3:'".$row["O3"]."',
          NO:'".$row["NOO"]."', PM10:'".$row["PM10"]."', PM25:'".$row["PM25"]."', City:'".$row["City"]."},";
        $chart_data = substr($chart_data, 0, -2);  
      }
*/     


  // NO 90
  // PM2,5 110
  // NO2 130
  // PM10 180
  // SO2 200
  // O3 220
  // CO 10000
  
    }
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Légszennyezettség szakdolgozat</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- Charts -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

    <!--Script for firebase server-->

    <script type="module">
  // Import the functions you need from the SDKs you need
  import { initializeApp } from "https://www.gstatic.com/firebasejs/9.6.7/firebase-app.js";
  import { getAnalytics } from "https://www.gstatic.com/firebasejs/9.6.7/firebase-analytics.js";
  // TODO: Add SDKs for Firebase products that you want to use
  // https://firebase.google.com/docs/web/setup#available-libraries

  // Your web app's Firebase configuration
  // For Firebase JS SDK v7.20.0 and later, measurementId is optional
  const firebaseConfig = {
    apiKey: "AIzaSyAGoWv-6MreNdW_YQ2FQGkLlXtESge9AIc",
    authDomain: "air-pollution-329812.firebaseapp.com",
    projectId: "air-pollution-329812",
    storageBucket: "air-pollution-329812.appspot.com",
    messagingSenderId: "954997376294",
    appId: "1:954997376294:web:144e85a24dcc535ab22de7",
    measurementId: "G-6G6CCBYSDL"
  }; 

  // Initialize Firebase
  const app = initializeApp(firebaseConfig);
  const analytics = getAnalytics(app);
</script>

    <script>/*
          Morris.Bar({
            element: 'chart',
            data:[<?php echo $chart_data; ?>],
            xkey:'dat',
            ykey:['SO2', 'NO2', 'CO', 'O3', 'NO', 'PM10', 'PM25', 'city'],
            labels:['SO2', 'NO2', 'CO', 'O3', 'NO', 'PM10', 'PM25', 'city'],
            hideHover:'auto',
          })*/
    </script>

  <!--CSS-->  

  <style>
    body{
      margin: 0 px;
      padding: 0 px;
      box-sizing: border-box;
      font-family: poppin, 'Times New Roman', Times, serif;
      font-size: large;
      background-image: url(hatter.jpg);
      color: white;
      background-size: cover;
      background-attachment: fixed;
    }
    h1{
      font-weight: 700;
      margin-top: 15px;
    }
    .input{
      width: 350px;
      padding: 5px;
    }
    table, th, td {
      border: 3px solid white;
      border-collapse: collapse;
      text-align: center; 
      vertical-align: middle;
    }

    table.center {
      margin-left: auto; 
      margin-right: auto;    
    }

    .btn{
      background-color: #36486b;
      border: none;
      color: white;
      padding: 15px 32px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      font-size: 16px;
      margin: 4px 2px;
      cursor: pointer;
    }
    
  </style>

  </head>
  <body>
  
    <h1>Légszennyezettségi adatok</h1>
    <table class="center" width="1000" border="5" cellpadding="5" cellspacing="5">
      <colgroup>
        <col span="10" style="background-color: #36486b">
      </colgroup> 
      <tr>
        <th>Levegő minősége</th>
        <th colspan="7">Koncentráció μg/m3 - ban mérve</th>
      </tr>
      <tr>
        <td colspan="1">Mért anyagok</td>
        <td>SO2</td>
        <td>NO2</td>
        <td>CO</td>
        <td>O3</td>
        <td>NO</td>
        <td>PM10</td>
        <td>PM2,5</td>
      </tr>
      <tr>
        <td>Kiváló</td>
        <td>0-50</td>
        <td>0-34</td>
        <td>0-2000</td>
        <td>0-48</td>
        <td>0-20</td>
        <td>0-25</td>
        <td>0-15</td>
      </tr>
      <tr>
        <td>Jó</td>
        <td>50-100</td>
        <td>34-68</td>
        <td>2000-4000</td>
        <td>48-96</td>
        <td>20-40</td>
        <td>25-50</td>
        <td>15-30</td>
      </tr>
      <tr>
        <td>Megfelelő</td>
        <td>100-125</td>
        <td>68-85</td>
        <td>4000-5000</td>
        <td>96-120</td>
        <td>40-50</td>
        <td>50-90</td>
        <td>30-55</td>
      </tr>
      <tr>
        <td>Szennyezett</td>
        <td>125-200</td>
        <td>85-130</td>
        <td>5000-10000</td>
        <td>120-220</td>
        <td>50-90</td>
        <td>90-180</td>
        <td>55-110</td>
      </tr>		
      <tr>
        <td>Erősen szennyezett</td>
        <td>>200</td>
        <td>>130</td>
        <td>>10000</td>
        <td>>220</td>
        <td>>90</td>
        <td>>180</td>
        <td>>110</td>
      </tr>

    <form action = "" method="post">
        <p><label for="city"></label></p>
        <p><input type="text" name="city" id="city" placeholder="Város"></p>
        <button type="submit" name="Idojaras" class="btn" value="Időjárás">Időjárás</button>
        <button type="submit" name="Qyear" class="btn" value="90 napos adatok">Negyed éves adatok</button>
        <button type="submit" name="lastDay" class="btn" value="Utolsó nap">Utolsó nap</button>

        <div class="output mt-3">

        <?php

//Api Answer
    
   
            if ($weather){
            echo    '<div class="alert alert-success" role="alert">
                    '."A város időjárás adatai: <br><br>". $weather.'</div>';
            }
            if ($pol){
              echo  '<div class="alert alert-success" role="alert">
                    '."A város légszennyezettségi adatai: <br><br>". $pol.'</div>';
            }
            if ($error){
            echo    '<div class="alert alert-warning" role="alert">
                    '. $error.'</div>';
            }
       ?>
        </div>

    </form>
    <!-- Creating table, showing the results-->
    <table class="center" width="1000" border="5" cellpadding="5" cellspacing="5">
      <colgroup>
        <col span="10" style="background-color: #36486b">
      </colgroup>  
      <tr>
        <th>Város</th>
        <th>Dátum</th>
        <th>SO2</th>
        <th>NO2</th>
        <th>CO</th>
        <th>O3</th>
        <th>NO</th>
        <th>PM10</th>
        <th>CPM2.5</th>
      </tr>
          <?php
          
            $sql = "select * from air_pollution_db_cities where city = '$city'"; 
            $results = mysqli_query($connection,$sql);
            while($data = mysqli_fetch_assoc($results)){
              
              echo "<tr>";
              echo "<th>".$data['City']."</th>";
              echo "<th>".$data['Dat']."</th>";
              echo "<th>".$data['SO2']. " ug/m3</th>";
              echo "<th>".$data['NO2']." ug/m3</th>";
              echo "<th>".$data['CO']." ug/m3</th>";
              echo "<th>".$data['O3']." ug/m3</th>";
              echo "<th>".$data['NOO']." ug/m3</th>";
              echo "<th>".$data['PM10']." ug/m3</th>";
              echo "<th>".$data['PM25']." ug/m3</th>";
              echo "</tr>";
            
          }
          mysqli_close($connection);
          
          ?>
        
  </body>
</html>