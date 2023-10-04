<?php
include("header.php");
//connect to the database
include("connection.php");

if (isset($_POST['submit'])) {
  $billid = $_POST['billid'];

  echo "<script>alert('Bill paid successfully..'); </script>";
  echo "<script>window.location.assign('salesreportview.php?billid=".$billid."')</script>";

}

$billid = $_POST['billid'];
$sqlbilling  = "SELECT *  FROM billing where billingid='$_GET[billid]'";
$qsqlbilling = mysqli_query($connection,$sqlbilling);
$rsbilling = mysqli_fetch_array($qsqlbilling);

$sqlcust  = "SELECT * FROM customer where customerid='$rsbilling[customerid]'";
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

                        <h2 align="center">Sales 	 Report	</h2>
					      <form method="get" action="">
<div id="divid">
<table width="877" height="147" border="1" class="tftable">
  <tr>
    <th scope="col"><strong>Bill No.</strong></th>
    <td scope="col" align="left"><?php echo $_GET[billid]; ?></td>
  </tr>
  <tr>
    <th width="209" scope="col"><strong>Customer Name</strong></th>
    <td width="619" scope="col"> <?php echo $rscust[customername]; ?>    
    </td>
  </tr>
  <tr>
    <th width="209" scope="col"><strong>Company Name</strong></th>
    <td width="619" scope="col"> <?php echo $rscust[companyname]; ?>    
    </td>
  </tr>  
  <tr>
    <th height="25"><strong>Address</strong></th>
    <td><?php echo $rscust[address]; ?></td>
  </tr>
  <tr>
    <th><strong>Contact Numbers</strong></th>
    <td><?php echo $rscust[mobile_no]; ?>, <?php echo $rscust[phone_no]; ?></td>
  </tr>
  <tr>
    <th><div align="center"><strong> Date</strong></div></th>
    <td><?php echo $rsbilling[date]; ?></td>
  </tr>
</table>
<hr align="left" width="880" />

<strong>Sales Records:</strong>
<table width="878" border="1" class="tftable">
                            <tr>
                              <th width="161" height="25" scope="col">Product Name</th>
                              <th width="114" scope="col">Product Price</th>
                              <th width="74" scope="col">Tax %</th>
                              <th width="88" scope="col">Quantity</th>
                              <th width="89" scope="col">Total</th>
                              <th width="91" scope="col">Tax</th>
                              <th width="91" scope="col">Discount</th>                              
                              <th width="118" scope="col">Total Price</th>
                            </tr>
<?php
  $sqlsales ="SELECT * FROM 	sales where billingid='$_GET[billid]' AND status='Active'";
  $qsqlsales = mysqli_query($connection,$sqlsales);
  while($rssales = mysqli_fetch_array($qsqlsales))
  {
echo "<tr><td>";

      $sql ="SELECT * FROM 	product where productid='$rssales[productid]'";
      $qsql = mysqli_query($connection,$sql);
      $rs = mysqli_fetch_array($qsql);
      echo "$rs[productname]-$rs[qtytype]";				
	  echo "</td>
		  <td>Ksh.$rssales[totalamt]</td>
		  <td>$rssales[taxamt]</td>
		  <td>$rssales[qty]</td>
		  <td>";
		  echo "Ksh.".$total = $rssales[totalamt] * $rssales[qty];
		  echo "</td>
		  <td>";
		 echo "Ksh.".$tax = ($total*$rssales[taxamt])/100;
		  echo "</td>
		  <td>";
		 echo "Ksh.".$rssales[discount];
		  echo "</td><td>";
		  echo "Ksh.".$totalprice = $total + $tax -$rssales[discount];
		  echo "</td>
		</tr>";
		$grandtotal = $grandtotal + $totalprice;
		$grandtotal=intval($grandtotal);
  }
?>
 <tr>
                              <th height="32" colspan="7" scope="col"><div align="right"><strong>Grand total </strong></div></th>
                              <th colspan="2" scope="col">&nbsp;<?php echo "Ksh.$grandtotal" ?></th>
                            </tr>
 <tr>
   <th height="32" colspan="7" scope="col">&nbsp;<div align="left">Kenyan Shillings 
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
echo no_to_words($grandtotal). " only";
  ?>
  </div></th>
   <th colspan="2" scope="col">&nbsp;</th>
 </tr>
 <tr>
   <th height="32" colspan="9" scope="col"><div align="right"> Thank you for Trusting&nbsp;&nbsp;<br /><br />
  Kitere Sugar Company&nbsp;&nbsp;<br />
<br />
<br />
Yahyow&nbsp;&nbsp</div></th>
   </tr>
                            </table>
</div>
<div align="center"><br />
  <input type="button" name="btnprint" value=" " onclick="PrintMe('divid')" style=" min-height:40px; min-width:155px; background:url(coco/printbutton.png); background-size:cover; border-width:0px"/>
</div>
<p>&nbsp;</p>
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
   docprint.document.write('</head><body onLoad="self.print()"><center><h2>Kitere Sugar Company</h2><p>Near MKU University</p><p>Mob. : +254724981627  <strong>Email: husseinyahya530@gmail.com</strong></p><h2 align="center">Production Report</h2>');
   docprint.document.write(content_vlue);
   docprint.document.write('</center></body></html>');
   docprint.document.close();
   docprint.focus();
}
</script>