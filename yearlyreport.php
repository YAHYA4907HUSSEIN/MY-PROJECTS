<?php
include("header.php");
include("connection.php");
if(!isset($_SESSION[adminid]))
{
	//Redirect to account page if the employee loged in is not admin
	header("Location: account.php");	
}

$dt = $_GET[tyearlyreport]."-03-31";

//Coconut Available in stock after production
$sqlcoconutused1  = "SELECT SUM( qty ) FROM billing INNER JOIN purchase ON billing.billingid = purchase.billingid WHERE ( billing.date <= '$dt') AND (billing.sellerid <>0)";
$qsqlcoconutused1 = mysqli_query($connection,$sqlcoconutused1);
$rscoconutused1 = mysqli_fetch_array($qsqlcoconutused1);

$sqlcoconutused2  = "SELECT SUM( godownstkkg ) FROM  `production` WHERE DATE <= '$dt'";
$qsqlcoconutused2 = mysqli_query($connection,$sqlcoconutused2);
$rscoconutused2 = mysqli_fetch_array($qsqlcoconutused2);
$stockqty =$rscoconutused1[0]-$rscoconutused2[0];

//Coconut Used For Production
$fdt = $_GET[fyearlyreport] ."-04-01"; 
$tdt = $_GET[tyearlyreport] ."-03-31"; 
$sqlcoconutused  = "SELECT godownstkkg  FROM production where date BETWEEN '$fdt' AND '$tdt' ";
$qsqlcoconutused = mysqli_query($connection,$sqlcoconutused);
while($rscoconutused = mysqli_fetch_array($qsqlcoconutused))
{
 $coconutused=$coconutused+$rscoconutused[godownstkkg];
}

//no of sales
$sql  = "SELECT *  FROM billing where date BETWEEN '$fdt' AND '$tdt' AND customerid!=0 "; 
$qsql = mysqli_query($connection,$sql);
$salesno = mysqli_num_rows($qsql);
 
 
// no of purchae
$sql  = "SELECT *  FROM billing where date BETWEEN '$fdt' AND '$tdt' AND sellerid!=0 "; 
$qsql = mysqli_query($connection,$sql);
$purchaseno = mysqli_num_rows($qsql);

//Caluclation of purchase report
	$fdt = $_GET[fyearlyreport] ."-04-01"; 
	$tdt = $_GET[tyearlyreport] ."-03-31"; 
	$sql = "SELECT     billing.billingid, billing.sellerid, billing.customerid, billing.date, billing.status, purchase.purchaseid, purchase.sugarcane_typeid, purchase.billingid AS Expr2, purchase.qty, purchase.price, purchase.status AS Expr3, billing.date AS Expr1 FROM billing INNER JOIN purchase ON billing.billingid = purchase.billingid WHERE (billing.date BETWEEN '$fdt' AND '$tdt')";
	if(!$qsql = mysqli_query($connection,$sql))
	{
		echo mysqli_error($connection);
	}
		while($rs1 = mysqli_fetch_array($qsql))
		{
			$totqty = $totqty + $rs1[qty];
			$totamt = ($rs1[qty] * $rs1[price]);	
			$grandpurchasetot = $grandpurchasetot + $totamt;
		}
		
//Caluclation of sales report
	$fdt = $_GET[fyearlyreport] ."-04-01"; 
	$tdt = $_GET[tyearlyreport] ."-03-31"; 
		$sql3  = "SELECT *  FROM  billing INNER JOIN sales ON sales.billingid = billing.billingid  WHERE (billing.date BETWEEN '$fdt' AND '$tdt')";
		$qsql3 = mysqli_query($connection,$sql3);
		while($rs3 = mysqli_fetch_array($qsql3))
		{
			$sales= $rs3[qty] * $rs3[totalamt];
			$totalsales = $totalsales + $sales;
			
			$totaltaxamt = ($sales * $rs3[taxamt]/100);
			$totaltaxamt1 = $totaltaxamt1 + $totaltaxamt;
			
			$disount = $disount +  $rs3[discount] ;	
											
		}
		$grandsalestotal = $grandsalestotal+(($totalsales + $totaltaxamt1) - $disount);

	//Caluclation of salary - Paid
	$fdt = $_GET[fyearlyreport]; 
	$tdt = $_GET[tyearlyreport];
	$sql  = "SELECT *  FROM salary WHERE status='Paid' AND ";
		$dt4= $_GET[fyearlyreport] . "-04";
		$dt5= $_GET[fyearlyreport] . "-05";
		$dt6= $_GET[fyearlyreport] . "-06";
		$dt7= $_GET[fyearlyreport] . "-07";
		$dt8= $_GET[fyearlyreport] . "-08";
		$dt9= $_GET[fyearlyreport] . "-09";
		$dt10= $_GET[fyearlyreport] . "-10";
		$dt11= $_GET[fyearlyreport] . "-11";
		$dt12= $_GET[fyearlyreport] . "-12";
		$dt1= $_GET[tyearlyreport] . "-01";
		$dt2= $_GET[tyearlyreport] . "-02";
		$dt3= $_GET[tyearlyreport] . "-03";		
		$sql = $sql . "  (salarymonth='$dt1' || salarymonth='$dt2' || salarymonth='$dt3' || salarymonth='$dt4' || salarymonth='$dt5' || salarymonth='$dt6' || salarymonth='$dt7' || salarymonth='$dt8' || salarymonth='$dt9' || salarymonth='$dt10' || salarymonth='$dt11' || salarymonth='$dt12')";
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
		$grandtotalsalPaid =$grandtotalsalPaid +$totalsal ;
	}

//Caluclation of salary - Pending
$sql  = "SELECT *  FROM salary WHERE status='Pending' AND ";
		$dt4= $_GET[fyearlyreport] . "-04";
		$dt5= $_GET[fyearlyreport] . "-05";
		$dt6= $_GET[fyearlyreport] . "-06";
		$dt7= $_GET[fyearlyreport] . "-07";
		$dt8= $_GET[fyearlyreport] . "-08";
		$dt9= $_GET[fyearlyreport] . "-09";
		$dt10= $_GET[fyearlyreport] . "-10";
		$dt11= $_GET[fyearlyreport] . "-11";
		$dt12= $_GET[fyearlyreport] . "-12";
		$dt1= $_GET[tyearlyreport] . "-01";
		$dt2= $_GET[tyearlyreport] . "-02";
		$dt3= $_GET[tyearlyreport] . "-03";
	$sql = $sql . "  (salarymonth='$dt1' || salarymonth='$dt2' || salarymonth='$dt3' || salarymonth='$dt4' || salarymonth='$dt5' || salarymonth='$dt6' || salarymonth='$dt7' || salarymonth='$dt8' || salarymonth='$dt9' || salarymonth='$dt10' || salarymonth='$dt11' || salarymonth='$dt12')";
//$sql = $sql . " LIMIT $offset, $rec_limit";
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
	$grandtotalsalPending =$grandtotalsalPending +$totalsal ;
}
	$fdt = $_GET[fyearlyreport] ."-04-01"; 
	$tdt = $_GET[tyearlyreport] ."-03-31"; 

//Total expense amount - Paid
$sql ="SELECT SUM(`expenseamt`) FROM  `expenses` where status='Paid' AND date BETWEEN '$fdt' AND '$tdt'"; 
$qsql = mysqli_query($connection,$sql);
$rs = mysqli_fetch_array($qsql);
$totalexpensesPaid=$rs[0]*1;

//Total expense amount - Pending
$sql ="SELECT SUM(`expenseamt`) FROM  `expenses` where status='Pending' AND date BETWEEN '$fdt' AND '$tdt'"; 
$qsql = mysqli_query($connection,$sql);
$rs = mysqli_fetch_array($qsql);
$totalexpensesPending=$rs[0]*1;

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
							<h2 align="center">yearly Report</h2>
  <form method="get" action="" name="report" onsubmit="return validatereport()">
<table width="878" border="1" class="tftable">
  <tr>
    <th width="137" scope="row">&nbsp;Enter Year in four digit</th>
    <td width="461">&nbsp;
&nbsp; &nbsp; <strong>From :</strong> December/ &nbsp; <input name="fyearlyreport" type="text" id="fyearlyreport" 
onkeyup="isNumeric(document.getElementById('fyearlyreport'), 'Only Numeric Values are Allowed')" value="<?php echo $_GET[fyearlyreport]; ?>" maxlength="4" > 
&nbsp;| <strong>To:</strong> December/ &nbsp;<input name="tyearlyreport" type="text" id="tyearlyreport" 
onkeyup="isNumeric(document.getElementById('tyearlyreport'), 'Only Numeric Values are Allowed')" value="<?php echo $_GET[tyearlyreport]; ?>" maxlength="4" >

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
  <th height="29" colspan="4" scope="col">Sugarcane Purchased in Kg</th>
  <th colspan="2" scope="col"><?php echo $totqty + 0 ?></th>
</tr>
<tr>
  <th height="29" colspan="4" scope="col">Sugarcane Used For Production in Kg</th>
  <th colspan="2" scope="col"><?php echo $coconutused + 0 ?></th>
</tr>
<tr>
  <th height="29" colspan="4" scope="col">Sugarcane  Available In Stock After Production in Kg</th>
  <th colspan="2" scope="col"><?php echo $stockqty + 0 ?></th>
</tr>
<tr>
  <th height="29" colspan="4" scope="col">Product Quantity Added to the Stock</th>
  <th colspan="2" scope="col"><div align="right">
<?php 

	$fdt = $_GET[fyearlyreport] ."-04-01"; 
	$tdt = $_GET[tyearlyreport] ."-03-31"; 

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
  <th height="29" colspan="4" scope="col">Product Quantity Available in Stock </th>
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
  <th width="113" scope="col">Sales Amount <font style='color:red'>+</font></th>
  <th width="140" height="29" scope="col">Purchase Amount <strong><font style='color:red'>-</font></strong></th>
  <th width="159" scope="col">Paid Expense Amount <strong><font style='color:red'>-</font></strong></th>
  <th width="148" scope="col">Paid Salary Amount <strong><font style='color:red'>-</font></strong></th>
  <th width="146" scope="col">Pending Expense Amount <strong><font style='color:red'>-</font></strong></th>
  <th width="132" scope="col">Pending Salary Amount <strong><font style='color:red'>-</font></strong></th>
</tr>
<tr>    
<div align="center">
  <td scope="col"><div align="center">Ksh.&nbsp;<?php echo $grandsalestotal +0; ?></div></td> 
  <td scope="col"><div align="center">Ksh.&nbsp;<?php echo $grandpurchasetot +0; ?></div></td>
  <td scope="col"><div align="center">Ksh.&nbsp;<?php echo $totalexpensesPaid +0; ?></div></td>
  <td scope="col"><div align="center">Ksh.&nbsp;<?php echo $grandtotalsalPaid +0; ?></div></td>
  <td scope="col"><div align="center">Ksh.&nbsp;<?php echo $totalexpensesPending +0; ?></div></td>
  <td scope="col"><div align="center">Ksh.&nbsp;<?php echo $grandtotalsalPending +0; ?></div></td>
  </div>
</tr>
<tr>
  <th height="30" colspan="4" align="right" scope="col"><div align="right"><strong>Total Pending Amount</strong></div></th>
  <th colspan="2" scope="col">&nbsp;<font style='color:red'>
    Ksh. <?php 
  $totpendingamt =  $totalexpensesPending  + $grandtotalsalPending ; 
  echo ceil($totpendingamt);
  ?>
    </font>
  </th>
  </tr>
<tr>
  <th height="30" colspan="4" align="right" scope="col">&nbsp;</th>
  <th scope="col"><strong>Total Profit</strong></th>
  <th scope="col">&nbsp; Ksh. <?php 
  $grandtotal1 = $grandsalestotal - ( $totalexpensesPending  + $grandtotalsalPending + $grandpurchasetot +  $totalexpensesPaid + $grandtotalsalPaid);
  echo $grandtotal1=ceil($grandtotal1);
   ?></th>
  </tr>

  <tr>
    <th height="30" colspan="7" align="right" scope="col"><div align="left">Profit In Words :- Kenyan Shillings
      <?php
  function no_to_words($no)
{   
              $words = array('0'=> '' ,'1'=> 'one' ,'2'=> 'two' ,'3' => 'three','4' => 'four','5' => 'five','6' => 'six','7' => 'seven','8' => 'eight','9' => 'nine','10' => 'ten','11' => 'eleven','12' => 'twelve','13' => 'thirteen','14' => 'fouteen','15' => 'fifteen','16' => 'sixteen','17' => 'seventeen','18' => 'eighteen','19' => 'nineteen','20' => 'twenty','30' => 'thirty','40' => 'fourty','50' => 'fifty','60' => 'sixty','70' => 'seventy','80' => 'eighty','90' => 'ninty','100' => 'hundred ','1000' => 'thousand','100000' => 'One hundred ','1000000' => 'One million');
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
if($grandtotal1 <0 )
{
	$profittotal1 =  abs($grandtotal1);
	echo "Minus ".  no_to_words($profittotal1). " only";	
}
else
{
	echo no_to_words($grandtotal1). " only";
}
  ?>
      </div>
      </th>
  </tr>
    <tr>
      <th height="30" colspan="7" align="right" scope="col"><div align="left">
      Company Status : <?php
      if($grandtotal1 > 0)
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
  <div align="right">Thank you for shopping with us&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;<br />
      kitere sugar company&nbsp;&nbsp;<br />
  <br />
  <br />
      welcome Again&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
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
" style=" min-height:40px; min-width:155px; background:url(coco/printbutton.png); background-size:cover; border-width:0px"/>
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

function isNumeric(elem, helperMsg){
	if(elem.value !="")
	{
	var numericExpression = /^[0-9]+$/;
	if(elem.value.match(numericExpression)){
		return true;
	}else{
		alert(helperMsg);
		elem.value="";
		elem.focus();
		return false;
	}
	}
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
   docprint.document.write('</head><body onLoad="self.print()"><center><h2>Kitere Sugar Company</h2><p>Near Rongo University.</p><p>Mob. : 0724126885 <strong>Email: abdi@gmail.com</strong></p><h2 align="center">Yearly Report</h2>');
   docprint.document.write(content_vlue);
   docprint.document.write('</center></body></html>');
   docprint.document.close();
   docprint.focus();
}

function validatereport()
{
	if(document.report.fyearlyreport.value == "")
	{
		alert("From Year should not be empty..");
		document.report.fyearlyreport.focus();
		return false;
	}
	else if(document.report.fyearlyreport.value.length < 4)
	{
		alert("From Year should be 4 Digit..");
		document.report.fyearlyreport.focus();
		return false;
	}
	else if(document.report.tyearlyreport.value == "")
	{
		alert("To Year should not be empty..");
		document.report.tyearlyreport.focus();
		return false;
	}
	else if(document.report.tyearlyreport.value.length < 4)
	{
		alert("To Year should be 4 Digit..");
		document.report.tyearlyreport.focus();
		return false;
	}
	else if(((document.report.tyearlyreport.value) - (document.report.fyearlyreport.value)) != 1 )
	{
		alert("Difference between the Selection must be 1 year And From date must be less then To date");
		document.report.tyearlyreport.focus();
		return false;
	}
	else
	{
		return true;
	}
}
</script>