<?php
include("header.php");
include("connection.php");
if(!isset($_SESSION[adminid]))
{
	//Redirect to account page if the employee loged in is not admin
	header("Location: account.php");	
}
$dt = date($_GET[monthlyreport].'-t');

//sugar Stock
$sqlsugarused1  = "SELECT SUM( qty ) FROM billing INNER JOIN purchase ON billing.billingid = purchase.billingid WHERE ( billing.date <= '$dt') AND (billing.sellerid <>0)";
$qsqlsugarused1 = mysqli_query($connection,$sqlsugarused1);
$rssugarused1 = mysqli_fetch_array($qsqlsugarused1);

$sqlsugarused2  = "SELECT SUM( godownstkkg ) FROM  `production` WHERE DATE <= '$dt'";
$qsqlsugarused2 = mysqli_query($connection,$sqlsugarused2);
$rssugarused2 = mysqli_fetch_array($qsqlsugarused2);
$stockqty =$rssugarused1[0]-$rssugarused2[0];

//sugar Used For Production
$fdt = $_GET[monthlyreport] ."-01";
$tdt  = date($_GET[monthlyreport].'-t');
$sqlsugarused  = "SELECT godownstkkg  FROM production where date BETWEEN '$fdt' AND '$tdt' ";
$qsqlsugarused = mysqli_query($connection,$sqlsugarused);
while($rssugarused = mysqli_fetch_array($qsqlsugarused))
{
 $sugarused=$sugarused+$rssugarused[godownstkkg];
}


//no of sales
$sql  = "SELECT *  FROM billing where date BETWEEN '$fdt' AND '$tdt' AND customerid!=0 "; 
$qsql = mysqli_query($connection,$sql);
$salesno = mysqli_num_rows($qsql);
 
 
// no of purchae
$sql  = "SELECT *  FROM billing where date BETWEEN '$fdt' AND '$tdt' AND sellerid!=0 "; 
$qsql = mysqli_query($connection,$sql);
$purchaseno = mysqli_num_rows($qsql);


	$fdt = $_GET[monthlyreport] ."-01";
	$tdt  = date($_GET[monthlyreport].'-t');
	$sql = "SELECT     billing.billingid, billing.sellerid, billing.customerid, billing.date, billing.status, purchase.purchaseid, purchase.sugarcane_typeid, purchase.billingid AS Expr2, purchase.qty, purchase.price, purchase.status AS Expr3, billing.date AS Expr1 FROM billing INNER JOIN purchase ON billing.billingid = purchase.billingid WHERE (billing.date BETWEEN '$fdt' AND '$tdt')";
	if(!$qsql = mysqli_query($connection,$sql))
	{
		echo mysqli_error($connection);
	}
	while($rs1 = mysqli_fetch_array($qsql))
	{
		$totqty1 = $totqty1 + $rs1[qty];
		$totamt1 = ($rs1[qty] * $rs1[price]);	
		$grandpurchasetot2 = $grandpurchasetot2 + $totamt1;
	}

//Caluclation of sales
		$sql3  = "SELECT *  FROM  billing INNER JOIN sales ON sales.billingid = billing.billingid  WHERE (billing.date BETWEEN '$fdt' AND '$tdt')";
		$qsql3 = mysqli_query($connection,$sql3);
		while($rs3 = mysqli_fetch_array($qsql3))
		{
			$sales2= $rs3[qty] * $rs3[totalamt];
			$totalsales2 = $totalsales2 + $sales2;
			$totaltaxamt2 = ($sales2 * $rs3[taxamt]/100);
			$totaltaxamt3 = $totaltaxamt3 + $totaltaxamt2;
			$disount2 = $disount +  $rs3[discount] ;											
		}
		$grandsalestotal2 = $grandsalestotal2+(($totalsales2 + $totaltaxamt3) - $disount2);

//Salary report - Paid
$sql  = "SELECT *  FROM salary WHERE status='Paid' AND (salarymonth='$_GET[monthlyreport]')";
$qsql = mysqli_query($connection,$sql);
while($rs = mysqli_fetch_array($qsql))
{
	$sql1  = "SELECT * FROM employee WHERE empid=$rs[empid]";
	$qsql1 = mysqli_query($connection,$sql1);
	$rs1 = mysqli_fetch_array($qsql1);
	if($rs1[salarytype] == "Monthly")
	{
		$totalsal2 = $rs[salary]  + $rs[bonus] + $rs[ot] - $rs[deduction];
	}
	else
	{
		$totalsal2 = $rs[salary] * $rs[daysworked] + $rs[bonus] + $rs[ot] - $rs[deduction];
	}
	$grandtotalsalPaid2 =$grandtotalsalPaid2 +$totalsal2 ;
}

//Caluclation of salary - Pending
$sql  = "SELECT *  FROM salary WHERE status='Pending' AND (salarymonth='$_GET[monthlyreport]')";
$qsql = mysqli_query($connection,$sql);
while($rs = mysqli_fetch_array($qsql))
{
	$sql1  = "SELECT * FROM employee WHERE empid=$rs[empid]";
	$qsql1 = mysqli_query($connection,$sql1);
	$rs1 = mysqli_fetch_array($qsql1);
	if($rs1[salarytype] == "Monthly")
	{
		$totalsal2 = $rs[salary]  + $rs[bonus] + $rs[ot] - $rs[deduction];
	}
	else
	{
		$totalsal2 = $rs[salary] * $rs[daysworked] + $rs[bonus] + $rs[ot] - $rs[deduction];
	}
	$grandtotalsalPending2 =$grandtotalsalPending2 +$totalsal2 ;
}

//Total expense amount - Paid
$sql ="SELECT SUM(`expenseamt`) FROM  `expenses` where status='Paid' AND date BETWEEN '$fdt' AND '$tdt'"; 
$qsql = mysqli_query($connection,$sql);
$rs = mysqli_fetch_array($qsql);
$totalexpensesPaid2=$rs[0]*1;

//Total expense amount - Pending
$sql ="SELECT SUM(`expenseamt`) FROM  `expenses` where status='Pending' AND date BETWEEN '$fdt' AND '$tdt'"; 
$qsql = mysqli_query($connection,$sql);
$rs = mysqli_fetch_array($qsql);
$totalexpensesPending2=$rs[0]*1;

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
							<h2 align="center">monthly Report</h2>
<form method="get" action="" name="report" onsubmit="return validatereport()">
<table width="878" border="1" class="tftable">
  <tr>
    <th width="137" scope="row">&nbsp;Select Month : </th>
    <td width="461">&nbsp;

&nbsp; &nbsp; <input type="month" name="monthlyreport" value="<?php echo $_GET[monthlyreport]; ?>" max="<?php echo date("Y-m");?>" 
                              min="<?php echo date("2010-01");?>" >

    </td>
  </tr>
  <tr>
    <th colspan="2" scope="row"><input type="submit" name="searchsubmit" id="searchsubmit" value="Submit" /></th>
    </tr>
</table>
</form>

<?php
if(isset($_GET[searchsubmit]))
{
?> 
<form method="get" action=""><br />
&nbsp;
<div id="divid">
<table width="878" height="193" border="1" class="tftable">
<tr>
  <th height="29" colspan="4" scope="col">Number of Purchases</th>
  <th colspan="2" scope="col"><?php echo $purchaseno ?> </th>
</tr>
<tr>
  <th height="29" colspan="4" scope="col">Number of Sales</th>
  <th colspan="2" scope="col"><?php echo $salesno ?></th>
</tr>
<tr>
  <th height="29" colspan="4" scope="col">Sugar Cane Purchased in Kg</th>
  <th colspan="2" scope="col"><?php echo $totqty + 0 ?></th>
</tr>
<tr>
  <th height="29" colspan="4" scope="col">Sugar Cane Used For Production in Kg</th>
  <th colspan="2" scope="col"><?php echo $sugarused + 0 ?></th>
</tr>
<tr>
  <th height="29" colspan="4" scope="col">Sugar Cane Available In Stock After Production in Kg</th>
  <th colspan="2" scope="col"><?php echo $stockqty + 0 ?></th>
</tr>
<tr>
  <th height="29" colspan="4" scope="col">Product Quantity Added to the Stock</th>
  <th colspan="2" scope="col"><div align="right">
<?php 

$fdt = $_GET[monthlyreport] ."-01";
$tdt  = date($_GET[monthlyreport].'-t');

//product Stock
$sql2  = "SELECT SUM(stock.qty) AS Expr1, product.productid,product.productname,product.qtytype FROM product INNER JOIN stock ON product.productid = stock.productid LEFT OUTER JOIN production ON stock.productionid = production.productionid WHERE (production.date BETWEEN '$fdt' AND '$tdt') GROUP BY product.productid";
$qsql2 = mysqli_query($connection,$sql2);
if(mysqli_num_rows($qsql2) == 0)
{
	echo "<center>None</center>";
}
while($rs2 = mysqli_fetch_array($qsql2))
{ 

		echo $rs2[productname]."-".$rs2[qtytype]."------------". $rs2[0];
		
?>
  <hr/> 
<?php
} ?>

    </div></th>
  </tr>
<tr>
  <th height="29" colspan="4" scope="col">Quantity of Sold Products</th>
  <th colspan="2" scope="col" style="text-align:right">&nbsp;
<?php  
 $sql2  = " SELECT SUM(sales.qty) AS Expr1, product.productname,product.qtytype FROM product INNER JOIN sales ON product.productid = sales.productid 
INNER JOIN billing ON sales.billingid = billing.billingid WHERE (billing.date BETWEEN '$fdt' AND '$tdt') GROUP BY product.productid, product.productname";
$qsql2 = mysqli_query($connection,$sql2);
if(mysqli_num_rows($qsql2) == 0)
{
	echo "<center>None</center>";
}
while($rs2 = mysqli_fetch_array($qsql2))
{
		echo $rs2[productname]."-".$rs2[qtytype]."------------". $rs2[0];
		
?>
  <hr/> 
<?php
} ?> 
  </th>
</tr>
<tr>
  <th height="29" colspan="4" scope="col">Product Quantity Available in Stock</th>
  <th colspan="2" scope="col">
<div align="right">
<?php
//product quanitity available in stock
$sql2  = "SELECT SUM(stock.qty) AS Expr1, product.productid,product.productname,product.qtytype FROM product INNER JOIN stock ON product.productid = stock.productid LEFT OUTER JOIN production ON stock.productionid = production.productionid WHERE (production.date <= '$dt') GROUP BY product.productid";
$qsql2 = mysqli_query($connection,$sql2);
if(mysqli_num_rows($qsql2) == 0)
{
	echo "<center>None</center>";
}
while($rs2 = mysqli_fetch_array($qsql2))
{ 
	$sql3= "SELECT SUM( sales.qty ) AS Expr1 FROM sales INNER JOIN billing ON sales.billingid = billing.billingid INNER JOIN product ON sales.productid = product.productid WHERE (product.productid ='$rs2[productid]') AND ( billing.date <=  '$dt')";
	$qsql3 = mysqli_query($connection,$sql3);
	$rs3 = mysqli_fetch_array($qsql3);
	$remtot = $rs2[0]  - $rs3[0];
	echo $rs2[productname]."-".$rs2[qtytype]."------------". $remtot;
?>
  <hr/> 
<?php
}
?>
    </div></th>
  </tr>
<tr>
  <th width="119" scope="col">Sales Amount <font style='color:red'>+</font></th>
  <th width="133" height="29" scope="col">Purchase Amount <strong><font style='color:red'>-</font></strong></th>
  <th width="157" scope="col">Paid Expense Amount <strong><font style='color:red'>-</font></strong></th>
  <th width="152" scope="col">Paid Salary Amount <strong><font style='color:red'>-</font></strong></th>
  <th width="140" scope="col">Pending Expense Amount <strong><font style='color:red'>-</font></strong></th>
  <th width="137" scope="col">Pending Salary Amount <strong><font style='color:red'>-</font></strong></th>
</tr>
<tr>    
<div align="center">
  <td scope="col"><div align="center">Ksh.&nbsp;<?php echo $grandsalestotal2 +0; ?></div></td> 
  <td scope="col"><div align="center">Ksh.&nbsp;<?php echo $grandpurchasetot2 +0; ?></div></td>
  <td scope="col"><div align="center">Ksh.&nbsp;<?php echo $totalexpensesPaid2 +0; ?></div></td>
  <td scope="col"><div align="center">Ksh.&nbsp;<?php echo $grandtotalsalPaid2 +0; ?></div></td>
  <td scope="col"><div align="center">Ksh.&nbsp;<?php echo $totalexpensesPending2 +0; ?></div></td>
  <td scope="col"><div align="center">Ksh.&nbsp;<?php echo $grandtotalsalPending2 +0; ?></div></td>
  </div>
</tr>
<tr>
  <th height="30" colspan="4" align="right" scope="col"><div align="right"><strong>Total Pending Amount</strong></div></th>
  <th colspan="2" scope="col">&nbsp;<font style='color:red'>
    Ksh. <?php 
  $totpendingamt =  $totalexpensesPending2  + $grandtotalsalPending2 ; 
  echo ceil($totpendingamt);
  ?></font>
  </th>
</tr>
<tr>
  <th height="30" colspan="4" align="right" scope="col">&nbsp;</th>
  <th scope="col"><div align="right"><strong>Grand total </strong></div></th>
  <th scope="col">&nbsp; Ksh. <?php 
  $grandtotal1 = $grandsalestotal2 - ( $totalexpensesPending2  + $grandtotalsalPending2 + $grandpurchasetot2 +  $totalexpensesPaid2 + $grandtotalsalPaid2);
  echo ceil($grandtotal1);
   ?></th>
  </tr>
<tr>
  <th height="30" colspan="4" align="right" scope="col">&nbsp;</th>
  <th scope="col"><div align="right">Opening Balance</div></th>
  <th scope="col">Ksh. 
  <?php
  include("ajaxmonthlyreport.php");
  ?>
  </th>
</tr>
<tr>
  <th height="30" colspan="4" align="right" scope="col">&nbsp;</th>
  <th scope="col"><div align="right">Total Profit</div></th>
  <th scope="col">&nbsp; Ksh.
  <?php echo $profittotal = $grandtotal1 +  $grandtotal; ?>
  </th>
</tr>
  <tr>
    <th height="30" colspan="7" align="right" scope="col"><div align="left">Profit In Words :- Kenyan Shillings
      <?php
  function no_to_words($no)
{   
              $words = array('0'=> '' ,'1'=> 'one' ,'2'=> 'two' ,'3' => 'three','4' => 'four','5' => 'five','6' => 'six','7' => 'seven','8' => 'eight','9' => 'nine','10' => 'ten','11' => 'eleven','12' => 'twelve','13' => 'thirteen','14' => 'fouteen','15' => 'fifteen','16' => 'sixteen','17' => 'seventeen','18' => 'eighteen','19' => 'nineteen','20' => 'twenty','30' => 'thirty','40' => 'fourty','50' => 'fifty','60' => 'sixty','70' => 'seventy','80' => 'eighty','90' => 'ninty','100' => 'hundred ','1000' => 'thousand','100000' => 'One hundred','10000000' => 'crore');
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
if($profittotal <0 )
{
	$profittotal1 =  abs($profittotal);
	echo "Minus ".  no_to_words($profittotal1). " only";	
}
else
{
	echo no_to_words($profittotal). " only";
}
  ?>
      </div>
      </th>
  </tr>
    <tr>
      <th height="30" colspan="7" align="right" scope="col"><div align="left">
      Company Status : <?php
      if($profittotal > 0)
	  {
	  	echo "<strong><font style='color:green'>In Profit.</font></strong>";
	  }
	  else
	  {
	  	echo "<strong><font style='color:red'>In Loss.</font></strong>";		  
	  }
	  ?>
      </div></th>
    </tr>
    <tr>
   <th height="30" colspan="7" align="right" scope="col">
  <div align="right">Thank you for trusting &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;<br />
      Kitere Sugar Company&nbsp;&nbsp;<br />
  <br />
  <br />
      Yahyow&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
    </div>
  </th>
  </tr>
</table>
</div>
<div align="center"><br />
  <input type="button" name="btnprint" value=" " onclick="
	<?php 
    if($totpendingamt > 0)
    {
    ?>
	  message()
    <?php
	}
	else
	{
	?>
	  PrintMe('divid')
	<?php
	}
	?>
"style="min-height:40px; min-width:155px; background:url(coco/printbutton.png); background-size:cover; border-width:0px"/>
<?php
}
?>  
</div>
<p>&nbsp;</p>
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
function message()
{
	alert("Please Clear the pending Amounts");
}


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
   docprint.document.write('</head><body onLoad="self.print()"><center><h2>Kitere Sugar Company</h2><p>Near MKU University.</p><p>Mob. : 0724981627 <strong>Email: YAHMA@gmail.com</strong></p><h2 align="center">Monthly Report</h2>');
   docprint.document.write(content_vlue);
   docprint.document.write('</center></body></html>');
   docprint.document.close();
   docprint.focus();
}

function validatereport()
{
	if(document.report.monthlyreport.value == "")
	{
		alert("Month should not be empty..");
		document.report.monthlyreport.focus();
		return false;
	}
	else
	{
		return true;
	}
}
</script>