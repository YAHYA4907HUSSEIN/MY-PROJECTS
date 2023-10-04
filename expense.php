<?php
include("header.php");
include("connection.php");
//connect to the database
if(!isset($_SESSION[adminid]))
{
	//Redirect to account page if the employee loged in is not admin
	header("Location: account.php");	
}
if(isset($_POST[submit]))
{
	$expimage = rand().$_FILES["file"]["name"];
	move_uploaded_file($_FILES["file"]["tmp_name"],"cocimage/".$expimage);
	if(isset($_GET[editid]))
		{
			//to update expense records
			$sql = "UPDATE expenses SET expensedetails='$_POST[expdetls]',expenseamt='$_POST[expamt]',bill_no='$_POST[billno]',expenseimage='$expimage',date='$_POST[date]',note='$_POST[note]',status='$_POST[status]' WHERE expenseid='$_GET[editid]'";
			if(!mysqli_query($connection,$sql))
			{
				echo "Error in Update statement". mysqli_error($connection);
			}
			else
			{
				echo "<script>alert('Expense record updated successfully..'); </script>";
				echo "<script>window.location.assign('viewexpense.php');</script>";
			}
		}
		else
		{
			//to insert expense records
			$sql = "INSERT INTO expenses(expensedetails,expenseamt,bill_no,expenseimage,date,note,status) VALUES('$_POST[expdetls]','$_POST[expamt]','$_POST[billno]','$expimage','$_POST[date]','$_POST[note]','$_POST[status]')";
			if(!mysqli_query($connection,$sql))
			{
				echo "Error in insert statement". mysqli_error($connection);
			}
			else
			{
				echo "<script>alert('Expense record inserted successfully..'); </script>";
				echo "<script>window.location.assign('expense.php');</script>";
			}
		}
}
if(isset($_GET[editid]))
{
	//to retrieve expense records
	$sql  = "SELECT *  FROM expenses where expenseid='$_GET[editid]'";
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
							<h2 align="center">Expense	</h2>
					      <form method="post" action="" enctype="multipart/form-data" name="frmexpense" onsubmit="return validateexpense()">
                            <div align="center">
                              <table width="585" height="352" border="1" class="tftable">
                                <tr>
                                  <th scope="row">Details <font color="#FF0000">*</font></th>
                                  <td><label for="expdetls"></label>
                                  <input name="expdetls" type="text" id="expdetls"      
                                  placeholder="Expense Detail" value="<?php echo $rs[expensedetails]; ?>" maxlength="25"
                                  onkeyup="isAlphanumeric(document.getElementById('expdetls'), 'Special Characters are Not Allowed')">
                                  </td>
                                </tr>
                                <tr>
                                  <th width="222" scope="row">Amount <font color="#FF0000">*</font></th>
                                  <td width="292"><label for="expamt"></label>
                                  <input name="expamt" type="text" id="expamt"              
                                  placeholder="Amount Spent" onkeyup="isFloat(document.getElementById('expamt'), 'Only Decimal Values are Allowed')" 
                                  value="<?php echo $rs[expenseamt]; ?>" size="9" maxlength="7">
                                  </td>
                                </tr>
                                <tr>
                                  <th scope="row">Bill Number</th>
                                  <td><label for="billno"></label>
                                  <input name="billno" type="text" id="billno" placeholder="Bill Number" value="<?php echo $rs[bill_no]; ?>" 
                                  size="9" maxlength="15" >
                                  </td>
                                </tr>
                                <tr>
                                  <th scope="row"> Image</th>
                                  <td><label for="file"></label>
                                    <input type="file" name="file" id="file"> 
                                    <br />
                                    <?php
								if(isset($_GET[editid]))
								{
								?>
                                    <img src="images/pics/<?php echo $rs[expenseimage];?>" height="50" width="50" />
                                    <?php
								}
								?>
                                  </td>
                                </tr>
                                <tr>
                                  <th scope="row">Date <font color="#FF0000">*</font></th>
                                  <td><label for="price"></label>
                                    <input type="date" name="date" id="date" value="<?php echo $rs[date]; ?>" max="<?php echo date("Y-m-d");?>" 
                                min="<?php echo date("2010-01-01");?>" >
                                    </td>
                                </tr>
                                <tr>
                                  <th height="59" scope="row">Note</th>
                                  <td><label for="note"></label>
                                    <textarea name="note" id="note" ><?php echo $rs[note];?></textarea>
                                </tr>
                                <tr>
                                  <th scope="row">Status <font color="#FF0000">*</font></th>
                                  <td><label for="status"></label>
                                    <select name="status" id="status"  >
                                      <option value="">Select</option>                               
                                      <?php
								  $arr = array("Paid","Pending");
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
function validateexpense()
{
	if(document.frmexpense.expdetls.value == "")
	{
		alert("Expense Details should not be empty..");
		document.frmexpense.expdetls.focus();
		return false;
	}
	else if(document.frmexpense.expamt.value == "")
	{
		alert("Expense Amount should not be empty..");
		document.frmexpense.expamt.focus();
		return false;
	}
	else if(document.frmexpense.date.value == "")
	{
		alert("Date should not be empty..");
		document.frmexpense.date.focus();
		return false;
	}
	else if(document.frmexpense.status.value == "")
	{
		alert("Expense status should not be empty..");
		document.frmexpense.status.focus();
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
	var alphaExp = /^[0-9a-zA-Z- ]+$/;
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