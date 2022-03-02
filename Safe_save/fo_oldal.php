<?php

//Connection with DB

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'szakdolgozat');
$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

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

  if(array_key_exists('Idajaras', $_POST)){
    if(!$_POST['city']){
      $error = "Kérem adjon meg egy város nevet";
    }
  if($_POST['city']){
    $apiSubmit = file_get_contents("http://api.openweathermap.org/data/2.5/weather?q=".$_POST['city']."&APPID=30c75d3c56d7565b2e6d578523ebebd5");
    $weatherArray = json_decode($apiSubmit, true);
    if ($weatherArray['cod'] == 200) {

        $tempCelsius = $weatherArray['main']['temp'] - 273;
        $weather .="<b>".$weatherArray['name'].", ".$weatherArray['sys']['country'].", ".intval($tempCelsius)."&deg;C</b><br>";
        $weather .="<b>Időjárás : </b>" .$weatherArray['weather']['0']['description']. "<br>";
        $weather .="<b>Légnyomás : </b>" .$weatherArray['main']['pressure']."hPA<br>";
        $weather .="<b>Szélerősség : </b>" .$weatherArray['wind']['speed']."meter/sec<br>";
        $weather .="<b>Felhők : </b>" .$weatherArray['clouds']['all']." %<br>";
        date_default_timezone_set('Europe/Budapest');
        $sunrise = $weatherArray['sys']['sunrise'];
        $weather .= "<b>Napfelkelte : </b>" .date("g:i", $sunrise)."<br>";
        $weather .= "<b>Pontos idő : </b>" .date("g:i", $sunrise)."<br>";
    } else{
        $error = "Nem sikerült, a város nem található";
    }
  } 
//Air pollution API + Coordinates API    
    /*
    $apiXY = file_get_contents("https://api.openweathermap.org/geo/1.0/direct?q=".$_POST['city']."&limit=1&appid=30c75d3c56d7565b2e6d578523ebebd5");
    $weatherArray = json_decode($apiXY, true);
    if ($weatherArray['cod'] == 200) {
      $weather .="<b>Szélesség : </b>" .$weatherArray['lat']. "<br>";
      $weather .="<b>Hosszúság : </b>" .$weatherArray['lon']. "<br>";
    } 
    $apiXY = file_get_contents("https://api.openweathermap.org/data/2.5/air_pollution?lat=".$_POST['lat']."&lon=".$_POST['lon']."&appid=30c75d3c56d7565b2e6d578523ebebd5");
    $weatherArray = json_decode($apiXY, true);
    if ($weatherArray['cod'] == 200) {
    }  
  } 
/*Air pollution with coordinates
/*https://api.openweathermap.org/data/2.5/air_pollution?lat=50&lon=50&appid=30c75d3c56d7565b2e6d578523ebebd5*/
/*City with coordinates
https://api.openweathermap.org/geo/1.0/direct?q=London&limit=5&appid=30c75d3c56d7565b2e6d578523ebebd5*/
  }
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Légszennyezettség szakdolgozat</title>

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
        <th colspan="6">Koncentráció μg/m3 - ban mérve</th>
      </tr>
      <tr>
        <td colspan="1"></td>
        <td>SO2</td>
        <td>NO2</td>
        <td>CO</td>
        <td>PM10</td>
        <td>O3</td>
        <td>BENZOL</td>
      </tr>
      <tr>
        <td>Kiváló</td>
        <td>0-50</td>
        <td>0-34</td>
        <td>0-2000</td>
        <td>0-60</td>
        <td>0-48</td>
        <td>0-20</td>
      </tr>
      <tr>
        <td>Jó</td>
        <td>50-100</td>
        <td>34-68</td>
        <td>2000-4000</td>
        <td>60-120</td>
        <td>48-96</td>
        <td>20-40</td>
      </tr>
      <tr>
        <td>Megfelelő</td>
        <td>100-125</td>
        <td>68-85</td>
        <td>4000-5000</td>
        <td>120-150</td>
        <td>96-120</td>
        <td>40-50</td>
      </tr>
      <tr>
        <td>Szennyezett</td>
        <td>125-200</td>
        <td>85-130</td>
        <td>5000-10000</td>
        <td>150-300</td>
        <td>120-220</td>       
        <td>50-90</td>
      </tr>		
      <tr>
        <td>Erősen szennyezett</td>
        <td>>200</td>
        <td>>130</td>
        <td>>10000</td>
        <td>>300</td>
        <td>>220</td>
        <td>>90</td>
      </tr>

    <form action = "" method="post">
        <p><label for="city"></label></p>
        <p><input type="text" name="city" id="city" placeholder="Város"></p>
        <button type="submit" name="Idajaras" class="btn" value="Időjárás">Időjárás</button>
        <button type="submit" name="Qyear" class="btn" value="90 napos adatok">Negyed éves adatok</button>
        <button type="submit" name="lastDay" class="btn" value="Utolsó nap">Utolsó nap</button>

        <div class="output mt-3">

        <?php

//Api Answer

            if ($weather){
            echo    '<div class="alert alert-success" role="alert">
                    '. $weather.'</div>';
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
        <th>Dátum</th>
        <th>SO2</th>
        <th>NO2</th>
        <th>CO</th>
        <th>O3</th>
        <th>NOX</th>
        <th>NO</th>
        <th>BENZOL</th>
        <th>PM10</th>
        <th>CPM2.5</th>
      </tr>
          <?php
            while($data = mysqli_fetch_assoc($records)){
              echo "<tr>";
              echo "<th>".$data['Dátum']."</th>";
              echo "<th>".$data['SO2']."</th>";
              echo "<th>".$data['NO2']."</th>";
              echo "<th>".$data['CO']."</th>";
              echo "<th>".$data['O3']."</th>";
              echo "<th>".$data['NOX']."</th>";
              echo "<th>".$data['NO']."</th>";
              echo "<th>".$data['BENZOL']."</th>";
              echo "<th>".$data['PM10']."</th>";
              echo "<th>".$data['CPM2.5']."</th>";
              echo "</tr>";
            }
          ?>
        
  </body>
</html>