<div class="3u">
<div id="sidebar2">
<section>
<div class="sbox1">
<div id="widnow">
            	<div id="title_bar" style="background: red;height: 25px;">
            		<h2>Add <small id="button1" style="border:solid 1px; width: 25px;height: 23px;font-size:52px;float:right;cursor:pointer;">+</small></h2>
           		</div><br /><br />
                  	<div id="box1" hidden>
							<ul class="style1">
                            	<li><a href="purchase.php">Purchase</a></li>
                                <li><a href="sales.php">Sales</a></li>
                                <li><a href="production.php">Production</a></li>
                                <li><a href="seller.php">Seller</a></li>
								<li><a href="customer.php">Customer</a></li>
                                <li><a href="products.php">Products</a></li>
								<li><a href="sugarcanetype.php">Sugarcane Type</a></li>
							</ul>
                    </div>
</div>
</div>
                        
<div class="sbox1">
<div id="widnow">
        <div id="title_bar" style="background:red;height: 25px;">
        <h2>View <small id="button2" style="border:solid 1px; width: 25px;height: 23px;font-size:52px;float:right;cursor:pointer;">+</small></h2>
        </div><br /><br />
        <div id="box2" hidden>
							<ul class="style1">
								<li><a href="viewpurchase.php">Purchase</a></li>
                                <li><a href="viewsales.php">Sales</a></li>
                                <li><a href="viewproduction.php">Production</a></li>
                                <li><a href="viewproductstock.php">Stocks</a></li>
                                <li><a href="viewseller.php">Seller</a></li>
                                <li><a href="viewcustomer.php">Customer</a></li>
                                <li><a href="viewproducts.php">Products</a></li>
								<li><a href="viewsugarcanetype.php">Sugarcane Type</a></li>
							</ul>
		</div>
</div>
</div>
                       
                    <div class="sbox2">
               		<div id="widnow">
                         <?php
						session_start();
						error_reporting(0);
						if(isset($_SESSION[adminid]))
						{
						?>
              <div id="title_bar" style="background: red;height: 25px;">
                <h2>Admin <small id="button3" style="border:solid 1px; width: 25px;height: 23px;font-size:52px;float:right;cursor:pointer;">+</small></h2>
              </div><br /><br />
                	 <div id="box3" hidden>
						
							<ul class="style1">
                           		<li><a href="employee.php">Add Employee</a></li>
								<li><a href="expense.php">Add Expense</a></li>
								<li><a href="salary.php">Add Salary</a></li>
								<li><a href="viewemployee.php">View Employee</a></li>
								<li><a href="viewexpense.php">View Expense</a></li>
								<li><a href="viewsalary.php">View Salary</a></li>
                             </ul>
   					 </div>
                    </div>
                    </div>
                        
                <div class="sbox2">
                <div id="widnow">

              <div id="title_bar" style="background: red;height: 25px;">
               <h2>Report <small id="button4" style="border:solid 1px; width: 25px;height: 23px;font-size:52px;float:right;cursor:pointer;">+</small></h2>
              </div> <br /><br />
                	 <div id="box4" hidden>
						
							<ul class="style1">
                            	<li><a href="dailyreport.php">Daily Report</a></li>
                            	<li><a href="monthlyreport.php">Monthly Report</a></li>
                            	<li><a href="yearlyreport.php">Yearly Report</a></li>                          
                            </ul>
                 	  </div>

                        <?php
						}
						?>
                        	
			</div>
			</div>
</section>
</div>
</div>
            
            
<script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js'></script>
<script type='text/javascript'>//<![CDATA[ 
$(window).load(function(){
$("#button1").click(function(){
    if($(this).html() == "-"){
        $(this).html("+");
    }
    else{
        $(this).html("-");
    }
    $("#box1").slideToggle();
});
});//]]>
</script>
<script type='text/javascript'>//<![CDATA[ 
$(window).load(function(){
$("#button2").click(function(){
    if($(this).html() == "-"){
        $(this).html("+");
    }
    else{
        $(this).html("-");
    }
    $("#box2").slideToggle();
});
});//]]>
</script>
<script type='text/javascript'>//<![CDATA[ 
$(window).load(function(){
$("#button3").click(function(){
    if($(this).html() == "-"){
        $(this).html("+");
    }
    else{
        $(this).html("-");
    }
    $("#box3").slideToggle();
});
});//]]>
</script>
<script type='text/javascript'>//<![CDATA[ 
$(window).load(function(){
$("#button4").click(function(){
    if($(this).html() == "-"){
        $(this).html("+");
    }
    else{
        $(this).html("-");
    }
    $("#box4").slideToggle();
});
});//]]>
</script>