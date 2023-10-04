<?php
	//connection
	$connection = mysqli_connect("localhost","root","","sugar");
	// Check connection
	if (!$connection) {
		die("Connection failed: " . mysqli_connect_error());
	}
?>