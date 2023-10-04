<?php
include("header.php");
//connect to the database
include("connection.php");
//to delete stock records
$sql = "DELETE FROM stock WHERE productionid='0'";
if(!mysqli_query($connection,$sql))
{
	echo "Error in DELETE statement". mysqli_error($connection);
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
							<h2 align="center">Production </h2>
					      <form method="post"  name="frmproduction" action="productionreport.php">
                          <div align="center">
                            <table width="695" height="271" border="1" class="tftable">
                              <tr>
                                <th width="280" scope="col">Available Sugar Stock in KG</th>
                                <?php
								$sql1  = "SELECT sum(qty) FROM purchase";
								$qsql1 = mysqli_query($connection,$sql1);
								$rs1 = mysqli_fetch_array($qsql1);
							
								$sql3  = "SELECT  sum(godownstkkg)  FROM production ";
								$qsql3 = mysqli_query($connection,$sql3);
								$rs3 = mysqli_fetch_array($qsql3);
		
								$stockqty = $rs1[0] - $rs3[0];
								?>
                                <td width="399" scope="col"><input type="text" name="availablestock" id="availablestock" 
                                value="<?php echo $stockqty; ?>" placeholder="Stock" size="10"  readonly="readonly"/>
                                </td>
                              </tr>
                              <tr>
                                <th scope="row">Sugarcane Used for Production in KG<font color="#FF0000">*</font></strong></th>
                                <td><label for="godwnkg"></label>
                                <input name="godwnkg" type="text" id="godwnkg" placeholder="Quantity In Kg"  
                                onkeyup="isFloat(document.getElementById('godwnkg'), 'Only Decimal Values are Allowed')" value="" maxlength="6" />
                                </td>
                              </tr>
                              <tr>
                                <th scope="row">Sugarcane Used for Production in No<font color="#FF0000">*</font></strong></th>
                                <td><label for="godwnno"></label>
                                <input name="godwnno" type="text" id="godwnno" placeholder="Quantity In Number" 
                                onchange="calculatetotal(godwnno.value,wstno.value,drpcno.value)" 
                                  onkeyup="isFloat(document.getElementById('godwnno'), 'Only Decimal Values are Allowed')"  value="" maxlength="6"/>
                                </td>
                              </tr>
                              <tr>
                                <th scope="row">Waste in No<font color="#FF0000">*</font></th>
                                <td><label for="wstno"></label>
                                <input name="wstno" type="text" id="wstno" placeholder="Quantity In Number" 
                                onchange="calculatetotal(godwnno.value,wstno.value,drpcno.value)" 
                                onkeyup="isFloat(document.getElementById('wstno'), 'Only Decimal Values are Allowed')"  value="" maxlength="6" />   
                                </td>
                              </tr>
                              <tr>
                                <th scope="row">Dry piece in No<font color="#FF0000">*</font></th>
                                <td><label for="drpcno"></label>
                                <input name="drpcno" type="text" id="drpcno" placeholder="Quantity In Number" 
                                onchange="calculatetotal(godwnno.value,wstno.value,drpcno.value)" 
                                onkeyup="isFloat(document.getElementById('drpcno'), 'Only Decimal Values are Allowed')"  value="" maxlength="6"/>   
                                </td>
                              </tr>
                              <tr>
                                <th scope="row">Net Proccessing in No<font color="#FF0000">*</font></strong></th>
                                <td><label for="ntprno"></label>
                                <input name="ntprno" type="text" id="ntprno" placeholder="Quantity In Number"  value="" maxlength="6" readonly="readonly"/> 
                                </td>
                              </tr>
                              <tr>
                                <th scope="row">Brokenpiece in KG<font color="#FF0000">*</font></th>
                                <td><label for="brkpcno"></label>
                                <input name="brkpcno" type="text" id="brkpcno" 
                                placeholder="Quantity In Kg" 
                                onkeyup="isFloat(document.getElementById('brkpcno'), 'Only Decimal Values are Allowed')" value="" maxlength="6"/>
                                </td>
                              </tr>
                              <tr>
                                <th scope="row">Net Proccessing in KG<font color="#FF0000">*</font></strong></th>
                                <td><label for="ntprkg"></label>
                                  <input name="ntprkg" type="text" id="ntprkg"  
                                  placeholder="Quantity In Kg" 
                                  onkeyup="isFloat(document.getElementById('ntprkg'), 'Only Decimal Values are Allowed')" value="" maxlength="6"/>
                                 </td>
                              </tr>
                              <tr>
                                <th scope="row" height="31"><div align="center"> Date<font color="#FF0000">*</font></strong></div></td>
                                <td><input type="date" name="date" id="date" value="" max="<?php echo date("Y-m-d");?>" 
                            min="<?php echo date("2010-01-01");?>" /></td>
                              </tr>
                            </table>
                          </div>
                          <hr align="center" width="700" />
                          <div align="center">
                            <table width="695" border="1" class="tftable">
                              <tr>
                                <th width="280" height="23" scope="col">Product Name<font color="#FF0000">*</font></th>
                                <th width="230" scope="col">Quantity<font color="#FF0000">*</font></th>
                                <th width="163" scope="col">&nbsp;</th>
                              </tr>
                              <tr>
                                <td height="28"><div align="center">
                                 <select name="prdname" id="prdname"  >
                                 <option value="">Select</option>
                                 <?php
									  $sql ="SELECT * FROM 	product where status='Active'";
									  $qsql = mysqli_query($connection,$sql);
									  while($rs = mysqli_fetch_array($qsql))
									  {
										  echo "<option value='$rs[productid]'>$rs[productname]-$rs[productcode]-$rs[qtytype]</option>";
									  }
								 ?>
                                 </select>
                                 </div></td>
                                 <td><div align="center">
                                  <input name="qty" type="text" id="qty" placeholder="Quanitity" 
                                  onkeyup="isFloat(document.getElementById('qty'), 'Only Decimal Values are Allowed')"  size="6" maxlength="6"/>
                                </div></td>
                                 <td>
                                  <div align="center">
                                    <input type="button" name="submit" id="submit" value="Add" onclick="addrecords(prdname.value,qty.value)"/>
                                  </div>
                                  </td>
                                </tr>
                               </table>
                              </div>
                              <hr align="center" width="700" />
                            <div id="ajaxdisplayrecords"></div>
                          <p>&nbsp;</p>
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

<script>
//validation for mandatory fields
function addrecords(prodid,qty)
{
	var godwnkga = parseFloat(document.frmproduction.godwnkg.value);
	var availablestock = parseFloat(document.frmproduction.availablestock.value);
	if(document.frmproduction.availablestock.value <=0)
	{
		alert("Sugar not available in stock");
		return false;
	}
	else if(document.frmproduction.godwnkg.value =="" )
	{
		alert("Sugar Used for Production in KG should not be empty..");
		document.frmproduction.godwnkg.focus();
		return false;		
	}
	else if(availablestock < godwnkga)
	{
		alert("Sugar quantity used must be less than or equal to available quantity");
		document.frmproduction.godwnkg.focus();
		return false;
	}
	else if(document.frmproduction.godwnno.value == "")
	{
		alert("Sugar Used for Production in No should not be empty..");
		document.frmproduction.godwnno.focus();
		return false;
	}
	else if(document.frmproduction.wstno.value == "")
	{
		alert("Waste in No should not be empty..");
		document.frmproduction.wstno.focus();
		return false;
	}
	else if(document.frmproduction.drpcno.value == "")
	{
		alert("Dry piece in No not be empty..");
		document.frmproduction.drpcno.focus();
		return false;		
	}
		else if(document.frmproduction.ntprno.value == 0)
	{
		alert("Net Proccessing in No should not be Zero..");
		document.frmproduction.ntprno.focus();
		return false;
	}
	else if(document.frmproduction.brkpcno.value == "")
	{
		alert("Brokenpiece in KG should not be empty..");
		document.frmproduction.brkpcno.focus();
		return false;
	}
	else if(document.frmproduction.ntprkg.value == "")
	{
		alert("Net Proccessing in KG should not be empty..");
		document.frmproduction.ntprkg.focus();
		return false;		
	}
	else if(document.frmproduction.date.value == "")
	{
		alert("Production Date should not be empty..");
		document.frmproduction.date.focus();
		return false;
	}
	else if(document.frmproduction.prdname.value == "")
	{
		alert("Product Name should not be empty..");
		document.frmproduction.prdname.focus();
		return false;
	}
	else if(document.frmproduction.qty.value == "")
	{
		alert("Quantity should not be empty..");
		document.frmproduction.qty.focus();
		return false;		
	}
    else

		{ 
			if (window.XMLHttpRequest) {
				// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp = new XMLHttpRequest();
			} else {
				// code for IE6, IE5
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
				xmlhttp.onreadystatechange = function() {
					if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
						document.getElementById("prdname").value ="";
						document.getElementById("qty").value = "";
						document.getElementById("ajaxdisplayrecords").innerHTML = xmlhttp.responseText;
					}
				}
		var getlink = "ajaxaddproduction.php?prodid="+prodid+"&qty="+qty+"&gettype=insert";
        xmlhttp.open("GET",getlink,true);
        xmlhttp.send();
}
}

function delrecord(stockid)
		{ 		
			if (window.XMLHttpRequest) {
				// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp = new XMLHttpRequest();
			} else {
				// code for IE6, IE5
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
				xmlhttp.onreadystatechange = function() {
					if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
						document.getElementById("ajaxdisplayrecords").innerHTML = xmlhttp.responseText;																							
					}
				}
			var getlink = "ajaxaddproduction.php?stockid="+stockid+"&gettype=delete";
			xmlhttp.open("GET",getlink,true);
			xmlhttp.send();
		}
		
		
function calculatetotal(godwnno,wstno,drpcno)
{   
	var total = (parseFloat(godwnno)-parseFloat(wstno)-parseFloat(drpcno));
	document.getElementById("ntprno").value = total;
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
