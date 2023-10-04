<?php
error_reporting(0);
//connect to the database
include("connection.php");
//to retrieve employee empid
$sql1="SELECT * FROM  employee WHERE empid='$_GET[empid]'";
$qsql1 = mysqli_query($connection,$sql1);
$rs1 = mysqli_fetch_array($qsql1);
if($rs1[salarytype] == "Daily")
{
	echo $rs1["empsalary"]."{{}}".$rs1[salarytype];
}
if($rs1[salarytype] == "Monthly")
{	
echo $rs1["empsalary"]."{{}}".$rs1[salarytype];
}
?>