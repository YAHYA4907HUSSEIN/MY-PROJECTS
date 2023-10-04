<?php
include("header.php");
//connect to the database
include("connection.php");
if(isset($_POST[submit]))
{
	//upload files
	$cocimage = rand().$_FILES["file"]["name"];
	move_uploaded_file($_FILES["file"]["tmp_name"],"cocimage/".$cocimage);
	
		if(isset($_GET[editid]))
		{
			//to update sugarcanetype records
			$sql = "UPDATE sugarcanetype SET sugarcane_type='$_POST[sugarcanetype]',sugarcaneprice='$_POST[price]',sugarcanedescription='$_POST[sugarcanedescription]',sugarcaneimage='$cocimage',status='$_POST[status]' WHERE sugarcane_typeid='$_GET[editid]'";
			if(!mysqli_query($connection,$sql))
			{
				echo "Error in Update statement". mysqli_error($connection);
			}
			else
			{
				echo "<script>alert('Sugarcane type record updated successfully..'); </script>";
				echo "<script>window.location.assign('viewsugarcanetype.php');</script>";
			}
		}
		else
		{
		//to insert sugarcanetype records
		$sql = "INSERT INTO sugarcanetype(sugarcane_type,sugarcaneprice,sugarcanedescription,sugarcaneimage,status) VALUES('$_POST[sugarcanetype]','$_POST[price]','$_POST[sugarcanedescription]','$cocimage','$_POST[status]')";
		if(!mysqli_query($connection,$sql))
		{
			echo "Error in insert statement". mysqli_error($connection);
		}
		else
		{
			echo "<script>alert('Sugarcane type record inserted successfully..'); </script>";
			echo "<script>window.location.assign('sugarcanetype.php');</script>";
		}
	}
}

if(isset($_GET[editid]))
{
	//to retrieve sugarcanetype records
$sql  = "SELECT *  FROM sugarcanetype where sugarcane_typeid='$_GET[editid]'";
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
							<h2 align="center">Sugarcane Type</h2>
					      <form action="" method="post" enctype="multipart/form-data" name="frmsugarcanetype" onsubmit="return validatesugarcanetype()">
                            <div align="center">
                              <table width="572" height="307" border="1" class="tftable">
                                <tr>
                                  <th scope="row">Name <font color="#FF0000">*</font></th>
                                  <td><label for="qtytype"></label>
                                  <input name="sugarcanetype" type="text" id="sugarcanetype"            
                                  placeholder="Type of Sugarcane" 
                                  onkeyup="isAlpha(document.getElementById('sugarcanetype'), 'Numbers And Special Characters are Not Allowed')" 
                                  value="<?php echo $rs[sugarcane_type]; ?>" size="20" maxlength="15"> 
                                  </td>
                                </tr>
                                <tr>
                                  <th width="222" scope="row">Price <font color="#FF0000">*</font></th>
                                  <td width="292"><label for="price"></label>
                                  <input name="price" type="text"  id="price"
                                  placeholder="Price" onkeyup="isFloat(document.getElementById('price'), 'Only Decimal Values are Allowed')" 
                                  value="<?php echo $rs[sugarprice]; ?>" size="8" maxlength="6">    
                                  </td>
                                </tr>
                                <tr>
                                  <th scope="row">Description</th>
                                  <td>
                                    <label for="sugarcanedescription"></label>
                                  <textarea name="sugarcanedescription" id="sugarcanedescription"><?php echo $rs[sugarcanedescription];?></textarea>
                                  </td>
                                </tr>
                                <tr>
                                  <th scope="row">Image</th>
                                  <td>
                                    <input type="file" name="file" id="file"> <br />
                                    <?php
								if(isset($_GET[editid]))
								{
								?>
                                    <img src="cocimage/<?php echo $rs[sugarcaneimage];?>" height="50" width="50" />
                                    <?php
								}
								?>
                                  </td>
                                </tr>
                                <tr>
                                  <th scope="row">Status <font color="#FF0000">*</font></th>
                                  <td>
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
function validatesugarcanetype()
{
	if(document.frmsugarcanetype.sugarcanetype.value == "")
	{
		alert("Coconut name should not be empty..");
		document.frmsugarcanetype.sugarcanetype.focus();
		return false;
	}
	else if(document.frmsugarcanetype.price.value == "")
	{
		alert("Price should not be empty..");
		document.frmsugarcanetype.price.focus();
		return false;
	}
	else if(document.frmsugarcanetype.status.value == "")
	{
		alert("Product status should not be empty..");
		document.frmsugarcanetype.status.focus();
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

</script>