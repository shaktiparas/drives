<?php 
@session_start();
@date_default_timezone_set("UTC");
$host = "localhost";
$user = "amandeep_askLiveUser";
$pass = "riDbP;l!p^V(";
$database = "amandeep_askLiveDB";


$con = mysqli_connect($host, $user, $pass, $database);
mysqli_set_charset($con,"utf8mb4");
if(!$con)
{
  die('Could not connect: ' . mysqli_error());
}

?>
