<?php
include("header.php");
//connect to the database
include("connection.php");
if(isset($_POST[submit]))
{
	//to update employee records
	$sql = "UPDATE employee SET password='$_POST[newpass]' WHERE loginid='$_POST[loginid]' AND password='$_POST[oldpass]' AND empid='$_SESSION[empid]'";
	if(!mysqli_query($connection,$sql))
	{
		echo "Error in update statement". mysqli_error($connection);
	}
	if(mysqli_affected_rows($connection) == 1)
	{
		echo "<script>alert('Password updated successfully..'); </script>";
		echo "<script>window.location.assign('account.php');</script>";
		
	}
	else
	{
		echo "<script>alert('Entered details not valid..'); </script>";
		echo "<script>window.location.assign('resetpass.php');</script>";
	}

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
							<h2>Reset Password</h2>
                            <form method="post" action="" name="frmreset" onsubmit="return validatereset()" enctype="multipart/form-data">
							<table width="393" height="113" border="1" align="center" class="tftable">
							  <tr>
							    <td scope="row"><div align="center"><strong>Login Id</strong></div></td>
							    <td>
                                <?php
								$sql= "SELECT * FROM employee WHERE empid='$_SESSION[empid]'";
								$qsql = mysqli_query($connection,$sql);
								$rs = mysqli_fetch_array($qsql);
								?>
                                <input name="loginid" type="text" id="loginid" value="<?php echo $rs[loginid]; ?>" readonly="readonly" /></td>
						      </tr>
							  <tr>
							    <td width="191" scope="row"><div align="center"><strong>Old Password <font color="#FF0000">*</font></strong></div></td>
							    <td width="186"><label for="oldpass"></label>
							      <input name="oldpass" type="password" id="oldpass" placeholder="Old Password" 
                                   onkeyup="isAlphanumeric(document.getElementById('oldpass'), 'Special Characters are Not Allowed')" maxlength="20"/></td>
						      </tr>
							  <tr>
							    <td scope="row"><div align="center"><strong>New Password<font color="#FF0000">*</font></strong></div></td>
							    <td><input name="newpass" type="password" id="newpass" placeholder="New Password"  
                                 onkeyup="isAlphanumeric(document.getElementById('newpass'), 'Special Characters are Not Allowed')" maxlength="20"/></td>
						      </tr>
							  <tr>
							    <td scope="row"><div align="center"><strong>Confirm Password <font color="#FF0000">*</font></strong></div></td>
							    <td><input name="conformpass" type="password" id="conformpass" placeholder="Confirm Password" 
                                 onkeyup="isAlphanumeric(document.getElementById('conformpass'), 'Special Characters are Not Allowed')" maxlength="20"/></td>
						      </tr>
							  <tr>
							    <th colspan="2" scope="row"><input type="submit" name="submit" id="submit" value="Submit" /></th>
						      </tr>
						  </table>
							<p>&nbsp; </p>
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
function validatereset()
{
	if(document.frmreset.oldpass.value == "")
	{
		alert("Old Password should not be empty..");
		document.frmreset.oldpass.focus();
		return false;
	}
	else if(document.frmreset.newpass.value == "")
	{
		alert("New Password should not be empty..");
		document.frmreset.newpass.focus();
		return false;
	}
	else if(document.frmreset.newpass.value.length < 4)
	{
		alert("New Password should be more than 4 character.");
		newpass.value="";
		conformpass.value="";
		document.frmreset.newpass.focus();
		return false;
	}
	else if(document.frmreset.conformpass.value == "")
	{
		alert("Please  Re-enter Password.");
		document.frmreset.conformpass.focus();
		return false;
	}
	else if(document.frmreset.newpass.value != document.frmreset.conformpass.value)
	{
		alert("Password Entered is not Matched Please Re-enter");
		newpass.value="";
		conformpass.value="";
		document.frmreset.newpass.focus();
		return false;
	}
	else
	{
	var connn=confirm("Are you sure");
	if(connn==true)
	{
		return true;
	}
	else
	{
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

function confirmmsg()
{
	
}

</script>