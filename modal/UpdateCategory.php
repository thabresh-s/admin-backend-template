<?php require_once("/home/bse2nse5/public_html/Dashboard/EOD/Equity/screens/includes/db_connection.php");?>
<?php require_once("/home/bse2nse5/public_html/Dashboard/EOD/Equity/screens/includes/functions.php");?>
<?php require_once("/home/bse2nse5/public_html/Dashboard/EOD/Equity/screens/logging/KLogger/KLogger.php");?>
<?php 
	// Get Request Data
	$u_stockname 	  = $_REQUEST['StockName'];
	$u_categoryname   = $_REQUEST['category_name'];
	
	// Log Start
	$log->LogInfo("UpdateStock - Request Received For Stock = " . $u_stockname . " Sector = " .  $u_categoryname);
	
	// Prepare MySQL Query
	$update_cat_query = "UPDATE EQUITIES SET SECTOR = " . "'" . $u_categoryname . "'"  . 
	" WHERE EQUITY_NAME = " . "'" . $u_stockname . "'" . ";" ;
	 $update_ds = mysqli_query($connection,$update_cat_query);

	// Log End
	$log->LogInfo("UpdateStock - Finished Updating Sector " . $update_ds);

	// Send Response
	echo $_GET['callback']."(".json_encode($u_stockname).");";
?>