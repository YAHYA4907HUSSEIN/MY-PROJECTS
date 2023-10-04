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
		//to update salary records		
			$sql = "UPDATE salary SET empid='$_POST[empid]',salarymonth='$_POST[salmonth]',noworkingdays='$_POST[nonwrk]',daysworked='$_POST[wrk]',salary='$_POST[sal]',deduction='$_POST[deduct]',bonus='$_POST[bonus]',ot='$_POST[otsalary]',date='$_POST[date]',status='$_POST[status]' WHERE salaryid='$_GET[editid]'";			
			if(!mysqli_query($connection,$sql))
			{
				echo "Error in Update statement". mysqli_error($connection);
			}
			else
			{
				echo "<script>alert('Salary record updated successfully..'); </script>";
				if($_POST[status] != "Pending")
				{
				echo "<script>window.location.assign('salaryreport.php?reportid=$_GET[editid]');</script>";
				}
				else
				{
				echo "<script>window.location.assign('viewsalary.php');</script>";
				}
			}
		}
		else
		{
			//to insert salary record
			$sql = "INSERT INTO salary(empid,salarymonth,noworkingdays,daysworked,salary,deduction,bonus,ot,date,status) VALUES('$_POST[empid]','$_POST[salmonth]','$_POST[nonwrk]','$_POST[wrk]','$_POST[sal]','$_POST[deduct]','$_POST[bonus]','$_POST[otsalary]','$_POST[date]','$_POST[status]')";
			if(!mysqli_query($connection,$sql))
			{
				echo "Error in insert statement". mysqli_error($connection);
			}
			else
			{
				$lastinsid= mysqli_insert_id($connection);
				echo "<script>alert('Employee Salary record inserted successfully..'); </script>";
				if($_POST[status] != "Pending")
				{
				echo "<script>window.location.assign('salaryreport.php?reportid=$lastinsid');</script>";
				}
				else
				{
					echo "<script>window.location.assign('salary.php');</script>";
				}				
			}
		}
}
if(isset($_GET[editid]))
{
	//to retrieve salary records
	$sql0  = "SELECT *  FROM salary where salaryid='$_GET[editid]'";
	$qsql0 = mysqli_query($connection,$sql0);
	$rs0 = mysqli_fetch_array($qsql0);
	
	$sql1  = "SELECT salarytype  FROM employee where empid='$rs0[empid]'";
	$qsql1 = mysqli_query($connection,$sql1);
	while($rs1 = mysqli_fetch_array($qsql1))
	{
		$salary=$rs1[salarytype].'-salary';
	}
	 		$sql1  = "SELECT * FROM employee WHERE empid='$rs0[empid]'";
			$qsql1 = mysqli_query($connection,$sql1);
			$rs1 = mysqli_fetch_array($qsql1);
			if($rs1[salarytype] == "Monthly")
			{
				$totalsal = $rs0[salary]  + $rs0[bonus] + $rs0[ot] - $rs0[deduction];
			}
			else
			{
				$totalsal = $rs0[salary] * $rs0[daysworked] + $rs0[bonus] + $rs0[ot] - $rs0[deduction];
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
							<h2 align="center">salary	</h2>
					      <form method="post" action="" name="frmsalary" onsubmit="return validatesalary()">
                            <div align="center">
                              <table width="593" height="416" border="1" class="tftable">
                                <tr>
                                  <th width="222" scope="row">Employee Name<font color="#FF0000">*</font></th>
                                  <td width="292"><label for="empname"></label>
                                    <select name="empid" onchange="valsalary(this.value)" >
                                      <option value="">Select</option>
                                      <?php
										$sql = "SELECT *  FROM employee where status='Active'";
										if(!$qsql = mysqli_query($connection,$sql))
										{
											echo mysqli_error($connection);
										}
										while($rs = mysqli_fetch_array($qsql))
										{
											if($rs0[empid] == $rs[empid])
											{
									   		 echo "<option value='$rs[empid]'selected>$rs[empname] - $rs[designation]</option>";
											}
											echo "<option value='$rs[empid]'>$rs[empname] - $rs[designation]</option>";
										}
									?>
                                    </select>
                                  </td>
                                </tr>
                                <tr>
                                  <th scope="row"><input type="text" id="saltype" size="10" value="<?php echo $salary; ?>" readonly="readonly" 
                                  style="font-size:12px;background-color:#acc8cc;border:0px;text-align:center; font-weight:inherit; color:inherit" />
                                  <input type="hidden" name="msalarytype" id="msalarytype" /> </th>
                                  <td>
                                    <input type="text" name="sal" id="sal" value="<?php echo $rs0[salary]; ?>" readonly="readonly"                        
                                    placeholder="Basic Salary" 
                                    onchange="calculatesal(sal.value,deduct.value,bonus.value,otsalary.value,msalarytype.value,wrk.value)" />
                                  </td>
                                </tr> 
                                <tr>
                                  <th scope="row">Salary Month<font color="#FF0000">*</font></th>
                                  <td><label for="salmonth"></label>
                                  <input type="month" name="salmonth" id="salmonth" value="<?php echo $rs0[salarymonth]; ?>"
                                   max="<?php echo date("Y-m");?>" min="<?php echo date("2010-01");?>" ></td>
                                </tr>
                                <tr>
                                  <th scope="row">No. of. working days<font color="#FF0000">*</font></th>
                                  <td><label for="nonwrk"></label>
                                 <input type="number" name="nonwrk" id="nonwrk" value="<?php echo $rs0[noworkingdays]; ?>" placeholder="Count"
                                 onchange="calculatesal(sal.value,deduct.value,bonus.value,otsalary.value,msalarytype.value,wrk.value)"
                                 onkeyup="isNumeric(document.getElementById('nonwrk'), 'Only Numeric Values are Allowed')" max="31" min="0" >
                                 </td>
                                </tr>
                                <tr>
                                  <th scope="row">No. of. Days Worked <font color="#FF0000">**</font></th>
                                  <td><label for="wrk"></label>
                                  <input type="number" name="wrk" id="wrk" value="<?php echo $rs0[daysworked]; ?>" placeholder="Count"       
                                  onchange="calculatesal(sal.value,deduct.value,bonus.value,otsalary.value,msalarytype.value,wrk.value)" 
                                  onkeyup="isNumeric(document.getElementById('wrk'), 'Only Numeric Values are Allowed')" max="31" min="0" >
                                  </td>
                                </tr>
                                <tr>
                                  <th scope="row">Deduction</th>
                                  <td><label for="deduct"></label>
                                  <input name="deduct" type="text" id="deduct" placeholder="Deduction In Salary"   
                                  onchange="calculatesal(sal.value,deduct.value,bonus.value,otsalary.value,msalarytype.value,wrk.value)" 
                                  onkeyup="isFloat(document.getElementById('deduct'), 'Only Decimal Values are Allowed')" 
                                  value="<?php echo $rs0[deduction]; ?>" maxlength="7">
                                  </td>
                                </tr>
                                <tr>
                                  <th scope="row">Bonus</th>
                                  <td><label for="bonus"></label>
                                  <input name="bonus" type="text" id="bonus"  placeholder="Bonus"                      
                                  onchange="calculatesal(sal.value,deduct.value,bonus.value,otsalary.value,msalarytype.value,wrk.value)" 
                                  onkeyup="isFloat(document.getElementById('bonus'), 'Only Decimal Values are Allowed')" 
                                  value="<?php echo $rs0[bonus]; ?>" maxlength="7">
                                  </td>
                                </tr>
                                <tr>
                                  <th scope="row">Overtime Salary</th>
                                  <td><input name="otsalary" type="text" id="otsalary"  placeholder="Overtime salary"    
                                  onchange="calculatesal(sal.value,deduct.value,bonus.value,otsalary.value,msalarytype.value,wrk.value)" 
                                  onkeyup="isFloat(document.getElementById('otsalary'), 'Only Decimal Values are Allowed')" 
                                  value="<?php echo $rs0[ot]; ?>" maxlength="7" />
                                  </td>
                                </tr>
                                <tr>
                                  <th scope="row">Grand Total <font color="#FF0000">*</font></th>
                                  <td><input type="text" name="grandtotal" id="grandtotal" value="<?php 
								  echo $totalsal ; ?>"  readonly="readonly" placeholder="Grand Total"  /></td>
                                </tr>
                                <tr>
                                  <th scope="row">Date <font color="#FF0000">*</font></th>
                                  <td><input type="date" name="date" value="<?php echo $rs0[date]; ?>" max="<?php echo date("Y-m-d");?>" 
                            min="<?php echo date("2010-01-01");?>" ></td>
                                </tr>
                                <tr>
                                  <th scope="row">Status <font color="#FF0000">*</font></th>
                                  <td><label for="status"></label>
                                    <select name="status" id="status" >
                                    <option value="">Select</option>
                                      <?php
								  $arr = array("Paid","Pending");
								  foreach($arr as $val)
								  {
									  if($val == $rs0[status])
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
                              <div align="right"><font color="#FF0000">**  Required Only for Daily Salary Type  </font></div>                            
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
function validatesalary()
{
	if(document.frmsalary.empid.value == "")
	{
		alert("Employee name should not be empty..");
		document.frmsalary.empid.focus();
		return false;
	}
	else if(document.frmsalary.salmonth.value == "")
	{
		alert("Salary Month should not be empty..");
		document.frmsalary.salmonth.focus();
		return false;
	}
	else if(document.frmsalary.nonwrk.value == "")
	{
		alert("No. of. working days should not be empty..");
		document.frmsalary.nonwrk.focus();
		return false;
	}
	else if(document.frmsalary.msalarytype.value == "Daily" && document.frmsalary.wrk.value == "")
	{
		alert("Days Worked should not be empty..");
		document.frmsalary.wrk.focus();
		return false;
	}
	else if(document.frmsalary.nonwrk.value < document.frmsalary.wrk.value) 
	{
		alert("Number of Days Worked should be less than Number of working days.");
		return false;
	}
	else if(document.frmsalary.grandtotal.value == "")
	{
		alert("Grand Toatal should not be empty..");
		return false;
	}
	else if(document.frmsalary.date.value == "")
	{
		alert("Salary Date should not be empty..");
		document.frmsalary.date.focus();
		return false;
	}
	else if(document.frmsalary.status.value == "")
	{
		alert("Salary status should not be empty..");
		document.frmsalary.status.focus();
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
function isNumeric(elem, helperMsg){
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

function valsalary(empid) {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				var response_arr = xmlhttp.responseText.split("{{}}"); 
				document.getElementById("saltype").value = response_arr[1] + " Salary";
				document.getElementById("msalarytype").value = response_arr[1];
				document.getElementById("sal").value = response_arr[0];
				document.getElementById("deduct").value = 0;
				document.getElementById("bonus").value = 0;
				document.getElementById("otsalary").value = 0;				  
            }
        }
        xmlhttp.open("GET","ajaxsalary.php?empid="+empid,true);
        xmlhttp.send();
    }
function calculatesal(sal,deduct,bonus,otsalary,msalarytype,wrk)
{ 
	if(msalarytype == "Monthly")
	{
	var totalsal = (parseFloat(sal)  + parseFloat(bonus) + parseFloat(otsalary)) - parseFloat(deduct);
	document.getElementById("grandtotal").value = totalsal;
	}
	else
	{
	var totalsal = (parseFloat(sal) * parseFloat(wrk)) + parseFloat(bonus) + parseFloat(otsalary) - parseFloat(deduct);
	document.getElementById("grandtotal").value = totalsal;
	}
}

</script>