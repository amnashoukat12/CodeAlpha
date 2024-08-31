<?php
$host="localhost";
$user="root";
$pass="";
$db="shortlink";

$conection = mysqli_connect($host,$user,$pass,$db) ;
if($conection){

}else{
echo "conection failed";
}
 ?>