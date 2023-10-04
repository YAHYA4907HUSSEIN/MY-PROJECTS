<?php
include("header.php");
//connect to the database
include("connection.php");
if(isset($_GET[delid]))
{
	//to delete seller records
$sql = "DELETE FROM seller where sellerid='$_GET[delid]'";
if(!mysqli_query($connection,$sql))
		{
			echo "Error in Delete statement". mysqli_error($connection);
		}
		else if(mysqli_affected_rows($connection) == 1)
		{
			echo "<script>alert('Seller record deleted successfully..'); </script>";
			
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
							<h2>View Seller </h2>
					      <form action="" method="post" enctype="multipart/form-data">
					        <table width="877" border="1" class="tftable">
					          <tr>
					            <th width="131" height="28" scope="col">Seller Name</th>
					            <th width="134" scope="col">Address</th>
					            <th width="119" scope="col">Phone No</th>
					            <th width="117" scope="col">Mob No</th>
					            <th width="187" scope="col">Email Id</th>
					            <th width="62" scope="col">Status</th>
					            <th width="81" scope="col">Edit/Delete</th>
				              </tr>
					          <?php
							  //Pagination code logic
								$rec_limit = 10;
								$sql  = "SELECT *  FROM seller";
								$qsql = mysqli_query($connection,$sql);
								$totalrecords  = mysqli_num_rows($qsql);
							
								if( isset($_GET['page'] ) )
								{
								   $page = $_GET['page'] + 1;
								   $offset = $rec_limit * $page ;
								}
								else
								{
								   $page = 0;
								   $offset = 0;
								}
									 $left_rec = $rec_count - ($page * $rec_limit);
								  	 $lastpage1 =  ($totalrecords/$rec_limit) - 1;
								 	 $lastpage =  intval($lastpage1);
									$totalnumofpages =  $totalrecords/$rec_limit;
									$totalnumofpages = (int)$totalnumofpages;
									
									if($totalrecords%$rec_limit >=1)
									{
										$totalnumofpages = $totalnumofpages+1;
									}
									$firstrecpage = 1;
									$lastrecpage = $totalnumofpages;
									
								if($totalrecords > $rec_limit )
								{
								 $varreminder = $totalrecords%$rec_limit;
								}
								else
								{
									$varreminder= 0;
								}
								
							  $sql  = "SELECT *  FROM seller";
							  $sql = $sql . " LIMIT $offset, $rec_limit";
								//Pagination code logic ends here
							  $qsql = mysqli_query($connection,$sql);
							  while($rs = mysqli_fetch_array($qsql))
							  {
					          echo "<tr>
					            <td>&nbsp;$rs[sellername]</td>
								<td>&nbsp;$rs[address]</td>
					            <td>&nbsp;$rs[phone_no]</td>
								<td>&nbsp;$rs[mobile_no]</td>
					            <td>&nbsp;$rs[email_id]</td>
					            <td>&nbsp;$rs[status]</td>
					            <td>&nbsp;<a href='seller.php?editid=$rs[sellerid]'>Edit</a> |
								<a href='viewseller.php?delid=$rs[sellerid]' onclick='return confirmmsg()'>Delete</a></td>
				              </tr>";
							  }
							  ?>
				            </table>
                            <!-- Pagination code starts here -->
                            <p align="right">
                            <?php
                            for($ipage=1; $ipage<= $totalnumofpages; $ipage++)
							{
								if(!isset($_GET[page]))
								{
									$_GET[page] = -1;
								}
								$page = $ipage - 2; 
								if($page == $_GET[page])
								{
								echo "<font color='blue'>" . $ipage . "</font> | ";
								}
								else
								{
								echo "<a href='viewseller.php?page=$page'>" . $ipage . " </a> | ";
								}
							}
                            ?>
                            </p></strong>
                            <!-- Pagination code ends here --> 
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