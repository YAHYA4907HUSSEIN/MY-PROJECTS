<?php
include("header.php");
//connect to the database
include("connection.php");
//to retrieve salary records
	$sql0  = "SELECT *  FROM salary where salaryid='$_GET[reportid]'";
	$qsql0 = mysqli_query($connection,$sql0);
	$rs0 = mysqli_fetch_array($qsql0);
	//to retrieve employee records
	  $sql1  = "SELECT * FROM employee WHERE empid='$rs0[empid]'";
			$qsql1 = mysqli_query($connection,$sql1);
			$rs1 = mysqli_fetch_array($qsql1);
			if($rs1[salarytype] == "Monthly")
			{
				$totalsal = $rs0[salary]  + $rs0[bonus] + $rs0[ot] - $rs0[deduction];
			}
			else
			{
				$totalsal = $rs0[salary] * $rs0[daysworked] + $rs0[bonus] + $rs0[ot] - $rs0[deduction];
			}
			$totalearning = $rs0[salary] + $rs0[bonus] + $rs0[ot];
			$totalsal=intval($totalsal);
			$totalearning=intval($totalearning); 
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
							<h2 align="center">Salary Slip</h2>
					      <form method="post" action="" name="frmsalary" onsubmit="return validatesalary()">
                            <div align="center" id="divid">
                              <table width="597" height="79" border="1" class="tftable">
                                <tr>
                                  <td colspan="2"><strong>Employee Name</strong></td>
                                  <td width="221"><?php
										$sql = "SELECT *  FROM employee where status='Active'";
										if(!$qsql = mysqli_query($connection,$sql))
										{
											echo mysqli_error($connection);
										}
										while($rs = mysqli_fetch_array($qsql))
										{
											if($rs0[empid] == $rs[empid])
											{
									   		 echo $rs[empname];
											}
										}
									?></td>
                                  <td width="223"><strong>Date:</strong> <?php echo $rs0[date]; ?></td>
                                </tr>
                                <tr>
                                  <td colspan="2"><strong>Designation</strong></td>
                                  <td><?php
										$sql = "SELECT *  FROM employee where status='Active'";
										if(!$qsql = mysqli_query($connection,$sql))
										{
											echo mysqli_error($connection);
										}
										while($rs = mysqli_fetch_array($qsql))
										{
											if($rs0[empid] == $rs[empid])
											{
									   		 echo $rs[designation];
											}
										}
									?></td>
                                  <td><strong>Salary Type: </strong><?php
										$sql = "SELECT *  FROM employee where status='Active'";
										if(!$qsql = mysqli_query($connection,$sql))
										{
											echo mysqli_error($connection);
										}
										while($rs = mysqli_fetch_array($qsql))
										{
											if($rs0[empid] == $rs[empid])
											{
									   		 echo $rs[salarytype];
											}
										}
									?></td>
                                </tr>
                                <tr>
                                  <td colspan="2"><strong>Salary Month</strong></td>
                                  <td colspan="2"><?php echo $rs0[salarymonth]; ?></td>
                                </tr>
                              </table>
                              <br />
                              <table width="598" height="376" border="1" class="tftable">
                                <tr>
                                  <td><strong>No. of. Working days</strong></td>
                                  <td><?php echo $rs0[noworkingdays]; ?></td>
                                  <td><strong>No. of. Days Worked</strong></td>
                                  <td><?php echo $rs0[daysworked]; ?></td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td width="156"><strong>Earnings</strong></td>
                                  <td width="128">&nbsp;</td>
                                  <td width="173"><strong>Deductions</strong></td>
                                  <td width="113">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td><div align="right">Basic Salary Ksh.</div></td>
                                  <td><div align="right"><?php echo $rs0[salary]; ?></div></td>
                                  <td><div align="right">Deduction Ksh.</div></td>
                                  <td><div align="right"><?php echo $rs0[deduction]; ?></div></td>
                                </tr>
                                <tr>
                                  <td><div align="right">Bonus Ksh.</div></td>
                                  <td><div align="right"><?php echo $rs0[bonus]; ?></div></td>
                                  <td><div align="right"></div></td>
                                  <td><div align="right"></div></td>
                                </tr>
                                <tr>
                                  <td><div align="right">Overtime salary Ksh.</div></td>
                                  <td><div align="right"><?php echo $rs0[ot]; ?></div></td>
                                  <td><div align="right"></div></td>
                                  <td><div align="right"></div></td>
                                </tr>

                                <tr>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td><div align="right"><strong>Total Earnings Ksh. : </strong></div></td>
                                  <td><div align="right"><?php echo $totalearning.".00"; ?></div>
                                  </td>
                                  <td><div align="right"><strong>Total Deductions Ksh. : </strong></div></td>
                                  <td><div align="right"><?php echo $rs0[deduction]; ?></div></td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td><div align="right"><strong>Grand Total :</strong></div></td>
                                  <td><div align="right">Ksh. <?php echo $totalsal.".00" ; ?></div></td>
                                </tr>
  <tr>
  <th height="30" colspan="4" align="right" scope="col"><div align="left">Kenya Shillings
  <?php
  function no_to_words($no)
{   
              $words = array('0'=> '' ,'1'=> 'one' ,'2'=> 'two' ,'3' => 'three','4' => 'four','5' => 'five','6' => 'six','7' => 'seven','8' => 'eight','9' => 'nine','10' => 'ten','11' => 'eleven','12' => 'twelve','13' => 'thirteen','14' => 'fouteen','15' => 'fifteen','16' => 'sixteen','17' => 'seventeen','18' => 'eighteen','19' => 'nineteen','20' => 'twenty','30' => 'thirty','40' => 'fourty','50' => 'fifty','60' => 'sixty','70' => 'seventy','80' => 'eighty','90' => 'ninty','100' => 'hundred ','1000' => 'thousand','100000' => 'lakh','10000000' => 'crore');
    if($no == 0)
        return ' ';
    else {
	$novalue='';
	$highno=$no;
	$remainno=0;
	$value=100;
	$value1=1000;       
            while($no>=100)    {
                if(($value <= $no) &&($no  < $value1))    {
                $novalue=$words["$value"];
                $highno = (int)($no/$value);
                $remainno = $no % $value;
                break;
                }
                $value= $value1;
                $value1 = $value * 100;
            }       
          if(array_key_exists("$highno",$words))
              return $words["$highno"]." ".$novalue." ".no_to_words($remainno);
          else {
             $unit=$highno%10;
             $ten =(int)($highno/10)*10;            
             return $words["$ten"]." ".$words["$unit"]." ".$novalue." ".no_to_words($remainno);
           }
    }
}
echo no_to_words($totalsal). " only";
  ?>
  </div>
 </th>
  </tr>
    <tr>
  <th height="88" colspan="2" align="left" scope="col" valign="bottom"  ><p>Signature of the Employee
    
  </p></th>
  <th height="88" colspan="2" align="right" scope="col" valign="top"><p>Thank you for Trusting&nbsp;&nbsp;&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<br />
    Kitere Sugar Company&nbsp;&nbsp;<br />
    </p>
    <p><br />
      Yahyow&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</p></th>
  </tr>
                              </table>
                              <p>&nbsp;</p>
                               
                            </div>
                            <center><input type="button" name="btnprint" value=" " onclick="PrintMe('divid')" style=" min-height:40px; min-width:155px; background:url(coco/printbutton.png); background-size:cover; border-width:0px"/></center>
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

<script language="javascript">
function PrintMe(DivID) {
var disp_setting="toolbar=yes,location=no,";
disp_setting+="directories=yes,menubar=yes,";
disp_setting+="scrollbars=yes,width=650, height=600, left=100, top=25";
   var content_vlue = document.getElementById(DivID).innerHTML;
   var docprint=window.open("","",disp_setting);
   docprint.document.open();
   docprint.document.write('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"');
   docprint.document.write('"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">');
   docprint.document.write('<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">');
   docprint.document.write('<head><title></title>');
   docprint.document.write('<style type="text/css">body{ margin:0px;');
   docprint.document.write('font-family:verdana,Arial;color:#000;');
   docprint.document.write('font-family:Verdana, Geneva, sans-serif; font-size:12px;}');
   docprint.document.write('a{color:#000;text-decoration:none;} </style>');
   docprint.document.write('</head><body onLoad="self.print()"><center><h2>Kitere Sugar Company</h2><p>Near MKU University</p><p>Mob. : +254724981627  <strong>Email: husseinyahya@gmail.com</strong></p><h2 align="center">Production Report</h2>');
   docprint.document.write(content_vlue);
   docprint.document.write('</center></body></html>');
   docprint.document.close();
   docprint.focus();
}
</script>