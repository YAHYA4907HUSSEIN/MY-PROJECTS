<?php
error_reporting(0);
include("connection.php");
if($_GET[gettype]=="insert")
{
	$sql = "INSERT INTO sales(`billingid`,`productid`,`qty`,`totalamt`,`taxamt`,`discount`,`status`) 
	VALUES('0','$_GET[prodid]','$_GET[qty]','$_GET[productprice]','$_GET[taxpercentage]','$_GET[discountprice]','Pending')";
	if(!mysqli_query($connection,$sql))
	{
		echo "Error in insert statement". mysqli_error($connection);
	}

}
if($_GET[gettype]=="delete")
{
	$sql = "DELETE FROM sales WHERE salesid='$_GET[salesid]'";
	if(!mysqli_query($connection,$sql))
	{
		echo "Error in delete statement". mysqli_error($connection);
	}
}
?>
<strong>Records:</strong>
 <table width="878" border="1" class="tftable">
                            <tr>
                              <th width="127" height="27" scope="col">Product Name</th>
                              <th width="97" scope="col">Product Price</th>
                              <th width="74" scope="col">Tax %</th>
                              <th width="73" scope="col">Quantity</th>
                              <th width="88" scope="col">Total</th>
                              <th width="60" scope="col">Tax</th>
                              <th width="78" scope="col">Discount</th>                              
                              <th width="119" scope="col">Total Price</th>
                              <th width="104" scope="col">Delete</th>
                            </tr>
<?php
  $sqlsales ="SELECT * FROM 	sales where billingid='0' AND status='Pending'";
  $qsqlsales = mysqli_query($connection,$sqlsales);
  while($rssales = mysqli_fetch_array($qsqlsales))
  {
echo "<tr><td>";

      $sql ="SELECT * FROM 	product where productid='$rssales[productid]'";
      $qsql = mysqli_query($connection,$sql);
      $rs = mysqli_fetch_array($qsql);
      echo "$rs[productname]-$rs[qtytype]";				
	  echo "</td>
		  <td>Ksh. $rssales[totalamt]</td>
		  <td>$rssales[taxamt]</td>
		  <td>$rssales[qty]</td>
		  <td>";
		  echo "Ksh.". $total = $rssales[totalamt] * $rssales[qty];
		  echo "</td>
		  <td>";
		 echo "Ksh.".$tax = ($total*$rssales[taxamt])/100;
		  echo "</td>
		  <td>";
		 echo "Ksh.".$rssales[discount];
		  echo "</td><td>";
		  echo "Ksh.". $totalprice = $total + $tax -$rssales[discount];
		  echo "</td>
		  <td><a href='#' onclick='delrecord(".$rssales[salesid] . ")'>Delete</a></td>
		</tr>";
		$grandtotal = $grandtotal + $totalprice;
  }
?>
 <tr>
                              <th height="32" colspan="7" scope="col"><div align="right"><strong>Grand total </strong></div></th>
                              <th colspan="2" scope="col">&nbsp;<?php echo $grandtotal ?></th>
                            </tr>
                            </table>
<div align="center"><br />
   <?php
if(mysqli_num_rows($qsqlsales) >=1)
{
?>
  <input name="btnsubmit" type="submit" value="Generate Report" />
</div>
<?php
}
?>
