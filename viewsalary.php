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
	//to delete salary records
$sql = "DELETE FROM salary where salaryid='$_GET[delid]'";
if(!mysqli_query($connection,$sql))
		{
			echo "Error in Delete statement". mysqli_error($connection);
		}
		else if(mysqli_affected_rows($connection) == 1)
		{
			echo "<script>alert('Salary record deleted successfully..'); </script>";
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
							<h2>View Salary</h2>
                            <!-- Search Record -->                         
                            <form method="post" action="">
                            <table width="861" border="1" class="tftable">
                            <tr>
                            <th width="155" height="27" scope="row"><strong>&nbsp;Filter</strong></th>
                            <td width="370">
                              <select name="searchreport" id="searchreport" onchange="changereport(this.value)" >
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
                           if($_GET[searchtype] == "Monthly Report")
                            {
								$fdt = date("Y-m-01");
                                $a_date = date("Y-m-d");
                                $tdt = date("Y-m-t", strtotime($a_date));
								$fmonth =  date("Y-m");
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
									$y1 = date("Y", strtotime('-1 years'));
									$y2 = date("Y");
								}
								else
								{
									$fdt = date("Y-04-01");
                                	$a_date = date("Y-03-31", strtotime('+1 years'));
                               		$tdt = date("Y-m-d", strtotime($a_date));
									$y1 = date("Y");
									$y2 = date("Y", strtotime('+1 years'));
								}
                            }
							else if($_GET[searchtype] == "All Records")
							{
								$fdt = date("2010-04-01");
								$tdt = date("Y-m-d");
							}
                            else 
                            {
                                $fdt = date("Y-m-01");
                                $a_date = date("Y-m-d");
                                $tdt = date("Y-m-t", strtotime($a_date));
								$f2month =  date("Y-m");
								echo "<b>Date: ". $fdt . " to " . $tdt . "</b><br />";
                            }
							if($_GET[searchtype] == "Monthly Report" || $_GET[searchtype] == "Yearly Report" || $_GET[searchtype] == "All Records")
							{
                            	echo "<b>Date: ". $fdt . " to " . $tdt . "</b><br />";
							}
                            ?>
                              </td>
                            </tr>
                            <tr>
                              <th height="27" scope="row"><strong>Search By Month &amp; Year:</strong></th>
                              <td><input type="month" onchange="viewsalary(this.value)" max="<?php echo date("Y-m");?>" 
                              min="<?php echo date("2010-01");?>"/></td>
                            </tr>
                            </table>
                            </form>
                            <script type="application/javascript">
                            function changereport(searchtype)
                            {
                            window.location.assign("viewsalary.php?searchtype=" + searchtype);
                            }
                            </script>
                            <!-- Search Record ends here--><br />
					      <form action="" method="post" enctype="multipart/form-data">
					        <div style='overflow:auto; width:850px;'>
					          <table width="1353" border="1" class="tftable">
					            <tr>
					              <th width="146" scope="col">Employee Name</th>
					              <th width="86" scope="col">Salary Type</th>
					              <th width="67" scope="col">Salary Month</th>
					              <th width="86" scope="col">No. Working Days</th>
					              <th width="75" scope="col">Days Worked</th>
					              <th width="101" scope="col">Salary</th>
					              <th width="94" scope="col">Deduction</th>
					              <th width="78" scope="col">Bonus</th>
					              <th width="103" scope="col">Overtime Salary</th>
					              <th width="109" scope="col">Total</th>
					              <th width="84" scope="col">Date</th>
					              <th width="67" scope="col">Status</th>
					              <th width="175" scope="col">View Slip | Edit | Delete</th>
				                </tr>
					            <?php
								//Pagination code logic
								$rec_limit = 10;
								$sql  = "SELECT *  FROM salary ";
								if(isset($_GET[salarydate]))
								{
									$sql = $sql . " where salarymonth='$_GET[salarydate]'";
								}
							   else if($_GET[searchtype] != "All Records")
								{
								if($_GET[searchtype] == "Yearly Report")
								{
									$dt1= $y2. "-01";
									$dt2= $y2. "-02";
									$dt3= $y2. "-03";
									$dt4= $y1. "-04";
									$dt5= $y1. "-05";
									$dt6= $y1. "-06";
									$dt7= $y1. "-07";
									$dt8= $y1. "-08";
									$dt9= $y1. "-09";
									$dt10= $y1. "-10";
									$dt11= $y1. "-11";
									$dt12= $y1. "-12";
									$sql = $sql . " where salarymonth='$dt1' || salarymonth='$dt2' || salarymonth='$dt3' || salarymonth='$dt4' || salarymonth='$dt5' || salarymonth='$dt6' || salarymonth='$dt7' || salarymonth='$dt8' || salarymonth='$dt9' || salarymonth='$dt10' || salarymonth='$dt11' || salarymonth='$dt12'";
								}
								else if($_GET[searchtype]== "Monthly Report")
								{
									$sql = $sql . " where salarymonth='$fmonth'";
								}
								else
								{
									$sql = $sql . " where salarymonth='$f2month'";
								}
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
								
							  $sql  = "SELECT *  FROM salary ";
							    if(isset($_GET[salarydate]))
								{
									$sql = $sql . " where salarymonth='$_GET[salarydate]'";
								}
							   else if($_GET[searchtype] != "All Records")
								{
								if($_GET[searchtype] == "Yearly Report")
								{
									$dt1= $y2. "-01";
									$dt2= $y2. "-02";
									$dt3= $y2. "-03";
									$dt4= $y1. "-04";
									$dt5= $y1. "-05";
									$dt6= $y1. "-06";
									$dt7= $y1. "-07";
									$dt8= $y1. "-08";
									$dt9= $y1. "-09";
									$dt10= $y1. "-10";
									$dt11= $y1. "-11";
									$dt12= $y1. "-12";
									$sql = $sql . " where salarymonth='$dt1' || salarymonth='$dt2' || salarymonth='$dt3' || salarymonth='$dt4' || salarymonth='$dt5' || salarymonth='$dt6' || salarymonth='$dt7' || salarymonth='$dt8' || salarymonth='$dt9' || salarymonth='$dt10' || salarymonth='$dt11' || salarymonth='$dt12'";
								}
								else if($_GET[searchtype]== "Monthly Report")
								{
									$sql = $sql . " where salarymonth='$fmonth'";
								}
								else
								{
									$sql = $sql . " where salarymonth='$f2month'";
								}
								}
						  		$sql = $sql . " LIMIT $offset, $rec_limit";
								//Pagination code logic ends here
							  $qsql = mysqli_query($connection,$sql);
							  while($rs = mysqli_fetch_array($qsql))
							  {
								    $sql1  = "SELECT * FROM employee WHERE empid=$rs[empid]";
							  		$qsql1 = mysqli_query($connection,$sql1);
								 	$rs1 = mysqli_fetch_array($qsql1);
									if($rs1[salarytype] == "Monthly")
									{
										$totalsal = $rs[salary]  + $rs[bonus] + $rs[ot] - $rs[deduction];
									}
									else
									{
										$totalsal = $rs[salary] * $rs[daysworked] + $rs[bonus] + $rs[ot] - $rs[deduction];
									}
					          echo "<tr>
					            <td>&nbsp;$rs1[empname]</td>
								<td>&nbsp;$rs1[salarytype]</td>
								<td>&nbsp;$rs[salarymonth]</td>
					            <td>&nbsp;$rs[noworkingdays]</td>
								<td>&nbsp;$rs[daysworked]</td>
					            <td>&nbsp;$rs[salary]</td>
								<td>&nbsp;$rs[deduction]</td>
					            <td>&nbsp;$rs[bonus]</td>
								<td>&nbsp;$rs[ot]</td>
								<td>&nbsp;$totalsal</td>
								<td>&nbsp;$rs[date]</td>
					            <td>&nbsp;$rs[status]</td>
					            <td>&nbsp;<a href='salaryreport.php?reportid=$rs[salaryid]'>View Slip </a> | 
								<a href='salary.php?editid=$rs[salaryid]'>Edit </a> |
								<a href='viewsalary.php?delid=$rs[salaryid]' onclick='return confirmmsg()'>Delete</a></td>
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
							   echo "<a href='viewsalary.php?page=$page&searchtype=$_GET[searchtype]&salarydate=$_GET[salarydate]'>" . $ipage . " </a> | ";
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
function viewsalary(salarydate)
{
	window.location.href = "viewsalary.php?salarydate="+salarydate;
}
</script>