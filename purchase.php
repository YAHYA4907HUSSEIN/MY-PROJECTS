<?php
include("header.php");
//connect to the database
include("connection.php");
//to delete purchase records
$sql = "DELETE FROM purchase WHERE billingid='0'";
if(!mysqli_query($connection,$sql))
{
	echo "Error in Delete statement". mysqli_error($connection);
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
							<h2 align="center">Purchase </h2>
					     	<form method="post" name="frmpurchase" action="purchasereport.php">
                          	<table width="878" height="63" border="1" class="tftable">
                            <tr>
                            <th width="209" height="27" scope="col"><strong>Seller  Details <font color="#FF0000">*</font></strong></th>
                            <td width="619" scope="col">
                            <select name="seller" id="seller"  onchange="loadseller(this.value)" >
                            <option value="">Select</option>
                            <?php
                            $sql1 ="SELECT * FROM seller where status='Active'";
                            $qsql1 = mysqli_query($connection,$sql1);
                                while($rs1 = mysqli_fetch_array($qsql1))
                                {
                                    echo "<option value='$rs1[sellerid]'>$rs1[sellername] - $rs1[mobile_no]</option>";
                                }
                            ?>
                            </select>
                            <div id="ajaxseller">
                            </div></td>
                            </tr>
                            <tr>
                            <th height="28"><strong> Date <font color="#FF0000">*</font></strong></th>
                            <td><input type="date" name="purdate" id="purdate" value="" max="<?php echo date("Y-m-d");?>" 
                            min="<?php echo date("2010-01-01");?>" /></td>
                            </tr>
                            </table>
                            <hr align="left" width="880" />
                          	<table width="878" height="57" border="1" class="tftable">
                            <tr>
                              <th width="129" scope="col">Sugarcane type<font color="#FF0000">*</font></th>
                              <th width="123" scope="col">Price</th>
                              <th width="144" scope="col">Quantity in KG<font color="#FF0000">*</font></th>
                              <th width="227" scope="col">Total </th>
                              <th width="62" scope="col">&nbsp;</th>
                            </tr>
                          
                            <tr>
                              <td><select name="sugarcanetype" id="sugarcanetype"  onchange="displayprice(this.value)">
                                <option value="">Select</option>
                                <?php
									  $sql ="SELECT * FROM 	sugarcanetype where status='Active'";
									  $qsql = mysqli_query($connection,$sql);
									  while($rs = mysqli_fetch_array($qsql))
									  {
										  echo "<option value='$rs[sugarcane_typeid]'>$rs[sugarcane_type]	</option>";
									  }
								  ?>
                              </select></td>
                              <td><input type="text" name="sugprice" id="sugprice" value=""  placeholder="Price" readonly="readonly"
                              size="7"/>
                              </td>
                              <td><input name="qty" type="text" id="qty"  placeholder="Quanitity" 
                              onchange="calculatetotal(sugprice.value,qty.value,)" 
                              onkeyup="isFloat(document.getElementById('qty'), 'Only Decimal Values are Allowed')" value="" maxlength="6"/>
                              </td>
                              <td><input type="text" name="totalprice" id="totalprice" value=""  
                              placeholder="Total" readonly="readonly" />
                              </td>
                              <td><input type="button" name="Button" id="submit" value="Add" onclick="addrecord(sugarcanetype.value, sugprice.value, qty.value)"/>
                              </td>
                            </tr>
                            </table>
                            <hr align="left" width="880" />
                            <div id="displayrecords"></div>
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
//To calculate Total piece for the quantity purchased
function calculatetotal(sugprice,qty)
{ 
	var totalprice = sugprice * qty;
	document.getElementById("totalprice").value = totalprice;
}

function displayprice(sugarcane_typeid) { 
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }   
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				document.getElementById("sugprice").value =  xmlhttp.responseText;
				
            }
        }
        xmlhttp.open("GET","ajaxsugarcanetype.php?sugarcane_typeid="+sugarcane_typeid,true);
        xmlhttp.send();
}
//validation for mandatory fields
function addrecord(sugarcane_type,sugprice,qty)
{
	if(document.frmpurchase.seller.value == "")
	{
		alert("Seller name should not be empty..");
		document.frmpurchase.seller.focus();
		return false;
	}
	else if(document.frmpurchase.purdate.value == "")
	{
		alert("Purchase Date should not be empty..");
		document.frmpurchase.purdate.focus();
		return false;
	}
	else if(document.frmpurchase.sugarcanetype.value == "")
	{
		alert("sugar Type should not be empty..");
		document.frmpurchase.sugarcanetype.focus();
		return false;
	}
	else if(document.frmpurchase.qty.value == "")
	{
		alert("Quantity should not be empty..");
		document.frmpurchase.qty.focus();
		return false;		
	}
	else if(document.frmpurchase.totalprice.value == 0)
	{
		alert("Total Price should not be Zero");
		document.frmpurchase.totalprice.focus();
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
						document.getElementById("displayrecords").innerHTML = xmlhttp.responseText;
						document.getElementById("sugarcane_type").value = "";
						document.getElementById("sugprice").value = "";
						document.getElementById("qty").value = "";
						document.getElementById("totalprice").value = "";																								
					}
				}
		var getlink = "ajaxaddpurchase.php?sugarcane_type="+sugarcane_type+"&qty="+qty+"&sugprice="+sugprice+"&gettype=insert";
        xmlhttp.open("GET",getlink,true);
        xmlhttp.send();
		}
}
function delrecord(purchaseid)
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
						document.getElementById("displayrecords").innerHTML = xmlhttp.responseText;																							
					}
				}
		var getlink = "ajaxaddpurchase.php?purchaseid="+purchaseid+"&gettype=delete";
        xmlhttp.open("GET",getlink,true);
        xmlhttp.send();
}
function loadseller(sellerid)
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
						document.getElementById("ajaxseller").innerHTML = xmlhttp.responseText;																							
					}
				}
		var getlink = "ajaxseller.php?sellerid="+sellerid;
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