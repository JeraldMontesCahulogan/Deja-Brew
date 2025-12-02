
<?php

//connectiong to database "coffee_db" log in and sign up
$conn = mysqli_connect('localhost','root','','deja_brew') or die('connection failed');

//connection to database "coffee_db" log in and sign up 
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "deja_brew";
$port = "3306";

if(!$con = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname, $port))
{
   die("failed to connect!");
}

?>