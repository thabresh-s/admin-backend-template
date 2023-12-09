<?php require_once("/home/bse2nse5/public_html/Dashboard/admin/modal/logging/KLogger/KLogger.php");?>

<?php
	// Log Equity ID, SplitDate and SplitBy
	 $log->LogInfo("Push Live Request Received");
	 	 
	// execute live processing
	 $output = shell_exec('sh /home/bse2nse5/bse2nse5_equity_eod/eod/scripts/splitstock_live.sh');
	 
	 $log->LogInfo("Push Live Request Finished");
 
	 // Return Response.
	 echo $_GET['callback']."(".json_encode("Success").");";	
?>