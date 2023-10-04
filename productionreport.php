<?php
include("header.php");
//connect to the database
include("connection.php");

if(isset($_POST[btnsubmit]))
{
	//to insert production records
	$sql = "INSERT INTO production(godownstkkg,godownstkno,wasteinno,drypcno,netprocessingno,brokenpiecekg,netprocessingkg,date,status) 
VALUES('$_POST[godwnkg]','$_POST[godwnno]','$_POST[wstno]','$_POST[drpcno]','$_POST[ntprno]','$_POST[brkpcno]','$_POST[ntprkg]','$_POST[date]','Active')";
		if(!mysqli_query($connection,$sql))
		{
			echo "Error in insert statement". mysqli_error($connection);
		}
		
		$prodnid = mysqli_insert_id($connection);
		//to update stock records
		$sql = "UPDATE stock SET status='Active',productionid='$prodnid' WHERE productionid='0' AND status='Pending'";
 		if(!mysqli_query($connection,$sql))
		{
			echo "Error in insert statement". mysqli_error($connection);
		}
		else
		{
			echo "<script>alert('Stock record inserted successfully..'); </script>";
			echo "<script>window.location.assign('productionreport.php?prodnid=".$prodnid."')</script>";
		}
}

	$sqlproduction  = "SELECT * FROM production where productionid='$_GET[prodnid]'";
	$qsqlproduction = mysqli_query($connection,$sqlproduction);
	$rsproduction = mysqli_fetch_array($qsqlproduction);
	
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
							<h2 align="center">Production 	 Report</h2>
					      <form method="get" action="">
                          <div id="divid">
                          <div align="center">
                            <table width="670" height="264" border="1" class="tftable">
                              <tr>
                                <th width="401" scope="row">Sugarcane used for Production in KG</th>
                                <td width="253"><?php echo $rsproduction[godownstkkg]; ?> </td>
                              </tr>  
                              <tr>
                                <th scope="row">Sugarcane used for Production in No</th>
                                <td><?php echo $rsproduction[godownstkno]; ?></td>
                              </tr>
                              <tr>
                                <th scope="row">Waste in No</th>
                                <td><?php echo $rsproduction[wasteinno]; ?> </td>
                              </tr>
                              <tr>
                                <th scope="row">Dry piece in No</th>
                                <td><?php echo $rsproduction[drypcno]; ?></td>
                              </tr>
                              <tr>
                                <th scope="row">Net Proccessing in No</th>
                                <td><?php echo $rsproduction[netprocessingno]; ?></td>
                              </tr>
                              <tr>
                                <th scope="row">Brokenpiece in KG</th>
                                <td><?php echo $rsproduction[brokenpiecekg]; ?></td>
                              </tr>
                              <tr>
                                <th scope="row">Net Proccessing in KG</th>
                                <td><?php echo $rsproduction[netprocessingkg]; ?></td>
                              </tr>
                              <tr>
                                <th scope="row"> Date </th>
                                <td><?php echo $rsproduction[date]; ?></td>
                              </tr>
  </table>
                          </div>
                          <hr align="center" width="670" />
                          <div align="center"><strong>Production Records:</strong>
                            <table width="670" height="35" border="1" class="tftable">
    <tr>
      <th width="123" height="23" scope="col">Product Name</th>
      <th width="73" scope="col">Quantity</th>
      </tr>
    
    <?php
	$sqlstock  = "SELECT *  FROM stock where productionid='$_GET[prodnid]' AND status='Active'";
	$qsqlstock = mysqli_query($connection,$sqlstock);
  while($rsstock = mysqli_fetch_array($qsqlstock))
  {
	echo "<tr><td>";

      $sql ="SELECT * FROM 	product where productid='$rsstock[productid]'";
      $qsql = mysqli_query($connection,$sql);
      $rs = mysqli_fetch_array($qsql);
      echo "$rs[productname]-$rs[qtytype]";				
	  echo "</td>
		  <td>$rsstock[qty]</td>
		</tr>";
  }
?>
  </table>
    </div> 
    </div>                      
  <br />
<div align="center"><br />
  <input type="button" name="btnprint" value=" " onclick="PrintMe('divid')" style=" min-height:40px; min-width:155px; background:url(coco/printbutton.png); background-size:cover; border-width:0px"/>
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
   docprint.document.write('</head><body onLoad="self.print()"><center><h2>Kitere Sugar Company</h2><p>Near MKU University</p><p>Mob. : +254724981627  <strong>Email: husseinyahya530@gmail.com</strong></p><h2 align="center">Production Report</h2>');
   docprint.document.write(content_vlue);
   docprint.document.write('</center></body></html>');
   docprint.document.close();
   docprint.focus();
}
</script>