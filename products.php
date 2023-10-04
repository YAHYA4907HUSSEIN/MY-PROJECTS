<?php
include("header.php");
//connect to the database
include("connection.php");
if(isset($_POST[submit]))
{
	//to upload files
	$prdimage = rand().$_FILES["file"]["name"];
	move_uploaded_file($_FILES["file"]["tmp_name"],"cocimage/".$prdimage);
		if(isset($_GET[editid]))
		{
			//to update product records
			$sql = "UPDATE product SET productname='$_POST[prdname]',productcode='$_POST[prdcode]',productimage='$prdimage',productprice='$_POST[price]',taxamt='$_POST[taxamt]',qtytype='$_POST[qty]',productdiscription='$_POST[description]',status='$_POST[status]' WHERE productid='$_GET[editid]'"; 
			if(!mysqli_query($connection,$sql))
			{
				echo "Error in Update statement". mysqli_error($connection);
			}
			else
			{
				echo "<script>alert('Product record updated successfully..'); </script>";
				echo "<script>window.location.assign('viewproducts.php');</script>";
			}
		}
		else
		{	
		//to insert product records
			$sql = "INSERT INTO product(productname,productcode,productimage,productprice,taxamt,qtytype,productdiscription,status) VALUES('$_POST[prdname]','$_POST[prdcode]','$prdimage','$_POST[price]','$_POST[taxamt]','$_POST[qty]','$_POST[description]','$_POST[status]')";
			if(!mysqli_query($connection,$sql))
			{
				echo "Error in insert statement". mysqli_error($connection);
			}
			else
			{
				echo "<script>alert('Product record inserted successfully..'); </script>";
				echo "<script>window.location.assign('products.php');</script>";
			}
		}
}
if(isset($_GET[editid]))
{
	//to retrieve product records
$sql  = "SELECT *  FROM product where productid='$_GET[editid]'";
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
							<h2 align="center">Products </h2>
					      <form method="post" action="" enctype="multipart/form-data" name="frmproducts" onsubmit="return validateproducts()">
                            <div align="center">
                              <table width="557" height="380" border="1" class="tftable">
                                <tr>
                                  <th width="222" scope="row"> Name <font color="#FF0000">*</font></th>
                                  <td width="292"><label for="prdname"></label>
                                  <input name="prdname" type="text" id="prdname" placeholder="Name"  
                                  onkeyup="isAlpha(document.getElementById('prdname'), 'Numbers And Special Characters are Not Allowed')" 
                                  value="<?php echo $rs[productname]; ?>" maxlength="20">
                                  </td>
                                </tr>
                                <tr>
                                  <th scope="row"> Code</th>
                                  <td><label for="prdcode"></label>
                                    <input name="prdcode" type="text" id="prdcode" 
                                    placeholder="Code" value="<?php echo $rs[productcode]; ?>" size="8" maxlength="6" 
                                    onkeyup="isAlphanumeric(document.getElementById('prdcode'), 'Special Characters are Not Allowed')">
                                  </td>
                                </tr>
                                <tr>
                                  <th scope="row">Image</th>
                                  <td><label for="file"></label>
                                    <input type="file" name="file" id="file"> <br />
                                    <?php
								if(isset($_GET[editid]))
								{
								?>
                                    <img src="cocimage/<?php echo $rs[productimage];?>" height="50" width="50" />
                                    <?php
								}
								?>
                                  </td>
                                </tr>
                                <tr>
                                  <th scope="row">Price <font color="#FF0000">*</font></th>
                                  <td><label for="price"></label>
                                    <input name="price" type="text" id="price"  
                                    placeholder="Price" onkeyup="isFloat(document.getElementById('price'), 'Only Decimal Values are Allowed')" 
                                    value="<?php echo $rs[productprice]; ?>" size="8" maxlength="6" >
                                  </td>
                                </tr>
                                <tr>
                                  <th scope="row">Tax % <font color="#FF0000">*</font></th>
                                  <td><label for="taxamt"></label>
                                    <input name="taxamt" type="text" id="taxamt"  
                                    placeholder="Tax %" onkeyup="isFloat(document.getElementById('taxamt'), 'Only Decimal Values are Allowed')" 
                                    value="<?php echo $rs[taxamt]; ?>" size="8" maxlength="5"/>
                                  </td>
                                </tr>
                                <tr>
                                  <th scope="row">Quantity Type <font color="#FF0000">*</font></th>
                                  <td><label for="qty"></label>
                                    <input name="qty" type="text" id="qty" placeholder="Quantity Type" 
                                    onkeyup="isAlphanumeric(document.getElementById('qty'), 'Special Characters are Not Allowed')" 
                                    value="<?php echo $rs[qtytype]; ?>" size="8" maxlength="10">
                                  </td>
                                </tr>
                                <tr>
                                  <th scope="row">Description</th>
                                  <td><textarea name="description" id="description"><?php echo $rs[productdiscription];?></textarea></td>
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
function validateproducts()
{
	if(document.frmproducts.prdname.value == "")
	{
		alert("Product name should not be empty..");
		document.frmproducts.prdname.focus();
		return false;
	}
	else if(document.frmproducts.price.value == "")
	{
		alert("Price should not be empty..");
		document.frmproducts.price.focus();
		return false;
	}
	else if(document.frmproducts.taxamt.value == "")
	{
		alert("Tax % should not be empty..");
		document.frmproducts.taxamt.focus();
		return false;
	}
	else if(document.frmproducts.taxamt.value > 100)
	{
		alert("Tax % should not be Greater than 100..");
		document.frmproducts.taxamt.focus();
		return false;
	}
	else if(document.frmproducts.qty.value == "")
	{
		alert("Quantity Type should not be empty..");
		document.frmproducts.qty.focus();
		return false;
	}

	else if(document.frmproducts.status.value == "")
	{
		alert("Product status should not be empty..");
		document.frmproducts.status.focus();
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