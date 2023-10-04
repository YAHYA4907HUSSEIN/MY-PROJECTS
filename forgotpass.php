<?php
include("header1.php");
//connect to the database
include("connection.php");
if(isset($_SESSION[empid]))
{	//redirects to the account page
	header("Location: account.php");
}
	if(isset($_POST[submit]))
	{
		//to retrieve employee records
		$sql ="SELECT * FROM employee WHERE emailid='$_POST[emailid]' AND contact_no='$_POST[contactno]'";
		$qsql = mysqli_query($connection,$sql);
		if(mysqli_num_rows($qsql) >= 1)
		{
			$rs = mysqli_fetch_array($qsql);
			$mailto	= $_POST[emailid];
			$msgtitle  = "INDOUS BIO PRODUCTS Login credentials";
			$msgcontent = "Dear $rs[empname], <br />
							<strong>Your Login Id is : </strong>$rs[loginid] <br />
							<strong>Password is:</strong> $rs[password] <br /><br />
							<a href='http://localhost/coconut_project/login.php'><strong>Click here to Login</strong></a><br />
							Thank you..";
			mailsender($mailto,$msgtitle,$msgcontent);
			echo "<script>alert('Login details sent to Email...');</script>";
			echo "<script>window.location.assign('login.php');</script>";
		}
		else
		{
			echo "<script>alert('No record found in the database..');</script>";
		}
	}
?>
	<div id="page-wrapper" class="5grid-layout">
		<div class="row" id="content">
			<div class="12u">
				<section>
					<div class="post">
						<p>
                        
                        </p>
				      <form name="frmforgot" method="post" action="" onsubmit="return validateforgot()">
                              <table width="393" height="113" border="1" align="center" class="tftable">
						  <tr>
						    <td scope="row"><div align="center">Contact Number <font color="#FF0000">*</font></div></td>
						    <td><input name="contactno" type="text" id="contactno" placeholder="Contact Number" 
                            onkeyup="isNumeric(document.getElementById('contactno'), 'Only Numeric Values are Allowed')" maxlength="11"/></td>
						    </tr>
						  <tr>
						    <td width="191" scope="row"><div align="center">Email Id <font color="#FF0000">*</font></div></td>
						    <td width="186">
						      <label for="emailid"></label>
						      <input type="email" name="emailid" id="emailid" placeholder="Email Id">
					        </td>
					      </tr>
						  <tr>
						    <th colspan="2" scope="row"><input type="submit" name="submit" id="submit" value="Recover Password"></th>
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

function mailsender($mailto,$msgtitle,$msgcontent)
{
	require 'PHPMailer-master/PHPMailerAutoload.php';
	
	$mail = new PHPMailer;
	
	//$mail->SMTPDebug = 3;                               // Enable verbose debug output
	
	$mail->isSMTP();                                      // Set mailer to use SMTP
	$mail->Host = 'mail.dentaldiary.in';  					// Specify main and backup SMTP servers
	$mail->SMTPAuth = true;                               // Enable SMTP authentication
	$mail->Username = 'sendmail@dentaldiary.in';                 // SMTP username
	$mail->Password = 'q1w2e3r4/';                           // SMTP password
	$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
	$mail->Port = 587;                                    // TCP port to connect to
	
	$mail->From = 'sendmail@dentaldiary.in';
	$mail->FromName = 'INDOUS BIO PRODUCTS';
	$mail->addAddress($mailto, 'Joe User');     			// Add a recipient
	$mail->addAddress($mailto);               			// Name is optional
	$mail->addReplyTo('aravinda@technopulse.in', 'Information');
	$mail->addCC('cc@example.com');
	$mail->addBCC('bcc@example.com');
	
	$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
	$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
	$mail->isHTML(true);                                  // Set email format to HTML
	
	$mail->Subject = $msgtitle;
	$mail->Body    = $msgcontent;
	$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
	
	if(!$mail->send()) {
		echo 'Message could not be sent.';
		echo 'Mailer Error: ' . $mail->ErrorInfo;
	} else {
		//echo 'Message has been sent';
	}
}
?>

<script type="application/javascript">
//validation for mandatory fields
function validateforgot()
{
	if(document.frmforgot.contactno.value == "")
	{
		alert("Contact Number should not be empty..");
		document.frmforgot.contactno.focus();
		return false;
	}
	else if(document.frmforgot.contactno.value.length < 9)
	{
		alert("Contact Number should be more than 9 digits.");
		document.frmforgot.contactno.focus();
		return false;
	}
		else if(document.frmforgot.emailid.value == "")
	{
		alert("Email Id should not be empty..");
		document.frmforgot.emailid.focus();
		return false;
	}
	else
	{
		return true;
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

</script>