<?php
include("header.php");
//connect to the database
include("connection.php");
//to retrieve employee information whpo is logged on
$sql = "SELECT * FROM employee where empid='$_SESSION[empid]'";
$qsql = mysqli_query($connection,$sql);
$rsemp = mysqli_fetch_array($qsql);
?>
	<div id="page-wrapper" class="5grid-layout">
		<div class="row">
			<div id="page-wrapper" style="background color: RED;">
<?php
include("leftsidebar.php");
?>
			<div class="9u mobileUI-main-content">
				<div id="content">
					<section>
						<div class="post">
							<h2 align="center">Account	Panel</h2>
					      <form method="post" action="" enctype="multipart/form-data">
                            <div align="center">
                              <table width="537" height="444" border="1" class="tftable">
                                <tr>
                                  <th height="34" colspan="2" scope="row">Wecome <?php echo $rsemp[empname]; ?></th>
                                </tr>
                                <tr>
                                  <th height="34" scope="row">Date</th>
                                  <td>&nbsp; <?php echo $dt; ?></td>
                                </tr>
                                <tr>
                                  <th height="34" scope="row">Sugarcane Available In Stock</th>
                                  <td>&nbsp;
                                  <?php
								$sql1  = "SELECT sum(qty) FROM purchase";
								$qsql1 = mysqli_query($connection,$sql1);
								$rs1 = mysqli_fetch_array($qsql1);
							
								$sql3  = "SELECT  sum(godownstkkg)  FROM production ";
								$qsql3 = mysqli_query($connection,$sql3);
								$rs3 = mysqli_fetch_array($qsql3);
		
								$stockqty = $rs1[0] - $rs3[0];
								echo $stockqty ." KG";
								?></td>
                                </tr>
                                <tr>
                                  <th width="212" height="34" scope="row">Number of Employees</th>
                                  <td width="290">&nbsp;
                                    <?php
									$sql = "SELECT * FROM employee";
									$qsql = mysqli_query($connection,$sql);
									echo mysqli_num_rows($qsql);
									?>
                                  </td>
                                </tr>
                                <tr>
                                  <th height="31" scope="row">Number of Customers</th>
                                  <td>&nbsp;
                                    <?php
									$sql = "SELECT * FROM customer where status='Active'";
									$qsql = mysqli_query($connection,$sql);
									echo mysqli_num_rows($qsql);
									?></td>
                                </tr>
                                <tr>
                                  <th height="30" scope="row">Number of Seller</th>
                                  <td>&nbsp;
                                    <?php
									$sql = "SELECT * FROM seller where status='Active'";
									$qsql = mysqli_query($connection,$sql);
									echo mysqli_num_rows($qsql);
									?></td>
                                </tr>
                                <tr>
                                  <th height="32" scope="row">Number of Products</th>
                                  <td>&nbsp;
                                    <?php
									$sql = "SELECT * FROM product where status='Active'";
									$qsql = mysqli_query($connection,$sql);
									echo mysqli_num_rows($qsql);
									?></td>
                                </tr>
                                <tr>
                                  <th height="28" scope="row">Number of Sugarcane Type</th>
                                  <td>&nbsp;
                                    <?php
									$sql = "SELECT * FROM sugarcanetype where status='Active'";
									$qsql = mysqli_query($connection,$sql);
									echo mysqli_num_rows($qsql);
									?></td>
                                </tr>
                                <tr>
                                  <th height="31" scope="row">Number of Sales</th>
                                  <td>&nbsp;
                                    <?php
									$sql  = "SELECT *  FROM billing where date ='$dt' AND customerid!=0 "; 
									$qsql = mysqli_query($connection,$sql);
									echo mysqli_num_rows($qsql);
									  ?></td>
                                </tr>
                                <tr>
                                  <th height="31" scope="row">Number of Purchase</th>
                                  <td>&nbsp;
                                  <?php
									$sql  = "SELECT *  FROM billing where date ='$dt' AND sellerid!=0 "; 
									$qsql = mysqli_query($connection,$sql);
									echo mysqli_num_rows($qsql);
									  ?>
                                  </td>
                                </tr>
                                <tr>
                                  <th height="31" scope="row">Total Sales Amount</th>
                                  <td>&nbsp;
                                    <?php
										$sql3  = "SELECT *  FROM  billing INNER JOIN sales ON sales.billingid = billing.billingid where date='$dt' ";
										$qsql3 = mysqli_query($connection,$sql3);
										while($rs3 = mysqli_fetch_array($qsql3))
										{
											$sales= $rs3[qty] * $rs3[totalamt];
											$totalsales = $totalsales + $sales;
											
											$totaltaxamt = ($sales * $rs3[taxamt]/100);
											$totaltaxamt1 = $totaltaxamt1 + $totaltaxamt;
											
											$disount = $disount +  $rs3[discount] ;	
																			
										}
										$grandtotal = $grandtotal+(($totalsales + $totaltaxamt1) - $disount);
										echo "Ksh. $grandtotal";
								   ?>
                                  </td>
                                </tr>
                                <tr>
                                  <th height="31" scope="row">Total Purchase Amount</th>
                                  <td>&nbsp;
                                    <?php
									$sql  = "SELECT *  FROM billing where date ='$dt' AND sellerid!=0 "; 
									$qsql = mysqli_query($connection,$sql);
									while($rs = mysqli_fetch_array($qsql))
									{
										$sql1  = "SELECT qty,price FROM purchase WHERE billingid='$rs[billingid]'";
										$qsql1 = mysqli_query($connection,$sql1);
										while($rs1 = mysqli_fetch_array($qsql1))
										{
											$totqty = $totqty + $rs1[qty];
											$totamt = ($rs1[qty] * $rs1[price]);	
											$grandtot = $grandtot + $totamt;
											
										}
									  }
									echo "Ksh. $grandtot";
									?></td>
                                </tr>
                                <tr>
                                  <th height="33" scope="row"> Total Expenses Amount</th>
                                  <td>&nbsp;
                                  <?php
									$sql ="SELECT SUM(`expenseamt`) FROM  `expenses` where status='Paid' AND date='$dt' "; 
									$qsql = mysqli_query($connection,$sql);
									$rs = mysqli_fetch_array($qsql);
									$total=$rs[0]*1;
									echo "Ksh. $total";
								  ?>
							      </td>
							    </tr>
								  </table>
                            </div>
                                      </form>
                                    </div>
                                    <form id="form1" name="form1" method="post" action="">
                                    <div align="center">
                                      <input name="reset" type="submit" id="reset" value="Reset User Password"  />
                                    </div>
                                    <?php
                                    if(isset($_POST[reset]))
									{
										echo "<script>window.location.assign('resetpass.php');</script>";
									}
									?>
			
                        		</form>
					</section>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
include("footer.php");
?>