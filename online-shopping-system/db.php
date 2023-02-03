<?php

// open the terminal and run this command to get the composer - composer require vlucas/phpdotenv

//autoloader for the composer
require_once realpath(__DIR__ . "/vendor/autoload.php");

use Dotenv\Dotenv; // to use .env library

//load all of the environmental variables
// Looing for .env at the root directory
$dotenv = Dotenv::createUnsafeImmutable(__DIR__);
$dotenv->load(); 

//fix this - hard coded credentials
    // $servername = "localhost";
    // $username = "root";
    // $password = "";
    // $db = "onlineshop";


//retrive env variables
$db_host = getenv("DB_HOST");
$db_name = getenv("DB_NAME");
$db_user = getenv("DB_USER");
$db_password = getenv("DB_PASSWORD");



// Create connection

// $con = mysqli_connect($servername, $username, $password,$db);
$con = mysqli_connect($db_host,$db_user,$db_password,$db_name);
// $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_password);

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Close the connection when you're done
// $con = null; 

?>




