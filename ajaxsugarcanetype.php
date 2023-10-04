<?php
error_reporting(0);
//connect to the database
include("connection.php");
//to retrieve sugarcanetype records
$sql="SELECT * FROM  `sugarcanetype` WHERE sugarcane_typeid='$_GET[sugarcane_typeid]'";
$qsql = mysqli_query($connection,$sql);
$rs = mysqli_fetch_array($qsql);
$tot = $rs[sugarcaneprice];
echo $tot;
?>