<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

$servername = "localhost";
$username = "root";
$password = "asd";
$dbname = "android";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM samples";
$result = $conn->query($sql);

echo "SQL: " . $sql . "<br>";
//date use seconds so $row["time"] has to be divided by 1000
if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "id: " . $row["id"] . 
                  " barcode: " . $row["barcode"] . 
                  " time: " . date("F j, Y, g:i a", $row["time"] / 1000) . 
                  " ldap_user: " . $row["ldap_user"] . 
                  "<br>";
    }
} else {
    echo "0 results";
}
$conn->close();
?> 
