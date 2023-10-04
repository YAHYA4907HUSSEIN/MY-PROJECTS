<?php
include("header.php");
//connect to the database
include("connection.php");
if(isset($_GET[delid]))
{
	//to delete coconuttype records
$sql = "DELETE FROM sugarcanetype where sugarcane_typeid='$_GET[delid]'";
if(!mysqli_query($connection,$sql))
		{
			echo "Error in Delete statement". mysqli_error($connection);
		}
		else if(mysqli_affected_rows($connection) == 1)
		{
			echo "<script>alert('Sugarcane type record deleted successfully..'); </script>";
			
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
							<h2>View Sugar Type	</h2>
					      <form action="" method="post" enctype="multipart/form-data">
					        <table width="865" border="1" class="tftable">
					          <tr>
					            <th width="191" height="29" scope="col">Sugarcane type</th>
					            <th width="199" scope="col">Sugarcane price</th>
					            <th width="168" scope="col">Description</th>
					            <th width="62" scope="col">Image</th>
					            <th width="126" scope="col">Status</th>
					            <th width="168" scope="col">Edit/Delete</th>
				              </tr>
                              <?php
							  $sql  = "SELECT *  FROM sugarcanetype";
							  $qsql = mysqli_query($connection,$sql);
							  while($rs = mysqli_fetch_array($qsql))
							  {
					          echo "<tr>
					            <td>&nbsp;$rs[sugarcane_type]</td>
					            <td>&nbsp;$rs[sugarcaneprice]</td>
					            <td>&nbsp;$rs[sugarcanedescription]</td>
					            <td>&nbsp;<img src='cocimage/$rs[sugarcaneimage]' width='30' height='30'></td>
					            <td>&nbsp;$rs[status]</td>
					            <td>&nbsp;<a href='sugarcanetype.php?editid=$rs[sugarcane_typeid]'>Edit</a>|
								<a href='viewsugarcanetype.php?delid=$rs[sugarcane_typeid]' onclick='return confirmmsg()'>Delete</a></td>
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