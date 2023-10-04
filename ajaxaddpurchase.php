<?php
error_reporting(0);
//connect to the database
include("connection.php");
if($_GET[gettype]=="insert")
{
	//to insert purchase records
	$sql = "INSERT INTO purchase(billingid,sugarcane_typeid,qty,price,status)
	VALUES('0','$_GET[sugarcane_type]','$_GET[qty]','$_GET[sugprice]','Inactive')";
	if(!mysqli_query($connection,$sql))
	{
		echo "Error in insert statement". mysqli_error($connection);
	}
}

if($_GET[gettype]=="delete")
{
	//to delete purchase records
	$sql = "DELETE FROM purchase WHERE purchaseid='$_GET[purchaseid]'";
	if(!mysqli_query($connection,$sql))
	{
		echo "Error in delete statement". mysqli_error($connection);
	}
}
?>
<strong>Records:</strong>
<table width="878" border="1" class="tftable">
<tr>
  <th width="113" height="27" scope="col">Sugarcane type</th>
  <th width="117" scope="col">Price</th>
  <th width="170" scope="col">Quantity in KG</th>
  <th width="133" scope="col">Total</th>
  <th width="139" scope="col">Delete</th>
</tr>
<?php
$sql  = "SELECT *  FROM purchase where billingid='0' AND status='Inactive'";
$qsql = mysqli_query($connection,$sql);
while($rs = mysqli_fetch_array($qsql))
{
	//to retrieve sugarcane type records
	$sql1  = "SELECT *  FROM sugarcanetype where sugarcane_typeid='$rs[sugarcane_typeid]'";
	$qsql1 = mysqli_query($connection,$sql1);
	$rs1 = mysqli_fetch_array($qsql1);
	$totprice = ($rs[price] * $rs[qty]);
	$grandtotal = $grandtotal + $totprice;
	$grandtotal=intval($grandtotal);
echo "<tr>";
echo "<td>&nbsp;$rs1[sugarcane_type]</td>
  <td>&nbsp; Ksh. $rs[sugprice]</td>
  <td>&nbsp;$rs[qty]</td>
  <td>&nbsp; "."Ksh.". $totprice . "</td>" ;
echo "<td>&nbsp;<strong><a href='#' onclick='delrecord(".$rs[purchaseid].")'>Delete</a></strong></td>";
echo "</tr>";
}
?>
<tr>
  <th height="30" colspan="4" scope="col"><div align="right"><strong>Grand total</strong></div></th>
  <th colspan="2" scope="col" ><strong> Ksh. <?php echo $grandtotal; ?> </strong></th>
  </tr>
</table>

<div align="center"><br />
  <?php
if(mysqli_num_rows($qsql) >=1)
{
?>
  <input name="btnsubmit" type="submit" value="Generate Report" />
</div>
<?php
}
?>