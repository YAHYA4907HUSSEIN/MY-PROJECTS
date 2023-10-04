<?php
session_start();
error_reporting(0);
	if(!isset($_SESSION[empid]))
	{
		header("Location: login.php");
	}
	$dt =  date("Y-m-d");
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Yahya Processing Inventory</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="description" content="" />
<meta name="keywords" content="" />
<noscript>
<link rel="stylesheet" href="css/5grid/core.css" />
<link rel="stylesheet" href="css/5grid/core-desktop.css" />
<link rel="stylesheet" href="css/5grid/core-1200px.css" />
<link rel="stylesheet" href="css/5grid/core-noscript.css" />
<link rel="stylesheet" href="css/style.css" />
<link rel="stylesheet" href="css/style-desktop.css" />
</noscript>
<script src="css/jquery.min.js"></script>
<script src="css/5grid/init.js?use=mobile,desktop,1000px&amp;mobileUI=1&amp;mobileUI.theme=none&amp;mobileUI.openerWidth=52"></script>
<!--[if IE 9]><link rel="stylesheet" href="css/style-ie9.css" /><![endif]-->
</head><body class="twocolumn2">
<div id="wrapper"style= "background-color: green">>
	<div id="header-wrapper"style= "background-color: green">>
		<header id="header"style= "background-color: blue">>
			<div class="5grid-layout">
				<div class="row">
					<div class="12u" id="logo"> <!-- Logo -->
						<h1><a href="#" class="mobileUI-site-name"> <img src="coco/sgr.png" width="160" height="110">Inventory management system<img src="coco/sgr.png" width="160" height="110"></a></h1>
					</div>
				</div>
			</div>
			<div class="5grid-layout">
				<div class="row">
					<div class="12u" id="menu">
						<div id="menu-wrapper">
							<div id="wrapper"style= "background-color: green">>
<nav class="mobileUI-site-nav">
								<ul>
									<li
                                    <?php
									if(basename($_SERVER['PHP_SELF']) == "index.php")
									{
										echo " class='current_page_item' ";
									}
									?>
                                    ><a href="index.php">Home</a></li>
									<li
                                    <?php
									if(basename($_SERVER['PHP_SELF']) == "about.php")
									{
										echo " class='current_page_item' ";
									}
									?>><a href="about.php">About</a></li>
									<li
                                    <?php
									if(basename($_SERVER['PHP_SELF']) == "product.php")
									{
										echo " class='current_page_item' ";
									}
									?>><a href="product.php">Products</a></li>
									<li
                                    <?php
									if(basename($_SERVER['PHP_SELF']) == "contact.php")
									{
										echo " class='current_page_item' ";
									}
									?>><a href="contact.php">Contact</a></li>
									<li
                                    <?php
									if(basename($_SERVER['PHP_SELF']) != "index.php" || "logout.php" || "about.php"|| "product.php"|| "contact.php" )
									{
										echo " class='current_page_item' ";
									}
									?>><a href="account.php">Account</a></li>
                                    <?php
									if(isset($_SESSION[empid]))
									{
									?>
									<li
                                    <?php
									if(basename($_SERVER['PHP_SELF']) == "logout.php")
									{
										echo " class='current_page_item' ";
									}
									?> ><a href="logout.php" onClick="return confirmmsg()">Logout</a></li>                                    
                                    <?php
									}
									?>
								</ul>
							</nav>
						</div>
					</div>
				</div>
			</div>
		</header>
		</div>
 
<script>      
function confirmmsg()
{
	var connn=confirm("Are you sure");
	if(connn==true)
	{
		return true;
	}
	else
	{
		return false;
	}
}
</script>