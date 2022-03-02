<?php

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'szakdolgozat');
$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

$records=mysqli_query($sql, "select * from air_pollution_db");

/*

$username="root";
$pass="";
try {
    $dbh = new PDO('mysql:host=localhost;dbname=szakdolgozat', $username, $pass);
    foreach($dbh->query('SELECT * from air_pollution_db') as $row) {
        print_r($row);
    }
    $dbh = null;
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
/*
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $score;

    if(isset($_POST["score"])){
        $score = $_POST["score"];
    }else{
        die("A pontok nem jottek at");
    }
}

$stmt = $connection->prepare("INSERT INTO `memory` (`score`)
									VALUES (?)");
		
		$stmt->bind_param("s", $score);
		$stmt->execute();


//Kiiratás
$sql_parancs = "SELECT Pontok FROM `memory`";
	$eredmeny = mysqli_query($connection, $sql_parancs);	
		if(!$eredmeny){
			echo mysqli_error($connection);
			exit();
		}

$sql = "SELECT ID, Pontok, FROM Memory";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
    echo "ID: " . $row["id"]. " - Pontjai: " . $row["Pontok"]. "<br>";
}
} else {
    echo "0 results";
}
*/
$conn->close();