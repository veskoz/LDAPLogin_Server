<?php

/*
 * Database Constants
 * Make sure you are putting the values according to your database here 
 */

define('DB_HOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'asd');
define('DB_NAME', 'android');

//Connecting to the database
$conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

//checking the successful connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//making an array to store the response
$response = array();

//if there is a post request move ahead 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    //getting the name from request 
    $barcode = $_POST['barcode'];
    $ldap_user = $_POST['ldap_user'];
    $time = $_POST['time'];

    //creating a statement to insert to database 
    $stmt = $conn->prepare("INSERT INTO names (barcode, ldap_user, time) VALUES ('$barcode','$ldap_user','$time')");

    //binding the parameter to statement 
    $stmt->bind_param("ssi", $barcode, $ldap_user, $time);

    //if data inserts successfully
    if ($stmt->execute()) {
        //making success response 
        $response['error'] = false;
        $response['message'] = 'Saved successfully';
        $stmt = $conn ->prepare("UPDATE names SET status = 'OK'");
    } else {
        //if not making failure response 
        $response['error'] = true;
        $response['message'] = $stmt->error;
        $stmt = $conn ->prepare("UPDATE names SET status = '$stmt->error'");
    }
} else {
    $response['error'] = true;
    $response['message'] = "Invalid request";
}

//displaying the data in json format 
echo json_encode($response);
