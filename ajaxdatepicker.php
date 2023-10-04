<?php
if($_GET[dtetype] == "Monthly Report")
{
?>
&nbsp; &nbsp; Select month : <input type="month" name="monthlyreport" >
<?php
}
?>
<?php
if($_GET[dtetype] == "Yearly Report")
{
?>
&nbsp; &nbsp; From : April/<input type="text" name="fyearlyreport"  > | To: March/<input type="text" name="tyearlyreport">
<?php
}
?>
<?php
if($_GET[dtetype] == "Daily Report")
{
?>
&nbsp; &nbsp; Select date : <input type="date" name="dailyreport" >
<?php
}
?>