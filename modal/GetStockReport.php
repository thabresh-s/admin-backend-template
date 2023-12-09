<?php require_once("/home/bse2nse5/public_html/Dashboard/EOD/Equity/screens/includes/db_connection.php");?>
<?php require_once("/home/bse2nse5/public_html/Dashboard/EOD/Equity/screens/includes/functions.php");?>
<?php require_once("/home/bse2nse5/public_html/Dashboard/admin/modal/logging/KLogger/KLogger.php");?>
<?php 
	
	$log->LogInfo("GetStockReport - Request Received");
	// Get Request Data
	$stockname = $_REQUEST['stockname'];
	$startdate = $_REQUEST['startdate'];
	$enddate   = $_REQUEST['enddate'];
	
	// Log the details received
	$log->LogInfo(" ScreenInput Stock = " . $stockname . " StartDate = $startdate " . " EndDae = $enddate");
	
	if(isset($stockname) && !empty($stockname) && !empty($startdate) && !empty($enddate))
	{
		// Log Beginning...
		$get_stock_query = "SELECT EQUITY_NAME,OPEN,HIGH,LOW,CLOSE,TRANSACTION_DATE,200_DAY_SMA FROM EQUITY_HISTORY_STAGE WHERE EQUITY_NAME = " . "'" . $stockname . "'" . " AND TRANSACTION_DATE BETWEEN " . "'" . $startdate . "'" . " AND " . "'" . $enddate . "';" ;
		$stock_dataset   = mysqli_query($connection,$get_stock_query);
		$stock_count    = mysqli_num_rows($stock_dataset);
		
		$log->LogInfo("GetStockReport Query - " . $get_stock_query);
		
		// Check for Invalid stock name
		if($stock_count == 0)
		{
			$return_arr[] = "Sorry, No results..";
			$log->LogInfo("No Such Stock - $row_count");	
		}
		else
		{	
			while($datarow = mysqli_fetch_assoc($stock_dataset))
			{
				$return_arr[] = array($datarow["EQUITY_NAME"],$datarow["OPEN"],$datarow["HIGH"],$datarow["LOW"],$datarow["CLOSE"],$datarow["TRANSACTION_DATE"],$datarow["200_DAY_SMA"]);
			}
			mysqli_free_result($stock_dataset);
		}	
		
		// Log Finishing...
		$log->LogInfo("GetStockReport - Request Finished");
		
		// Return Response.
		echo $_GET['callback']."(".json_encode($return_arr).");";
	}
?>