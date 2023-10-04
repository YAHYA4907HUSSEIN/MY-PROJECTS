<?php
include("header.php");
//connect to the database
include("connection.php");
if(!isset($_SESSION[adminid]))
{
	//Redirect to account page if the employee loged in is not admin
	header("Location: account.php");	
}
if(isset($_GET[delid]))
{
	//to delete employee records
	$sql = "DELETE FROM employee where empid='$_GET[delid]'";
		if(!mysqli_query($connection,$sql))
		{
			echo "error in insert statement". mysqli_error($connection);
		}
		else if(mysqli_affected_rows($connection) == 1)
		{
			echo "<script>alert('Employee record deleted successfully..'); </script>";
			
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
							<h2>View Employee</h2>
					      <form action="" method="post" enctype="multipart/form-data">
                          <div style='overflow:auto; width:850px;' class="tftable"> 
					        <table width="1382" border="1">
					          <tr>
					            <th width="147" scope="col">Employee Name</th>
					            <th width="129" scope="col">Employee Gender</th>
					            <th width="129" scope="col">Employee Type</th>
					            <th width="96" scope="col">Login Id</th>
					            <th width="94" scope="col">Password</th>
					            <th width="123" scope="col">Designation</th>
					            <th width="78" scope="col">Email Id</th>
                                <th width="78" scope="col">Salary Type</th>
					            <th width="78" scope="col">Salary</th>
					            <th width="139" scope="col">Address</th>
					            <th width="120" scope="col">Contact No</th>
					            <th width="83" scope="col">Status</th>
					            <th width="90" scope="col">Edit/Delete</th>
				              </tr>
					          <?php
							  //Pagination code logic
								$rec_limit = 10;
								$sql  = "SELECT *  FROM employee";
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
								
							  $sql  = "SELECT *  FROM employee";
							  $sql = $sql . " LIMIT $offset, $rec_limit";
								//Pagination code logic ends here
							  $qsql = mysqli_query($connection,$sql);
							  while($rs = mysqli_fetch_array($qsql))
							  {
					          echo "<tr>
					            <td>&nbsp;$rs[empname]</td>
								<td>&nbsp;$rs[gender]</td>
								<td>&nbsp;$rs[emptype]</td>
								<td>&nbsp;$rs[loginid]</td>
								<td>&nbsp;$rs[password]</td>
								<td>&nbsp;$rs[designation]</td>
								<td>&nbsp;$rs[emailid]</td>
								<td>&nbsp;$rs[salarytype]</td>
					            <td>&nbsp;$rs[empsalary]</td>
								<td>&nbsp;$rs[address]</td>
					            <td>&nbsp;$rs[contact_no]</td>
					            <td>&nbsp;$rs[status]</td>
					            <td>&nbsp;
								<a href='employee.php?editid=$rs[empid]'>Edit</a> | 
								<a href='viewemployee.php?delid=$rs[empid]' onclick='return confirmmsg()'>Delete</a>
								</td>
				              </tr>";
							  }
							  ?>
				            </table>
                            </div>
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
								echo "<a href='viewemployee.php?page=$page'>" . $ipage . " </a> | ";
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