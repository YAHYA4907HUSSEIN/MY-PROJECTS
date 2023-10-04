<?php
error_reporting(0);
//connect to the database
include("connection.php");
if($_GET[gettype]=="insert")
{	
	//to insert stock records
	$sql = "INSERT INTO stock(productionid,productid,qty,status) 
	VALUES('0','$_GET[prodid]','$_GET[qty]','Pending')";
	if(!mysqli_query($connection,$sql))
	{
		echo "Error in insert statement". mysqli_error($connection);
	}
}
if($_GET[gettype]=="delete")
{
	//to delete stock records
	$sql = "DELETE FROM stock WHERE stockid='$_GET[stockid]'";
	if(!mysqli_query($connection,$sql))
	{
		echo "Error in delete statement". mysqli_error($connection);
	}
}
?>
<div align="center"><strong>Records:</strong>
  <table width="695" border="1" class="tftable">
    <tr>
      <th width="280" height="25" scope="col">Product Name</th>
      <th width="230" scope="col">Quantity</th>
      <th width="163" scope="col">Delete</th>
     </tr>
  <?php
  //to retrieve stock records
  $sqlstock ="SELECT * FROM 	stock where productionid='0' AND status='Pending'";
  $qsqlstock = mysqli_query($connection,$sqlstock);
  while($rsstock = mysqli_fetch_array($qsqlstock))
  {
	  echo "<tr><td>";
	  //to retrieve product records
      $sql ="SELECT * FROM 	product where productid='$rsstock[productid]'";
      $qsql = mysqli_query($connection,$sql);
      $rs = mysqli_fetch_array($qsql);
      echo "$rs[productname]-$rs[qtytype]";				
	  echo "</td>
		  <td>$rsstock[qty]</td>
		  <td><a href='#' onclick='delrecord(".$rsstock[stockid] . ")'>Delete</a>
		  </td></tr>";
  }
?>
   </table>
  <br />
  <?php
if(mysqli_num_rows($qsqlstock) >=1)
{
?>
  <input name="btnsubmit" type="submit" value="Generate Report" />
<?php
}
?>
</div>
