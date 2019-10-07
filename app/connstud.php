<?php

$serverName= 'localhost';
$userName= 'root';
$password= "" ;
$dbName= 'project';

$const = mysqli_connect($serverName,$userName,$password,$dbName);

if ($const == FALSE) {
	echo "NIJE USPJELA KONEKCIJA";
}