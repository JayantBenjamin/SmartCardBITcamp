<?php
////////////////////////////////////// initialise sql variables/////////////////////////////////

$servername = "localhost";
$username = "***********";
$password = "*********";
$dbname = "***********";
////////////Variable list///////////////////////////

///////////////create connnection///////////////////
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) 
{
    die("Connection failed: " . $conn->connect_error);
} 
?>