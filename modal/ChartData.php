<?php require_once("/home/bse2nse5/public_html/Dashboard/EOD/Equity/screens/includes/db_connection.php");?>
<?php require_once("/home/bse2nse5/public_html/Dashboard/EOD/Equity/screens/includes/functions.php");?>
<?php require_once("/home/bse2nse5/public_html/Dashboard/admin/modal/logging/KLogger/KLogger.php");?>
<?php 
	// Get Request Data
	$stockname = $_REQUEST['stockname'];
	
	
	// Log the details received
	$log->LogInfo("BackOffice - PlotChart - Request Received ");
	$chart_data = array();
	$chart_data_query =  "SELECT TRANSACTION_DATE, CLOSE, 200_DAY_SMA FROM EQUITY_HISTORY_STAGE WHERE TRANSACTION_DATE > " . " DATE_SUB(CURDATE(), INTERVAL 5 YEAR)". " AND EQUITY_NAME = " . "'"  . $stockname . "'" . ";" ;
	$log->LogInfo("PlotChart - Query = " . $chart_data_query);
	$chart_dataset = mysqli_query($connection,$chart_data_query);
	
	while($datarow = mysqli_fetch_assoc($chart_dataset))
		{
			 $chart_data['transaction_date'][] = $datarow["TRANSACTION_DATE"];			 			 
			 $chart_data['close_price'][] = $datarow["CLOSE"];
			 $chart_data['200_day_sma'][] = $datarow["200_DAY_SMA"];
		}
	mysqli_free_result($chart_dataset);
	$log->LogInfo("BackOffice - PlotChart - Request Finished");
	echo $_GET['callback']."(".json_encode($chart_data).");";
?>