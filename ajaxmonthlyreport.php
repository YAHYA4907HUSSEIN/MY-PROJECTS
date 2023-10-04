<?php
error_reporting(0);
include("connection.php");
$dt2 = $_GET[monthlyreport] ."-01";
$time=strtotime($dt2);
$month=date("m",$time);
$year=date("Y",$time);
$date = date("d",$time);

if($month ==  "03" || $month ==  "02" || $month ==  "01") 
{
	$yr = $year-1;
	$tyr = $year;
}
else
{
	$yr =$year;
	$tyr =  $year+1;
}

 $fdt = "$yr-04-01 ";
if($month == "04")
{
	$yesterday = mktime(0,0,0,$month,$date,$year);	
}
else
{
	$yesterday = mktime(0,0,0,$month-1,$date,$year);
}

 $tdt = date("Y-m-d", $yesterday);
 
 $time=strtotime($tdt);
$month=date("m",$time);
$year=date("Y",$time);

$tdt =date($year."-".$month.'-t');

// Purchase report
	$sql = "SELECT     billing.billingid, billing.sellerid, billing.customerid, billing.date, billing.status, purchase.purchaseid, purchase.sugarcane_typeid, purchase.billingid AS Expr2, purchase.qty, purchase.price, purchase.status AS Expr3, billing.date AS Expr1 FROM billing INNER JOIN purchase ON billing.billingid = purchase.billingid WHERE (billing.date between '$fdt' and '$tdt')";
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

// Caluclation of sales
		$sql3  = "SELECT *  FROM  billing INNER JOIN sales ON sales.billingid = billing.billingid  WHERE (billing.date between '$fdt' and '$tdt')";
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

// Caluclation of salary - Paid
	$sql  = "SELECT *  FROM salary WHERE status='Paid'  AND (date between '$fdt' and '$tdt')";
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

// Caluclation of salary - Pending
$sql  = "SELECT *  FROM salary WHERE status='Pending'  AND (date between '$fdt' and '$tdt')";
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

//Total expense amount - Paid
$sql ="SELECT SUM(expenseamt) FROM  expenses where status='Paid'  AND (date between '$fdt' and '$tdt')"; 
$qsql = mysqli_query($connection,$sql);
$rs = mysqli_fetch_array($qsql);
$totalexpensesPaid=$rs[0]*1;

//Total expense amount - Pending
$sql ="SELECT SUM(expenseamt) FROM  expenses where status='Pending'  AND (date between '$fdt' and '$tdt')"; 
$qsql = mysqli_query($connection,$sql);
$rs = mysqli_fetch_array($qsql);
$totalexpensesPending=$rs[0]*1;

$grandtotal =  $grandsalestotal - ( $grandpurchasetot + $totalexpensesPending + $totalexpensesPaid + $grandtotalsalPending + $grandtotalsalPaid);
echo ceil($grandtotal);

?>