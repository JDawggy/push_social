<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if(!isset($_SESSION)) { // Starts a session to pass session variables
    session_start(); 
}              

// $conn = mysqli_connect("localhost", "root", "root", "push");

if( $_SERVER["SERVER_NAME"] == "justalex.justjordan.ca") {
    // PRODUCTION - connects to plesk database
    
                        // localhost, database username, password, database name
    $conn = mysqli_connect("localhost", "push", "SuperJaynedog0", "push_social");
} else {
    // DEVELOPMENT/LOCAL - connects to mamp database
    $conn = mysqli_connect("localhost", "root", "root", "push");
}




if( mysqli_connect_errno( $conn ) ){
    echo  "Failed to conntect to MySQL: " . mysqli_connect_error();
}

?>