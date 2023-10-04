<?php
error_reporting(0);
//connect to the database
include("connection.php");
//to retrieve employee loginid
$sql1="SELECT * FROM  employee WHERE loginid='$_GET[login]'";
$qsql1 = mysqli_query($connection,$sql1);
if($_GET[login] !="")
{
	if(mysqli_num_rows($qsql1) >= 1)
	{
		echo "<strong><font color='red'>Login ID alreadys exists</font></strong>";
		echo "<input type='hidden' name='varlogin' value='0'>";
	}
	else
	{
		echo "<strong><font color='green'>Available</font></strong>";
		echo "<input type='hidden' name='varlogin' value='1'>";
	}
}
else
{
	echo "<input type='hidden' name='varlogin' value='1'>";
}
?>