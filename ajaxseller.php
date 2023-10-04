<?php
error_reporting(0);
//connect to the database
include("connection.php");
//to retrieve seller sellerid
$sql1="SELECT * FROM  seller WHERE sellerid='$_GET[sellerid]'";
$qsql1 = mysqli_query($connection,$sql1);
$rs1 = mysqli_fetch_array($qsql1);
echo "&nbsp;";
echo "<br><strong>Address</strong> ".$rs1[address];
echo "<br><strong>Phone No.</strong> ". $rs1[phone_no];
echo "<br><strong>Mobile No.</strong> ". $rs1[mobile_no];
echo "<br>";
echo "&nbsp;";
?>