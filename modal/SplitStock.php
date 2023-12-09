<?php require_once("/home/bse2nse5/public_html/Dashboard/EOD/Equity/screens/includes/db_connection.php");?>
<?php require_once("/home/bse2nse5/public_html/Dashboard/EOD/Equity/screens/includes/functions.php");?>
<?php require_once("/home/bse2nse5/public_html/Dashboard/admin/modal/logging/KLogger/KLogger.php");?>

<?php

	// Get Request Data
	$stockname = $_REQUEST['stockname'];
	$splitdate= $_REQUEST['splitdate'];
	$splitby= $_REQUEST['splitby'];
	
	
	// Prepare database query
	$get_eid_query = "SELECT EQUITY_ID FROM EQUITIES_STAGE WHERE EQUITY_NAME = " . "'" . $stockname  . "';" ;
	$eid_data      = mysqli_query($connection,$get_eid_query);
	$eid_row = mysqli_fetch_assoc($eid_data);
	$EID = $eid_row["EQUITY_ID"];
	
	// Log Equity ID, SplitDate and SplitBy
	 $log->LogInfo("SplitStock StockID = " . $eid_row["EQUITY_ID"]);			 			 
	 $log->LogInfo("SplitStock StockName = " . $stockname . " SplitDate = " . $splitdate .  " SplitBy = " . $splitby);
	 
	 // Prepare stage SQL from template
	 $splitsqlfile = file_get_contents('/home/bse2nse5/bse2nse5_equity_eod/eod/sql/split_stock_template_stage.sql');
	 $splitsqlfile = str_replace("XXXXEID",$EID,$splitsqlfile);
	 $splitsqlfile = str_replace("XXXXDATE",$splitdate,$splitsqlfile);
	 $splitsqlfile = str_replace("XXXXBY",$splitby,$splitsqlfile);

	 // write to stage sql
	 file_put_contents('/home/bse2nse5/bse2nse5_equity_eod/eod/sql/split_stock_stage.sql',$splitsqlfile);
	 
	 // execute stage processing
	  $output = shell_exec('sh /home/bse2nse5/bse2nse5_equity_eod/eod/scripts/splitstock_stage.sh');
	 
	 // Prepare Live sql
	 $splitsqlfile = file_get_contents('/home/bse2nse5/bse2nse5_equity_eod/eod/sql/split_stock_template_live.sql');
	 $splitsqlfile = str_replace("XXXXEID",$EID,$splitsqlfile);
	 $splitsqlfile = str_replace("XXXXDATE",$splitdate,$splitsqlfile);
	 $splitsqlfile = str_replace("XXXXBY",$splitby,$splitsqlfile);
	 
	 // write to live sql
	 file_put_contents('/home/bse2nse5/bse2nse5_equity_eod/eod/sql/split_stock_live.sql',$splitsqlfile);
	 
	 $log->LogInfo("SplitStock Successfully written contents to splitstock file =  " . $output);
 
 // Return Response.
echo $_GET['callback']."(".json_encode("Success").");";
		
?>