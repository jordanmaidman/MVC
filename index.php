<?php
include_once('Model.php');
include_once('Controller.php');
include_once('login.php');

session_start();
if (!isset($_SESSION['count'])) {
  $_SESSION['count'] = 0;
} else {
  $_SESSION['count'] = 1;
}
error_reporting(E_ALL);

# use your database connection parameters file here

header('Content-Type: application/json');
// Create connection
$conn = new mysqli($hn, $un, $pw, $db);
// Check connection
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}
# unset($_SESSION['count']);
$controller = new Controller(new Model($conn)); 
$controller->requestHandler($_SERVER, $_GET, $_POST, $_SESSION); 
?>