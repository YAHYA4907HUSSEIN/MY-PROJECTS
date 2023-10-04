<?php
include("header.php");
//connect to the database
include("connection.php");

if (isset($_POST['submit'])) {
    $billid = $_POST['billid'];
  
    echo "<script>alert('Bill paid successfully..'); </script>";
    echo "<script>window.location.assign('reportview.php?billid=".$billid."')</script>";
  
  }
//to retrieve records
	$sql  = "SELECT *  FROM purchase where purchaseid='$_GET[billid]'";
	$qsql = mysqli_query($connection,$sql);
	$rs = mysqli_fetch_array($qsql);
	
	$sqlbilling  = "SELECT *  FROM billing where billingid='$_GET[billid]'";
	$qsqlbilling = mysqli_query($connection,$sqlbilling);
	$rsbilling = mysqli_fetch_array($qsqlbilling);
	
	$sqlcust  = "SELECT * FROM seller where sellerid='$rsbilling[sellerid]'";
	$qsqlcust = mysqli_query($connection,$sqlcust);
	$rscust = mysqli_fetch_array($qsqlcust);

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

							<h2 align="center">Purchase Report</h2>
<div id="divid">
<form method="get" action="">
 <table width="877" height="128" border="1" class="tftable">
  <tr>
    <th scope="col"><strong>BILL NO</strong></th>
    <td scope="col"><?php echo $_GET[billid]; ?></td>
  </tr>
  <tr>
    <th width="209" scope="col"><strong>Seller Name</strong></th>
    <td width="619" scope="col"> <?php echo $rscust[sellername]; ?> </td>
  </tr>
  <tr>
    <th height="31"><strong>Address</strong></th>
    <td><?php echo $rscust[address]; ?></td>
  </tr>
  <tr>
    <th><strong>Contact Numbers</strong></th>
    <td><?php echo $rscust[mobile_no]; ?>, <?php echo $rscust[phone_no]; ?></td>
  </tr>
  <tr>
    <th><strong> Date</strong></th>
    <td><?php echo $rsbilling[date]; ?></td>
  </tr>
</table><br />
&nbsp;
<table width="878" height="67" border="1" class="tftable">
<tr>
  <th width="107" height="29" scope="col">Sugarcane type</th>
  <th width="162" scope="col">Price</th>
  <th width="144" scope="col">Quantity in KG</th>
 <th width="156" scope="col">Total</th>
 <th width="156" scope="col">Grand Total</th>
</tr>
<?php
$sql  = "SELECT *  FROM purchase where billingid='$_GET[billid]'";
$qsql = mysqli_query($connection,$sql);
while($rs = mysqli_fetch_array($qsql))
{
	
	$sql1  = "SELECT *  FROM sugarcanetype where sugarcane_typeid='$rs[sugarcane_typeid]'";
	$qsql1 = mysqli_query($connection,$sql1);
	$rs1 = mysqli_fetch_array($qsql1);
	$totprice = ($rs[price] * $rs[qty]);
	$grandtotal = $grandtotal + $totprice;
	$grandtotal=intval($grandtotal);
echo "<tr>";
echo "<td>&nbsp;$rs1[sugarcane_type]</td>
  <td>&nbsp;Ksh.$rs[price]</td>
  <td>&nbsp;$rs[qty]</td>
  <td>&nbsp; Ksh. ". $totprice . "</td>" ;
echo "</tr>";
}
?>
<tr>
  <th height="30" colspan="4" scope="col"><div align="right"><strong>Grand total</strong></div></th>
  <th colspan="2" scope="col"> <div align="center">Ksh. <?php echo $grandtotal; ?></div></th>
  </tr>
  <tr>
  <th height="30" colspan="6" scope="col"><div align="left">Kenyan Shilling 
  <?php
  function no_to_words($no)
{   
              $words = array('0'=> '' ,'1'=> 'one' ,'2'=> 'two' ,'3' => 'three','4' => 'four','5' => 'five','6' => 'six','7' => 'seven','8' => 'eight','9' => 'nine','10' => 'ten','11' => 'eleven','12' => 'twelve','13' => 'thirteen','14' => 'fouteen','15' => 'fifteen','16' => 'sixteen','17' => 'seventeen','18' => 'eighteen','19' => 'nineteen','20' => 'twenty','30' => 'thirty','40' => 'fourty','50' => 'fifty','60' => 'sixty','70' => 'seventy','80' => 'eighty','90' => 'ninty','100' => 'hundred ','1000' => 'thousand','100000' => 'one hundred thousand','10000000' => 'crore');
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
echo no_to_words($grandtotal). " only";
  ?>
  </div>
 </th>
  </tr>
    <tr>
  <td height="30" colspan="6" align="right" scope="col">
  Thanks for trusting &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br />
  Kitere Sugar Company&nbsp;&nbsp;<br />
<br />
<br />
Yahyow&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  </td>
  </tr>
</table>
</div>
<div align="center"><br />
  <input type="button" name="btnprint" value=" " onclick="PrintMe('divid')" style="min-height:40px; min-width:155px; background:url(coco/printbutton.png); background-size:cover; border-width:0px"/>
  
  
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
   docprint.document.write('</head><body onLoad="self.print()"><center><h2>Kitere Sugar Company</h2><p>Near MKU University</p><p>Mob. : +254724981627  <strong>Email: husseinyahya530@gmail.com </strong></p><h2 align="center">Production Report</h2>');
   docprint.document.write(content_vlue);
   docprint.document.write('</center></body></html>');
   docprint.document.close();
   docprint.focus();
}
</script>