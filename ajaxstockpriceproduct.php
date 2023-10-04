<?php
error_reporting(0);
//connect to the database
include("connection.php");
//to retrieve product's productid
$sql= "SELECT * FROM  product WHERE productid='$_GET[productid]'";
$qsql = mysqli_query($connection,$sql);
$rs = mysqli_fetch_array($qsql);
$prodprice = $rs[productprice];
$taxamt = $rs[taxamt];

$sql0 = "SELECT *  FROM product WHERE productid='$_GET[productid]'";
$qsql0 = mysqli_query($connection,$sql0);
while($rs0 = mysqli_fetch_array($qsql0))
{
	$sql1  = "SELECT sum(qty) FROM stock WHERE productid='$rs0[productid]'";
	$qsql1 = mysqli_query($connection,$sql1);
	$rs1 = mysqli_fetch_array($qsql1);

	$sql3  = "SELECT  sum(qty)  FROM sales WHERE productid='$rs0[productid]'";
	$qsql3 = mysqli_query($connection,$sql3);
	$rs3 = mysqli_fetch_array($qsql3);
	
	$stockqty = $rs1[0] - $rs3[0];
}
echo $prodprice."{{}}".$taxamt."{{}}".$stockqty;
?>