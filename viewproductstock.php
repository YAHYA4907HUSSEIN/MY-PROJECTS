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
							<h2>View Product Stock</h2>
					      <form action="" method="post" enctype="multipart/form-data">
					        <table width="855" border="1" class="tftable">
					          <tr>
                                <th width="145" scope="col">Product Name</th>
					            <th width="103" scope="col">Product Code</th>
					            <th width="102" scope="col">Price</th>
                                <th width="92" scope="col">Tax %</th>
					            <th width="118" scope="col">Pakage</th>
					            <th width="120" scope="col">Status</th>                                                         
                                <th width="129" scope="col">Available stocks</th>   
				              </tr>
                              <?php
							  $sql  = "SELECT *  FROM product";
							  $qsql = mysqli_query($connection,$sql);
							  while($rs = mysqli_fetch_array($qsql))
							  {
								$sql1  = "SELECT sum(qty) FROM stock WHERE productid='$rs[productid]'";
							  	$qsql1 = mysqli_query($connection,$sql1);
							  	$rs1 = mysqli_fetch_array($qsql1);
								
								$sql3  = "SELECT  sum(qty)  FROM sales WHERE productid='$rs[productid]'";
								$qsql3 = mysqli_query($connection,$sql3);
								$rs3 = mysqli_fetch_array($qsql3);
								
								$availableqty = $rs1[0] - $rs3[0];
									
					          echo "<tr>
									<td>&nbsp;$rs[productname]</td>
									<td>&nbsp;$rs[productcode]</td>
									<td>&nbsp;Ksh.$rs[productprice]</td>
									<td>&nbsp;$rs[taxamt]</td>
									<td>&nbsp;$rs[qtytype]</td>
									<td>&nbsp;$rs[status]</td>
									<td>&nbsp;$availableqty</td>																		
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