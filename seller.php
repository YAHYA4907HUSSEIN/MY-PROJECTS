<?php
include("header.php");
//connect to the database
include("connection.php");
if(isset($_POST[submit]))
{
	if(isset($_GET[editid]))
		{
			//to update seller records
			$sql = "UPDATE seller SET sellername='$_POST[sellername]',address='$_POST[address]',phone_no='$_POST[phno]',mobile_no='$_POST[mobno]',email_id='$_POST[emailid]',status='$_POST[status]' WHERE sellerid='$_GET[editid]'";
			if(!mysqli_query($connection,$sql))
			{
				echo "Error in Update statement". mysqli_error($connection);
			}
			else
			{
				echo "<script>alert('Seller record updated successfully..'); </script>";
				echo "<script>window.location.assign('viewseller.php');</script>";
			}
		}
		else
		{
			//to insert seller records
			$sql = "INSERT INTO seller(sellername,address,phone_no,mobile_no,email_id,status) VALUES('$_POST[sellername]','$_POST[address]','$_POST[phno]','$_POST[mobno]','$_POST[emailid]','$_POST[status]')";
			if(!mysqli_query($connection,$sql))
			{
				echo "Error in insert statement". mysqli_error($connection);
			}
			else
			{
				echo "<script>alert('Seller record inserted successfully..'); </script>";
				echo "<script>window.location.assign('seller.php');</script>";
				
			}
		}
}
if(isset($_GET[editid]))
{
	//to retrieve seller records
	$sql  = "SELECT *  FROM seller where sellerid='$_GET[editid]'";
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
							<h2 align="center">Seller	</h2>
					      <form method="post" action="" name="frmseller" onsubmit="return validateseller()">
                            <div align="center">
                              <table width="562" height="316" border="1" class="tftable">
                                <tr>
                                  <th width="220" scope="row"> Name <font color="#FF0000">*</font></th>
                                  <td width="326"><label for="sellername"></label>
                                  <input name="sellername" type="text" id="sellername" placeholder="Name"  
                                  onkeyup="isAlpha(document.getElementById('sellername'), 'Numbers And Special Characters are Not Allowed')" value="<?php echo $rs[sellername];?>" maxlength="25">
                                  </td>
                                </tr>
                                <tr>
                                  <th scope="row">Address <font color="#FF0000">*</font></th>
                                  <td><label for="address"></label>
                                  <textarea name="address" rows="3" id="address"><?php echo $rs[address];?></textarea>
                                  </td>
                                </tr>
                                <tr>
                                  <th scope="row">Phone Number</th>
                                  <td><label for="phno"></label>
                                  <input name="phno" type="text" id="phno"placeholder="Phone Number"
                                  onkeyup="isNumeric(document.getElementById('phno'), 'Only Numeric Values are Allowed')" value="<?php echo $rs[phone_no];?>" size="10" maxlength="15">
                                  </td>
                                </tr>
                                <tr>
                                  <th scope="row">Mobile Number <font color="#FF0000">*</font></th>
                                  <td><label for="mobno"></label>
                                  <input name="mobno" type="text" id="mobno"  
                                  placeholder="Mobile Number"
                                  onkeyup="isNumeric(document.getElementById('mobno'), 'Only Numeric Values are Allowed')" value="<?php echo $rs[mobile_no];?>" size="10" maxlength="11">
                                  </td>
                                </tr>
                                <tr>
                                  <th scope="row">Email ID</th>
                                  <td><label for="emailid"></label>
                                    <input type="email" name="emailid" id="emailid" value="<?php echo $rs[email_id];?>"
                                    placeholder="Email ID" 
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
function validateseller()
{
	if(document.frmseller.sellername.value == "")
	{
		alert("Seller name should not be empty..");
		document.frmseller.sellername.focus();
		return false;
	}
	else if(document.frmseller.sellername.value.length < 4)
	{
		alert("Seller name length should be more than 4 character.");
		document.frmseller.sellername.focus();
		return false;
	}
	else if(document.frmseller.address.value == "")
	{
		alert("Address should not be empty..");
		document.frmseller.address.focus();
		return false;
	}
	else if(document.frmseller.mobno.value == "")
	{
		alert("Mobile number should not be empty..");
		document.frmseller.mobno.focus();
		return false;
	}
	else if(document.frmseller.mobno.value.length < 9)
	{
		alert("Mobile Number should be more than 9 digits.");
		document.frmseller.mobno.focus();
		return false;
	}
	else if(document.frmseller.varemailid.value == 0)
	{
		alert("Entered Email ID already exists..");
		document.frmseller.emailid.focus();
		return false;		
	}
	else if(document.frmseller.status.value == "")
	{
		alert("Seller status should not be empty..");
		document.frmseller.status.focus();
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
		var getlink = "ajaxemailseller.php?email="+email;
        xmlhttp.open("GET",getlink,true);
        xmlhttp.send();
}
</script>