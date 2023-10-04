<?php
include("header.php");
//connect to the database
include("connection.php");
if(isset($_GET[delid]))
{
	//to delete product records
$sql = "DELETE FROM product where productid='$_GET[delid]'";
if(!mysqli_query($connection,$sql))
		{
			echo "Error in Delete statement". mysqli_error($connection);
		}
		else if(mysqli_affected_rows($connection) == 1)
		{
			echo "<script>alert('Product record deleted successfully..'); </script>";
			
		}
}
?>
	<div id="page-wrapper" class="5grid-layout">
		<div class="row">
<?php
include("leftsidebar.php");
?>
			<div class="9u mobileUI-main-content">
				<div id="content">
					<section>
						<div class="post">
							<h2>View Products</h2>
					      <form action="" method="post" enctype="multipart/form-data">
					        <table width="877" border="1" class="tftable">
					          <tr>
					            <th width="98" height="29" scope="col">Product Name</th>
					            <th width="102" scope="col">Product Code</th>
					            <th width="99" scope="col">Product Image</th>
					            <th width="68" scope="col">Price</th>
                                 <th width="69" scope="col">Tax %</th>
                                
					            <th width="69" scope="col">Quantity</th>
					            <th width="110" scope="col">Discription</th>
					            <th width="75" scope="col">Status</th>
					            <th width="129" scope="col">Edit/Delete</th>
				              </tr>
                              <?php
							  $sql  = "SELECT *  FROM product";
							  $qsql = mysqli_query($connection,$sql);
							  while($rs = mysqli_fetch_array($qsql))
							  {
					          echo "<tr>
					            <td>&nbsp;$rs[productname]</td>
					            <td>&nbsp;$rs[productcode]</td>
								<td>&nbsp;<img src='cocimage/$rs[productimage]' width='20' height='20'></td>
					            <td>&nbsp;$rs[productprice]</td>
								<td>&nbsp;$rs[taxamt]</td>
								<td>&nbsp;$rs[qtytype]</td>
								<td>&nbsp;$rs[productdiscription]</td>
					            <td>&nbsp;$rs[status]</td>
					            <td>&nbsp;<a href='products.php?editid=$rs[productid]'>Edit</a> | <a href='viewproducts.php?delid=$rs[productid]' onclick='return confirmmsg()'>Delete</a></td>
				              </tr>";
							  }
							  ?>
				            </table>
					      </form>
						</div>
					</section>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
include("footer.php");
?>
<script type="text/javascript">
function confirmmsg()
{
	var connn=confirm("Are you sure");
	if(connn==true)
	{
		return true;
	}
	else
	{
		return false;
	}
}
</script>