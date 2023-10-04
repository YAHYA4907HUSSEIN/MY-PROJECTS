<?php
include("header.php");
//connect to the database
include("connection.php");
if(isset($_GET[delid]))
{
	if(isset($_SESSION[adminid]))
	{
		//to delete stock records
	$sql = "DELETE FROM STOCK where productionid='$_GET[delid]'";
	mysqli_query($connection,$sql);
	$sql = "DELETE FROM production where productionid='$_GET[delid]'";
	if(!mysqli_query($connection,$sql))
			{
				echo "Error in Delete statement". mysqli_error($connection);
			}
			else if(mysqli_affected_rows($connection) == 1)
			{
				echo "<script>alert('Production record deleted successfully..'); </script>";
				
			}
			
	}
	else
	{
		echo "<script>alert('Only Admin can delete the Records..'); </script>";
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
							<h2>View Production	</h2>
                            <!-- Search Record -->                         
                            <form method="post" action="">
                            <table width="861" border="1" class="tftable">
                            <tr>
                            <th width="155" height="27" scope="row">&nbsp;Filter</th>
                            <td width="370">
                              <select name="searchreport" id="searchreport" onchange="changereport(this.value)" >
                                <option value="Daily Report"
                                <?php
                                if($_GET[searchtype] =="Daily Report")
                                {
                                echo "selected";
                                }
                                ?>
                                >Daily Report</option>
                                <option value="Monthly Report"
                                <?php
                                if($_GET[searchtype] =="Monthly Report")
                                {
                                echo "selected";
                                }
                                ?>
                                >Monthly Report</option>
                                <option value="Yearly Report"
                                <?php
                                if($_GET[searchtype] =="Yearly Report")
                                {
                                echo "selected";
                                }
                                ?>
                                >Yearly Report</option>
                                <option value="All Records"
                                <?php
                                if($_GET[searchtype] =="All Records")
                                {
                                echo "selected";
                                }
                                ?>
                                >All Records</option>
                              </select>
                              <?php
                            if($_GET[searchtype] == "Daily Report")
                            {
                                echo "Date: ". $fdt = date("Y-m-d");
								$tdt = date("Y-m-d");
                            }
                            else if($_GET[searchtype] == "Monthly Report")
                            {
                                $fdt = date("Y-m-01");
                                $a_date = date("Y-m-d");
                                $tdt = date("Y-m-t", strtotime($a_date));
                                
                            }
                            else if($_GET[searchtype] == "Yearly Report")
                            {
								$now=date("Y-m-d");
								$end=date("Y-03-31");
								if($now <= $end)
								{
									$fdt = date("Y-04-01", strtotime('-1 years'));
									$a_date = date("Y-03-31");
									$tdt = date("Y-m-d", strtotime($a_date));
								}
								else
								{
									$fdt = date("Y-04-01");
                                	$a_date = date("Y-03-31", strtotime('+1 years'));
                               		$tdt = date("Y-m-d", strtotime($a_date));
								}
                            }
							else if($_GET[searchtype] == "All Records")
							{
								$fdt = date("2010-04-01");
								$tdt = date("Y-m-d");
							}
                            else 
                            {
                                echo "Date: ". $fdt = date("Y-m-d");
								$tdt = date("Y-m-d");
                            }
							if($_GET[searchtype] == "Monthly Report" || $_GET[searchtype] == "Yearly Report" || $_GET[searchtype] == "All Records")
							{
                            	echo "<b>Date: ". $fdt . " to " . $tdt . "</b><br />";
							}
                            ?>
                              </td>
                            </tr>
                            </table>
                            </form>
                            <script type="application/javascript">
                            function changereport(rpttype)
                            {
                            window.location.assign("viewproduction.php?searchtype=" + rpttype);
                            }
                            </script>
                            <br />
                            <!-- Search Record ends here-->
					      <form action="" method="post" enctype="multipart/form-data">
					       <div > <table width="861" border="1" class="tftable">
					          <tr>
					            <th width="93" height="29" scope="col">Sugarcane Used for Production In KG</th>
					            <th width="83" scope="col">Sugarcane Used for Production In No</th>
					            <th width="72" scope="col"> <div align="center">Waste In No</div></th>
					            <th width="76" scope="col">Drypiece In No</th>
					            <th width="84" scope="col">Net Processing In No</th>
					            <th width="91" scope="col">Broken Piece In KG</th>
					            <th width="78" scope="col">Net processing In KG</th>
					            <th width="74" scope="col">Production Date</th>
					            <th width="152" scope="col">Edit/Delete</th>
				              </tr>
                              <?php
							  //Pagination code logic
								$rec_limit = 10;
							    $sql  = "SELECT *  FROM production where status='Active'";
								if($_GET[searchtype] != "All Records")
								{
								$sql = $sql . " and date between '$fdt' and '$tdt'";
								}
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
								
							  $sql  = "SELECT *  FROM production where status='Active'";
								if($_GET[searchtype] != "All Records")
								{
								$sql = $sql . " and date between '$fdt' and '$tdt'";
								}
							  $sql = $sql . " LIMIT $offset, $rec_limit";
								//Pagination code logic ends here
							  $qsql = mysqli_query($connection,$sql);
							  while($rs = mysqli_fetch_array($qsql))
							  {
					          echo "<tr>
								<td>&nbsp;$rs[1]</td>
					            <td>&nbsp;$rs[2]</td>
					            <td>&nbsp;$rs[3]</td>
								<td>&nbsp;$rs[4]</td>
								<td>&nbsp;$rs[5]</td>
								<td>&nbsp;$rs[6]</td>
								<td>&nbsp;$rs[7]</td>
								<td>&nbsp;$rs[8]</td>
					            <td>&nbsp; <a href='productionreport.php?prodnid=$rs[productionid]'>View Report</a> |
								<a href='viewproduction.php?delid=$rs[productionid]' onclick='return confirmmsg()'>Delete</a> </td>
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
								echo "<a href='viewproduction.php?page=$page&searchtype=$_GET[searchtype]'>" . $ipage . " </a> | ";
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