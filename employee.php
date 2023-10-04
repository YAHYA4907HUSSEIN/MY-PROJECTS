<?php
include("header.php");
//connect to the database
include("connection.php");
if(!isset($_SESSION[adminid]))
{
	//Redirect to account page if the employee loged in is not admin
	header("Location: account.php");	
}
if(isset($_POST[submit]))
{
		if(isset($_GET[editid]))
		{
			$sql = "UPDATE employee SET empname='$_POST[empname]',gender='$_POST[gender]',emptype='$_POST[emptype]',loginid='$_POST[login]',password='$_POST[password]',designation='$_POST[designation]',emailid='$_POST[emailid]', salarytype='$_POST[saltype]',empsalary='$_POST[basicsal]',address='$_POST[address]',contact_no='$_POST[mobno]',status='$_POST[status]' WHERE empid='$_GET[editid]'";
			if(!mysqli_query($connection,$sql))
			{
				echo "Error in Update statement". mysqli_error($connection);
			}
			else
			{
				echo "<script>alert('Employee record updated successfully..'); </script>";
				echo "<script>window.location.assign('viewemployee.php');</script>";
			}
		}
		else
		{
			$sql = "INSERT INTO employee(empname,gender,emptype,loginid,password,designation,emailid,salarytype,empsalary,address,contact_no,status) VALUES('$_POST[empname]','$_POST[gender]','$_POST[emptype]','$_POST[login]','$_POST[password]','$_POST[designation]','$_POST[emailid]','$_POST[saltype]','$_POST[basicsal]','$_POST[address]','$_POST[mobno]','$_POST[status]')";
			if(!mysqli_query($connection,$sql))
			{
				echo "Error in insert statement". mysqli_error($connection);
			}
			else
			{
				echo "<script>alert('Employee record inserted successfully..'); </script>";
				echo "<script>window.location.assign('employee.php');</script>";
			}
		}
}
if(isset($_GET[editid]))
{
	$sql  = "SELECT *  FROM employee where empid='$_GET[editid]'";
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
							<h2 align="center">Employee </h2>
					      <form method="post" action="" name="frmemployee" onsubmit="return validateemployee()">
                            <div align="center">
                              <table width="624" height="473" border="1" class="tftable">
                                <tr>
                                  <th width="222" scope="row">Name <font color="#FF0000">*</font></th>
                                  <td width="292"><label for="empname"></label>
                                  <input name="empname" type="text" id="empname" placeholder="Name" 
                                  onkeyup="isAlpha(document.getElementById('empname'), 'Numbers And Special Characters are Not Allowed')" 
                                  value="<?php echo $rs[empname]; ?>" maxlength="25"/></td>
                                </tr>
                                <tr>
                                  <th scope="row"> Gender</th>
                                  <td><input name="gender" type="radio" id="gender" value="male"  
                                <?php
                                if($rs[gender] == "male")
								{
                                	echo " checked";
								}
								if($rs[gender] == "")
								{
									echo " checked";
								}
								?> />
                                    <label for="gender">Male </label>
                                      <input name="gender" type="radio" id="gender" value="female"                                 
                                  <?php
                                  if($rs[gender] == "female")
								{
                                	echo " checked";
								} ?>/>
                                  <label for="gender">Female </label></td>
                                </tr>
                                <tr>
                                  <th scope="row"> Type <font color="#FF0000">*</font></th>
                                  <td>&nbsp;
                                    <label for="emptype"></label>
                                    <select name="emptype" id="emptype"  onchange="return chkusertype()">
                                    <option value="">Select</option>
                                      <?php
								  $arr = array("Employee","Admin","Non User");
								  foreach($arr as $val)
								  {
									  if($val == $rs[emptype])
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
                                  <th scope="row">LoginID<font color="#FF0000">**</font></th>
                                  <td><label for="login"></label>
                                  <input name="login" type="text" id="login" placeholder="User LoginID"
                                  onchange="chkelogin(this.value)" 
                                  onkeyup="isAlphanumeric(document.getElementById('login'), 'Special Characters are Not Allowed')" 
                                  value="<?php echo $rs[loginid]; ?>" maxlength="20"> <span id="ajlogin"><input type='hidden' name='varlogin' 
                                  value='1'></span>
                                  </td>
                                </tr>
                                <tr>
                                  <th scope="row">Password<font color="#FF0000">**</font></th>
                                  <td><label for="password"></label>
                                    <input name="password" type="password" id="password" placeholder="User Password" 
                                    onkeyup="isAlphanumeric(document.getElementById('password'), 'Special Characters are Not Allowed')" 
                                    value="<?php echo $rs[password]; ?>" maxlength="20" >
                                  </td>
                                </tr>
                                <tr>
                                  <th scope="row">Confirm password<font color="#FF0000">**</font></th>
                                  <td><label for="confirmpass"></label>
                                  <input name="confirmpass" type="password" id="confirmpass"  
                                  placeholder="Re-enter User Password" 
                                  onkeyup="isAlphanumeric(document.getElementById('confirmpass'), 'Special Characters are Not Allowed')" 
                                  value="<?php echo $rs[password]; ?>" maxlength="20">
                                  </td>
                                </tr>
                                <tr>
                                  <th scope="row">Email Id<font color="#FF0000">**</font></th>
                                  <td><input type="email" name="emailid" id="emailid" value="<?php echo $rs[emailid]; ?>" placeholder="Email Id"
                                  onchange="chkemail(this.value)"> 
                                  <span id="ajemail"><input type='hidden' name='varemailid' value='1'></span>
                                  </td>
                                </tr>
                                <tr>
                                  <th scope="row">Designation <font color="#FF0000">*</font></th>
                                  <td><label for="designation"></label>
                                    <input name="designation" type="text" id="designation"  placeholder="Designation" 
                                    onkeyup="isAlpha(document.getElementById('designation'), 'Numbers And Special Characters are Not Allowed')" 
                                    value="<?php echo $rs[designation]; ?>" maxlength="25"/></td>
                                </tr>
                                <tr>
                                  <th scope="row">Salary Type <font color="#FF0000">*</font></th>
                                  <td><select name="saltype" id="saltype" >
                                   <option value="">Select</option>
                                    <?php
								  $arr = array("Daily","Monthly");
								  foreach($arr as $val)
								  {
									  if($val == $rs[salarytype])
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
                                  <th scope="row">Basic salary <font color="#FF0000">*</font></th>
                                  <td><label for="basicsal"></label>
                                  <input name="basicsal" type="text" id="basicsal" placeholder="Basic salary"
                                  onkeyup="isFloat(document.getElementById('basicsal'), 'Only Decimal Values are Allowed')" 
                                  value="<?php echo $rs[empsalary]; ?>" maxlength="7">
                                  </td>
                                </tr>
                                <tr>
                                  <th scope="row">Address <font color="#FF0000">*</font></th>
                                  <td><label for="address"></label>
                                  <textarea name="address" rows="3" id="address"><?php echo $rs[address];?></textarea></td>
                                </tr>
                                <tr>
                                  <th scope="row">Mobile Number <font color="#FF0000">*</font></th>
                                  <td><label for="mobno"></label>
                                  <input name="mobno" type="text" id="mobno" placeholder="Mobile Number"
                                  onchange="chkemobile(this.value)"
                                  onkeyup="isNumeric(document.getElementById('mobno'), 'Only Numeric Values are Allowed')" 
                                  value="<?php echo $rs[contact_no]; ?>" size="10" maxlength="11"> 
                                  <span id="ajmobile"><input type='hidden' name='varmobile' value='1'></span>
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
                            <div align="right"><font color="#FF0000">**Only  Required  for Employee Type Other than Non user</font></div>  
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
function validateemployee()
{
	if(document.frmemployee.empname.value == "")
	{
		alert("Employee name should not be empty..");
		document.frmemployee.empname.focus();
		return false;
	}
	else if(document.frmemployee.emptype.value == "")
	{
		alert("Employee Type should not be empty..");
		document.frmemployee.emptype.focus();
		return false;
	}
	else if((document.frmemployee.emptype.value != "Non User") && (document.frmemployee.login.value == ""))
	{
		alert("Login Id should not be empty..");
		document.frmemployee.login.focus();
		return false;
	}
	else if((document.frmemployee.emptype.value != "Non User") && (document.frmemployee.login.value.length < 4))
	{
		alert("Login Id should be more than 4 character.");
		document.frmemployee.login.focus();
		return false;
	}
	else if((document.frmemployee.emptype.value != "Non User") && (document.frmemployee.varlogin.value == 0))
	{
		alert("Entered Login ID already exists..");
		document.frmemployee.login.focus();
		return false;		
	}
	else if((document.frmemployee.emptype.value != "Non User") && (document.frmemployee.password.value == ""))
	{
		alert("Password should not be empty..");
		document.frmemployee.password.focus();
		return false;
	}
	else if((document.frmemployee.emptype.value != "Non User") && (document.frmemployee.password.value.length < 4))
	{
		alert("Password should be more than 4 character.");
		password.value="";
		confirmpass.value="";
		document.frmemployee.password.focus();
		return false;
	}
	else if((document.frmemployee.emptype.value != "Non User") && (document.frmemployee.confirmpass.value == ""))
	{
		alert("Please  Re-enter Password");
		document.frmemployee.confirmpass.focus();
		return false;
	}
	else if((document.frmemployee.emptype.value != "Non User") && (document.frmemployee.password.value != document.frmemployee.confirmpass.value)) 
	{
		alert("Password Entered is not Matched Please Re-enter");
		password.value="";
		confirmpass.value="";
		password.focus();
		return false;
	}
	else if((document.frmemployee.emptype.value != "Non User") && (document.frmemployee.emailid.value == ""))
	{
		alert("Email ID should not be empty..");
		document.frmemployee.emailid.focus();
		return false;
	}
	else if(document.frmemployee.varemailid.value == 0)
	{
		alert("Entered Email ID already exists..");
		document.frmemployee.emailid.focus();
		return false;		
	}
	else if(document.frmemployee.designation.value == "")
	{
		alert("Designation should not be empty..");
		document.frmemployee.designation.focus();
		return false;
	}
	else if(document.frmemployee.saltype.value == "")
	{
		alert("Salary Type should not be empty..");
		document.frmemployee.saltype.focus();
		return false;
	}
	else if(document.frmemployee.basicsal.value == "")
	{
		alert("Basic Salary should not be empty..");
		document.frmemployee.basicsal.focus();
		return false;
	}
	else if(document.frmemployee.address.value == "")
	{
		alert("Address should not be empty..");
		document.frmemployee.address.focus();
		return false;
	}
	else if(document.frmemployee.mobno.value == "")
	{
		alert("Mobile Number should not be empty..");
		document.frmemployee.mobno.focus();
		return false;
	}
	else if(document.frmemployee.mobno.value.length < 9)
	{
		alert("Mobile Number should be more than 9 digits.");
		document.frmemployee.mobno.focus();
		return false;
	}
	else if(document.frmemployee.varmobile.value == 0)
	{
		alert("Entered Mobile Number already exists..");
		document.frmemployee.mobno.focus();
		return false;		
	}
	else if(document.frmemployee.status.value == "")
	{
		alert("Salary status should not be empty..");
		document.frmemployee.status.focus();
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

function isFloat(elem, helperMsg){
	if(elem.value !="")
	{
	var numericExpression = /^[0-9.]+$/;
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

function isAlphanumeric(elem, helperMsg){
	if(elem.value !="")
	{
	var alphaExp = /^[0-9a-zA-Z]+$/;
	if(elem.value.match(alphaExp)){
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
		var getlink = "ajaxemailemployee.php?email="+email;
        xmlhttp.open("GET",getlink,true);
        xmlhttp.send();
}
function chkelogin(login)
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
						document.getElementById("ajlogin").innerHTML = xmlhttp.responseText;
					}
				}
		var getlink = "ajaxloginemployee.php?login="+login;
        xmlhttp.open("GET",getlink,true);
        xmlhttp.send();
}
function chkemobile(mobile)
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
						document.getElementById("ajmobile").innerHTML = xmlhttp.responseText;
					}
				}
		var getlink = "ajaxmobileemployee.php?mobile="+mobile;
        xmlhttp.open("GET",getlink,true);
        xmlhttp.send();
}

function chkusertype()
{
	if(document.frmemployee.emptype.value == "Non User")
	{
		document.frmemployee.login.disabled =  true ;
		document.frmemployee.password.disabled =  true ;
		document.frmemployee.confirmpass.disabled =  true ;
		document.frmemployee.emailid.disabled =  true ;
	}
	else
	{
		document.frmemployee.login.disabled =  false ;
		document.frmemployee.password.disabled =  false ;
		document.frmemployee.confirmpass.disabled =  false ;
		document.frmemployee.emailid.disabled =  false ;
	}
}
</script>