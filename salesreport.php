<?php
include("header.php");
//connect to the database
include("connection.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if(isset($_POST[btnsubmit]))
{
	//to insert billing records
	$sql = "INSERT INTO billing(customerid,date,status) VALUES('$_POST[customer]','$_POST[salesdate]','Active')";
		if(!mysqli_query($connection,$sql))
		{
			echo "Error in insert statement". mysqli_error($connection);
		}
		$billid = mysqli_insert_id($connection);
		//to update sales records
		$sql = "UPDATE sales SET status='Active',billingid='$billid' WHERE billingid='0' AND status='Pending'";
 		
		if(!mysqli_query($connection,$sql))
		{
			echo "Error in insert statement". mysqli_error($connection);
		}
		else
		{
			echo "<script>alert('Sales record inserted successfully..'); </script>";
			echo "<script>window.location.assign('salesreport.php?billid=".$billid."')</script>";
		}
}
//to retrieve billing records
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

<h2>Mpesa Payment</h2>
            <form action="salesreportview.php" method="POST">
              <input type="hidden" name="billid" value="<?php echo $_GET['billid']; ?>">
              <input type="number" name="amount" value="" id="" placeholder="Amount to be paid">
              <br>
              <input type="number" name="phone_number" value="" id="" placeholder="Phone Number">
              <br>
              <input type="submit" value="PAY" name="submit">
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