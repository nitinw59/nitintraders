<?php
$username = "";
$password = "";
$hostname = "localhost";
$dbname= "";

//connection to the database
$dbhandle = mysqli_connect($hostname, $username, $password,$dbname) 
  or die(mysql_error());


  $username = "";
  $password = "";
  $hostname = "localhost";
  $dbname= "";
  
  //connection to the database
  $dbhandle_stockmanager = mysqli_connect($hostname, $username, $password,$dbname) 
    or die(mysql_error());


?>