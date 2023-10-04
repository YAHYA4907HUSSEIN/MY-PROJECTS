<?php
include("header.php");
include("connection.php");
if(isset($_GET[delid]))
{
	if(isset($_SESSION[adminid]))
	{
	$sql = "DELETE FROM sales where billingid='$_GET[delid]'";
	mysqli_query($connection,$sql);
	$sql = "DELETE FROM billing where billingid='$_GET[delid]'";
	if(!mysqli_query($connection,$sql))
			{
				echo "Error in Delete statement". mysqli_error($connection);
			}
			else if(mysqli_affected_rows($connection) == 1)
			{
				echo "<script>alert('Sales record deleted successfully..'); </script>";
				
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
							<h2>View Sales</h2>
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
                            window.location.assign("viewsales.php?searchtype=" + rpttype);
                            }
                            </script>
                            <br />
                            <!-- Search Record ends here-->
					      <form action="" method="post" enctype="multipart/form-data">
					        <table width="863" border="1" class="tftable">
					          <tr>
					            <th width="60" height="28" scope="col">Bill No.</th>
                                <th width="152" scope="col">Customer</th>
					            <th width="96" scope="col">Date</th>
					            <th width="98" scope="col">Total</th>
					            <th width="85" scope="col">Tax</th>
					            <th width="86" scope="col">Discount</th>
					            <th width="92" scope="col">Grand total</th>                                
					            <th width="142" scope="col">Edit/Delete</th>
				              </tr>
                              <?php
							  	//Pagination code logic
								$rec_limit = 10;
								$sql  = "SELECT *  FROM billing WHERE customerid!='0' ";
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
								
							  $sql  = "SELECT *  FROM billing WHERE customerid!='0' ";
								if($_GET[searchtype] != "All Records")
								{
								$sql = $sql . " and date between '$fdt' and '$tdt'";
								}
							  $sql = $sql . " LIMIT $offset, $rec_limit";

								//Pagination code logic ends here
							  $qsql = mysqli_query($connection,$sql);
							  while($rs = mysqli_fetch_array($qsql))
							  {
								  $grandtotal=$sales=$totalsales=$totaltaxamt=$totaltaxamt1=$disount=0;
								  
								  	$sql1  = "SELECT *  FROM customer WHERE customerid='$rs[customerid]'";
									$qsql1 = mysqli_query($connection,$sql1);
									$rs1 = mysqli_fetch_array($qsql1);
									
									$sql3  = "SELECT *  FROM sales WHERE billingid='$rs[billingid]'";
									$qsql3 = mysqli_query($connection,$sql3);
									while($rs3 = mysqli_fetch_array($qsql3))
									{
										$sales= $rs3[qty] * $rs3[totalamt];
										$totalsales = $totalsales + $sales;
										
										$totaltaxamt = ($sales * $rs3[taxamt]/100);
										$totaltaxamt1 = $totaltaxamt1 + $totaltaxamt;
										
										$disount = $disount +  $rs3[discount] ;									
									}
																		
					          echo "<tr>
					            <td>&nbsp;$rs[billingid]</td>
								<td>&nbsp;$rs1[companyname] - $rs1[customername]</td>
					            <td>&nbsp;$rs[date]</td>
					            <td>&nbsp;Ksh. $totalsales</td> 
					            <td>&nbsp;Ksh. $totaltaxamt1</td>
					            <td>&nbsp;Ksh. $disount</td>
					            <td>&nbsp;Ksh. ";
								echo $grandtotal = ($totalsales + $totaltaxamt1) - $disount;
								echo "</td>
					            <td>&nbsp; <a href='salesreport.php?billid=$rs[billingid]'>View Report</a> |
								<a href='viewsales.php?delid=$rs[billingid]' onclick='return confirmmsg()'>Delete</a></td>		
				              </tr>";
							  }
							  ?>
				            </table><br />
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
								echo "<a href='viewsales.php?page=$page&searchtype=$_GET[searchtype]'>" . $ipage . " </a> | ";
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