<?php
session_start();
session_destroy();
//redirects to index page
header("Location: index.php");
?>
