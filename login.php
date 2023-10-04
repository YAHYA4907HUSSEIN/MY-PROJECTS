<?php
include("header1.php");
//connect to the database
include("connection.php");
if(isset($_SESSION[empid]))
{
	//Redirect to account page if the employee has already loged in
	header("Location: account.php");	
}
if(isset($_POST[submit]))
{
	$sql= "SELECT * FROM employee WHERE loginid='$_POST[login]' AND password='$_POST[password]' AND status='Active' ";
	$qsql = mysqli_query($connection,$sql);
	if(mysqli_num_rows($qsql) == 1)
	{
		$rs = mysqli_fetch_array($qsql);
		if($rs[emptype]=='Admin')
		{
			$_SESSION[adminid] = $rs[empid];
		}
		$_SESSION[empid] = $rs[empid];
		header("Location: account.php");
	}
	else
	{
		//Alert messege for  Invalid Data Entry
		echo "<script>alert('Login error.. Entered Details Not Valid');</script>";
		echo "<script>window.location.assign('Login.php');</script>";

	}
}
?>
<div id="wrapper"style= "background-color: green">>
<div id="page-wrapper" class="5grid-layout">
		<div class="row" id="content">
			<div class="12u">
				<section>
					<div class="post">
						<p>
                        
                        </p>
				      <form method="post" action="" name="frmlogin" onsubmit="return validatelogin()">
                              <table width="409" height="146" border="1" align="center" class="tftable">
						  <tr>
						    <td width="191" height="32" scope="row"><div align="center">Login Id <font color="#FF0000">*</font></div></td>
						    <td width="186">
						      <label for="login"></label>
						      <input type="text" name="login" id="login"
                              onkeyup="isAlphanumeric(document.getElementById('login'), 'Special Characters are Not Allowed')">
					        </td>
					      </tr>
						  <tr>
						    <td height="37" scope="row"><div align="center">Password <font color="#FF0000">*</font></div></td>
						    <td><input type="password" name="password" id="password">
                            </td>
					      </tr>
						  <tr>
						    <th colspan="2" scope="row"><input type="submit" name="submit" id="submit" value=" " style=" min-height:40px; min-width:120px; background:url(coco/Login-Button-300x99.jpg); background-size:cover;"></th>
					      </tr>
                           <tr>
						    <th height="23" colspan="2" scope="row"><a href="forgotpass.php">Forgot Password.?</a></th>
					      </tr>
					  </table>
                      </form>
						<p>&nbsp;</p>
					</div>
				</section>
			</div>
		</div>
	</div>
</div>
<?php
include("footer.php");
?>

<script type="application/javascript">
//validation for log in
function validatelogin()
{
	if(document.frmlogin.login.value == "")
	{
		//Warning messege for empty field
		alert("Login Id should not be empty..");
		document.frmlogin.login.focus();
		return false;
	}
	else if(document.frmlogin.password.value == "")
	{
		//Warning messege for empty field
		alert("Password should not be empty..");
		document.frmlogin.password.focus();
		return false;
	}
	else
	{
		return true;
	}
}

//Validation for Invalid Character press
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

</script>