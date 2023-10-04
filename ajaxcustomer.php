<?php
error_reporting(0);
include("connection.php");
$sql1="SELECT * FROM  customer WHERE customerid='$_GET[customerid]'";
$qsql1 = mysqli_query($connection,$sql1);
$rs1 = mysqli_fetch_array($qsql1);
echo "&nbsp;";
echo "<br><strong>Company Name:</strong> ". $rs1[companyname];
echo "<br><strong>Address</strong> ".$rs1[address];
echo "<br><strong>Phone No.</strong> ". $rs1[phone_no];
echo "<br><strong>Mobile No.</strong> ". $rs1[mobile_no];
echo "<br><strong>Email Address.</strong> ". $rs1[email_id];
echo "<br>";
echo "&nbsp;";
?>