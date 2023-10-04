<?php
error_reporting(0);
//connect to the database
include("connection.php");
//to retrieve employee contact no.
$sql1="SELECT * FROM  employee WHERE contact_no='$_GET[mobile]'";
$qsql1 = mysqli_query($connection,$sql1);
if(mysqli_num_rows($qsql1) >= 1)
{
	echo "<strong><font color='red'>Mobile No alreadys exists</font></strong>";
	echo "<input type='hidden' name='varmobile' value='0'>";
}
else
{
	echo "<input type='hidden' name='varmobile' value='1'>";
}
?>