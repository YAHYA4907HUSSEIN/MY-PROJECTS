<?php
error_reporting(0);
include("connection.php");
$sql1="SELECT * FROM  employee WHERE emailid='$_GET[email]'";
$qsql1 = mysqli_query($connection,$sql1);
if(mysqli_num_rows($qsql1) >= 1 && $_GET[email] !="")
{
	echo "<strong><font color='red'>Email ID alreadys exists</font></strong>";
	echo "<input type='hidden' name='varemailid' value='0'>";
}
else
{
	echo "<input type='hidden' name='varemailid' value='1'>";
}
?>