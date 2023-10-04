<?php
include("header.php");
//connect to the database
include("connection.php");
if(isset($_POST[submit]))
{
		if(isset($_GET[editid]))
		{
			//to update customer records
			$sql = "UPDATE customer SET companyname='$_POST[companyname]',customername='$_POST[customername]',address='$_POST[address]',phone_no='$_POST[phno]',mobile_no='$_POST[mobno]',email_id='$_POST[emailid]',status='$_POST[status]' WHERE customerid='$_GET[editid]'";
			if(!mysqli_query($connection,$sql))
			{
				echo "Error in Update statement". mysqli_error($connection);
			}
			else
			{
				echo "<script>alert('Customer record updated successfully..'); </script>";
				echo "<script>window.location.assign('viewcustomer.php');</script>";
			}
		}
		else
		{
		//to insert customer records
		$sql = "INSERT INTO customer(companyname,customername,address,phone_no,mobile_no,email_id,status) VALUES('$_POST[companyname]','$_POST[customername]','$_POST[address]','$_POST[phno]','$_POST[mobno]','$_POST[emailid]','$_POST[status]')";
		if(!mysqli_query($connection,$sql))
		{
			echo "Error in insert statement". mysqli_error($connection);
		}
		else
		{
			echo "<script>alert('Customer record inserted successfully..'); </script>";
			echo "<script>window.location.assign('customer.php');</script>";
		}
	}
}
if(isset($_GET[editid]))
{	
//to retrieve customer records
	$sql  = "SELECT *  FROM customer where customerid='$_GET[editid]'";
	$qsql = mysqli_query($connection,$sql);
	$rs = mysqli_fetch_array($qsql);
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
							<h2 align="center">Customer </h2>
					      <form method="post" action="" name="frmcustomer" onsubmit="return validatecustomer()">
                            <div align="center">
                              <table width="597" height="319" border="1" class="tftable">
                              	<tr>
                                  <th scope="row">Customer ID <font color="#FF0000">*</font></th>
                                  <td><label for="Customer ID"></label>
                              <input name="National ID" type="text" id="CustomerID" placeholder="customerId"
                              onkeyup="isNumeric(document.getElementById('NationalId'),  'Only Numeric values are  Allowed')" 
                              value="<?php echo $rs[NationalId];?>" size="10" maxlength="15">
                                  </td>
                                </tr>
                                <tr>
                                  <th width="198" scope="row">Company Name</th>
                                  <td width="377"><label for="companyname"></label>
                                  <input name="companyname" type="text" id="companyname" placeholder="Company Name"
                                  onkeyup="isAlpha(document.getElementById('companyname'), 'Numbers And Special Characters are Not Allowed')" 
                                  value="<?php echo $rs[companyname];?>" maxlength="25"/>
                                  </td>
                                </tr>
                                <tr>
                                  <th scope="row">Customer Name <font color="#FF0000">*</font></th>
                                  <td><label for="customername"></label>
                              <input name="customername" type="text" id="customername" placeholder="Customer Name"
                              onkeyup="isAlpha(document.getElementById('customername'), 'Numbers And Special Characters are Not Allowed')" 
                              value="<?php echo $rs[customername];?>" maxlength="25"/>
                                  </td>
                                </tr>
                                <tr>
                                  <th scope="row"> Address <font color="#FF0000">*</font></th>
                                  <td><label for="address"></label>
                                  <textarea name="address" rows="3" id="address"><?php echo $rs[address];?></textarea></td>
                                </tr>
                                <tr>
                                  <th scope="row">Phone Number</th>
                                  <td><label for="phno"></label>
                                  <input name="phno" type="text" id="phno" 
                                  placeholder="Phone Number" 
                                  onkeyup="isNumeric(document.getElementById('phno'), 'Only Numeric Values are Allowed')" 
                                  value="<?php echo $rs[phone_no];?>" size="10" maxlength="15">
                                  </td>
                                </tr>
                                <tr>
                                  <th scope="row">Mobile Number <font color="#FF0000">*</font></th>
                                  <td><label for="mobno"></label>
                                  <input name="mobno" type="text" id="mobno" 
                                   placeholder="Mobile Number" 
                                   onkeyup="isNumeric(document.getElementById('mobno'), 'Only Numeric Values are Allowed')" 
                                   value="<?php echo $rs[mobile_no];?>" size="10" maxlength="11">
                                  </td>
                                </tr>
                                <tr>
                                  <th scope="row">Email ID</th>
                                  <td><label for="emailid"></label>
                                  <input type="email" name="emailid" id="emailid" value="<?php echo $rs[email_id];?>" placeholder="Email ID" 
                                  onchange="chkemail(this.value)"> <span id="ajemail"><input type='hidden' name='varemailid' value='1'></span>
                                  </td>
                                </tr>
                                <tr>
                                  <th scope="row">Status <font color="#FF0000">*</font></th>
                                  <td><label for="status"></label>
                                    <select name="status" id="status" >
                                    <option value="">Select</option>
                                      <?php
								  $arr = array("Active","Inactive");
								  foreach($arr as $val)
								  {
									  if($val == $rs[status])
									  {
									  echo "<option value='$val' selected>$val</option>";
									  }
									  else
									  {
									  echo "<option value='$val'>$val</option>";
									  }
								  }
								  ?>
                                  </select></td>
                                </tr>
                                <tr>
                                  <td colspan="2" scope="row"><div align="center">
                                    <input type="submit" name="submit" id="submit" value="Submit">
                                  </div></td>
                                </tr>
                              </table>
                            </div>
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
<script type="application/javascript">
//validation for mandatory fields
function validatecustomer()
{
	if(document.frmcustomer.customername.value == "")
	{
		alert("Customer name should not be empty..");
		document.frmcustomer.customername.focus();
		return false;
	}
	else if(document.frmcustomer.customername.value.length < 3)
	{
		alert("Customer name length should be more than 3 character.");
		document.frmcustomer.customername.focus();
		return false;
	}
	else if(document.frmcustomer.address.value == "")
	{
		alert("Address should not be empty..");
		document.frmcustomer.address.focus();
		return false;
	}
	else if(document.frmcustomer.mobno.value == "")
	{
		alert("Mobile number should not be empty..");
		document.frmcustomer.mobno.focus();
		return false;
	}
	else if(document.frmcustomer.mobno.value.length < 10)
	{
		alert("Mobile Number should be more than 9 digits.");
		document.frmcustomer.mobno.focus();
		return false;
	}
	else if(document.frmcustomer.varemailid.value == 0)
	{
		alert("Entered Email ID already exists..");
		document.frmcustomer.emailid.focus();
		return false;		
	}
	else if(document.frmcustomer.status.value == "")
	{
		alert("Customer status should not be empty..");
		document.frmcustomer.status.focus();
		return false;
	}
	else
	{
		<?php 
		if(isset($_GET[editid]))
		{
		?>
			var connn=confirm("Are you sure");
			if(connn==true)
			{
				return true;
			}
			else
			{
				return false;
			}
		<?php 
		}
		?>
		return true;
	}
}

function isAlpha(elem, helperMsg){
	if(elem.value !="")
	{
	var numericExpression = /^[A-Za-z- ]+$/;
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

function chkemail(email)
{			  
			if (window.XMLHttpRequest)
			{
				// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp = new XMLHttpRequest();
			} else {
				// code for IE6, IE5
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
				xmlhttp.onreadystatechange = function()
				{
					if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
					{
						document.getElementById("ajemail").innerHTML = xmlhttp.responseText;
					}
				}
		var getlink = "ajaxemailcustomer.php?email="+email;
        xmlhttp.open("GET",getlink,true);
        xmlhttp.send();
}
</script>