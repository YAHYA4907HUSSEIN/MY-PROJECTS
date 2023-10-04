<?php
include("header.php");
//connect to the database
include("connection.php");
//to delete sales records
$sql = "DELETE FROM sales WHERE billingid='0'";
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
							<h2 align="center">Sales </h2>
					      	<form method="post" name="frmsales" action="salesreport.php">
                          	<table width="878" height="69" border="1" class="tftable">
                            <tr>
                            <th width="209" scope="col"><strong>Customer Details <font color="#FF0000">*</font></strong></th>
                            <td width="619" scope="col">
                            <select name="customer" id="customer"  onchange="loadcustomer(this.value);">
                            <option value="">Select</option>
                            <?php
							  	  $sql1 ="SELECT * FROM customer where status='Active'";
								  $qsql1 = mysqli_query($connection,$sql1);
								  while($rs1 = mysqli_fetch_array($qsql1))
								  {
									  echo "<option value='$rs1[customerid]'>$rs1[customername] - $rs1[mobile_no]</option>";
								  }
							?>
      						</select>
                            <div id="ajaxcustomer"></div></td>
                            </tr>
                            <tr>
                            <th height="30"><strong> Date<font color="#FF0000">*</font></strong></th>
                            <td><input type="date" name="salesdate" id="salesdate" value="" max="<?php echo date("Y-m-d");?>" 
                            min="<?php echo date("2010-01-01");?>"  /></td>
                            </tr>
                            </table>
                            <hr align="left" width="880" />
                          	<table width="878" height="61" border="1" class="tftable1">
                              <tr>
                              <th width="128" scope="col">Product Name<font color="#FF0000">*</font></th>
                              <th width="105" scope="col">Available stock</th>
                              <th width="98" scope="col">Product Price</th>
                              <th width="50" scope="col">Tax %</th>
                              <th width="81" scope="col">Quantity<font color="#FF0000">*</font></th>
                              <th width="67" scope="col">Total</th>
                              <th width="57" scope="col">Tax</th>
                              <th width="83" scope="col">Discount</th>                              
                              <th width="83" scope="col">Total Price</th>
                              <th width="62" scope="col">&nbsp;</th>
                              </tr>
                              <tr>
                              <td><select name="prdname" id="prdname"  onchange="displayprice(this.value)">
                              <option value="">Select</option>
                              <?php
							  $sql0 = "SELECT *  FROM product where status='Active'";
								$qsql0 = mysqli_query($connection,$sql0);
								while($rs0 = mysqli_fetch_array($qsql0))
								{
									$sql1  = "SELECT sum(qty) FROM stock WHERE productid='$rs0[productid]'";
									$qsql1 = mysqli_query($connection,$sql1);
									$rs1 = mysqli_fetch_array($qsql1);
								
									$sql3  = "SELECT  sum(qty)  FROM sales WHERE productid='$rs0[productid]'";
									$qsql3 = mysqli_query($connection,$sql3);
									$rs3 = mysqli_fetch_array($qsql3);
									
									$stockqty = $rs1[0] - $rs3[0];
									if($stockqty > 0)
									  {
										  echo "<option value='$rs0[productid]'>$rs0[productname]-$rs0[productcode]-$rs0[qtytype]</option>";
									  }
								}
                              ?>
                           	  </select>
                              </td>
                              <td><input type="text" name="availablestock" id="availablestock" value="" placeholder="Stock" size="8" 
                              readonly="readonly"/>
                              </td>
                              <td><input type="text" name="productprice" id="productprice" value="" placeholder="Price" size="8" 
                              readonly="readonly"/>
                              </td>
                              <td><input name="taxpercentage" type="text" id="taxpercentage" size="4" placeholder="Tax %" 
                              readonly="readonly" />
                              </td>
                              <td><input name="qty" type="text" id="qty" placeholder="Quanitity" 
                              onchange="calculatetotal(availablestock.value,productprice.value,taxpercentage.value,qty.value,disocuntprice.value)"
                              onkeyup="isFloat(document.getElementById('qty'), 'Only Decimal Values are Allowed')" size="6" maxlength="6" />
                              </td>
                              <td><input name="total" type="text" id="total"  placeholder="Total"  size="8" 
                              readonly="readonly"/>
                              </td>
                              <td><input name="tax" type="text" id="tax" size="6" placeholder="Tax" readonly="readonly"/>
                              <label id='ajaxtax'></label>
                              </td>
                              <td><input name="disocuntprice" type="text" id="disocuntprice" placeholder="Disocunt" 
                              onchange="calculatetotal(availablestock.value,productprice.value,taxpercentage.value,qty.value,disocuntprice.value)" 
                              onkeyup="isFloat(document.getElementById('disocuntprice'), 'Only Decimal Values are Allowed')"  size="7" maxlength="6"/>
                              </td>
                              <td><input name="totalprice" type="text" id="totalprice" placeholder="Total Price"  size="10"  
                              readonly="readonly" />
                              </td>
                              <td><input type="button" name="submit" id="submit" value="Add" onclick="addrecord(prdname.value,availablestock.value,productprice.value,taxpercentage.value,qty.value,total.value,tax.value,totalprice.value,disocuntprice.value)" />
                              </td>
                              </tr>
                            </table>
                            <hr align="left" width="880" />
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

function loadcustomer(customerid)
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
						document.getElementById("ajaxcustomer").innerHTML = xmlhttp.responseText;																							
					}
				}
		var getlink = "ajaxcustomer.php?customerid="+customerid;
        xmlhttp.open("GET",getlink,true);
        xmlhttp.send();
}
function displayprice(productid) { 
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
				document.getElementById("availablestock").value = response_arr[2];
				document.getElementById("productprice").value = response_arr[0];
				document.getElementById("taxpercentage").value =  response_arr[1];				
				  
            }
        }
        xmlhttp.open("GET","ajaxstockpriceproduct.php?productid="+productid,true);
        xmlhttp.send();
}

function calculatetotal(availablestock,productprice,taxpercentage,qty,disocuntprice)
{ 
	var total = productprice * qty;
	document.getElementById("total").value = total;
	var tax = (total*taxpercentage)/100;
	document.getElementById("tax").value = tax;
	var discount = disocuntprice;
	var totalprice = total + tax-discount;
	document.getElementById("totalprice").value = totalprice;
}
//validation for mandatory fields
function addrecord(prodid,availablestock,productprice,taxpercentage,qty,total,tax,totalprice,discountprice)
{

var qty = parseFloat(document.frmsales.qty.value);
var availablestock = parseFloat(document.frmsales.availablestock.value);

	if(document.frmsales.customer.value == "")
	{
		alert("Customer name should not be empty..");
		document.frmsales.customer.focus();
		return false;
	}
	else if(document.frmsales.salesdate.value == "")
	{
		alert("Sales Date should not be empty..");
		document.frmsales.salesdate.focus();
		return false;
	}
	else if(document.frmsales.prdname.value == "")
	{
		alert("Product Name should not be empty..");
		document.frmsales.prdname.focus();
		return false;
	}
	else if(document.frmsales.qty.value == "")
	{
		alert("Quantity should not be empty..");
		document.frmsales.qty.focus();
		return false;		
	}
	else if(qty > availablestock) 
	{
		alert("Sales quantity must be Less than or Equal to available quantity.");
		document.frmsales.qty.focus();
		return false;
	}
	else if(document.frmsales.totalprice.value == 0)
	{
		alert("Total Price should not be Zero");
		document.frmsales.totalprice.focus();
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
						document.getElementById("availablestock").value = "";
						document.getElementById("productprice").value = "";
						document.getElementById("taxpercentage").value = "";
						document.getElementById("qty").value = "";
						document.getElementById("total").value = "";																								
						document.getElementById("tax").value = "";	
						document.getElementById("disocuntprice").value = "";																						
						document.getElementById("totalprice").value = "";	
						document.getElementById("ajaxdisplayrecords").innerHTML = xmlhttp.responseText;
					}
				}
		var getlink = "ajaxaddsales.php?prodid="+prodid+"availablestock="+availablestock+"&productprice="+productprice+"&taxpercentage="+taxpercentage+"&qty="+qty+"&total="+total+"&tax="+tax+"&discountprice="+discountprice+"&totalprice="+totalprice+"&gettype=insert";
        xmlhttp.open("GET",getlink,true);
        xmlhttp.send();
}
}

function delrecord(salesid)
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
		var getlink = "ajaxaddsales.php?salesid="+salesid+"&gettype=delete";
        xmlhttp.open("GET",getlink,true);
        xmlhttp.send();
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
