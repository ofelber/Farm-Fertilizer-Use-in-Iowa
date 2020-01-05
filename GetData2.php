<?php

	// Builds query based on name-value pairs in the url, the two possible name-value pairs are for compound and for year.
	function buildQuery()
	{
	    //$query = "SELECT fips_co, SUM(amount) AS amount, co FROM location_amount WHERE location_type_id=1 ";
		$query = "SELECT la.fips_co, SUM(la.amount) AS amount, la.co, nt.description  AS compound	
		FROM location_amount la 
		LEFT OUTER JOIN nutrient_type nt 
		ON nt.id = la.nutrient_type_id
		WHERE location_type_id=1";
		//AND nt.description = 'Nitrogen'";
		$compound = "";
	    $year = "";
	    
	    // Check the compound name-value pair on the url to see if it's not empty
	    // If not empty, add compound value to the query
	    if(!empty($_GET["compound"]))
	    {
	        $compound .= " AND nt.description = ";
	        $compound .= "'";
	        $compound .= $_GET["compound"];
	        $compound .= "'";

	        // Check the year name-value pair on the url to see if it's not empty
	        // If not empty, add year value to the query
	        if(!empty($_GET["year"]))
	        {
	            $year .= " AND year IN (";
	            $year .= $_GET["year"];
	            $year .= ")";
	        }
	    }
	    else
	    {
	    	// If a compound isn't selected, 
	    	// run another if statement to check for a selected year
	    	// Check the year name-value pair on the url to see if it's not empty
	    	// If not empty, add year value to the query
	        if(!empty($_GET["year"]))
	        {
	            $year .= " AND year IN (";
	            $year .= $_GET["year"];
	            $year .= ")";
	        }
	    }
	    $query .= $compound;
	    $query .= $year;
		//$query .= ' GROUP BY fips_co, co';
		$query .= 'GROUP BY la.fips_co, la.co, nt.description';
		
		return($query);
	}

//ini_set('display_errors', 'Off');
//error_reporting(E_ALL);

	$locAmtList = array();


	// connect to database 
	//$database = 'host=s-l112.engr.uiowa.edu dbname=postgres user=student6 password=engr-2018-6'; 
	$serverName = "[server name]"; //serverName\instanceName
	$connectionInfo = array( "Database"=>"[database name]", "UID"=>"sa", "PWD"=>"[password]");
	$conn = sqlsrv_connect( $serverName, $connectionInfo);
	//$connection = pg_connect($database);
   	if(!$conn) 
   	{
     //echo "Error : Unable to open database <br/>";
   	} 
   	else 
   	{
      //echo "Opened database successfully <br/> <br/>";
   	}

   	//echo buildQuery();
   	//echo "<br/>";

	//$query = "SELECT county_fips, amount, co FROM fert_pest_table WHERE state_fips = 19  AND year = 1992 AND compound = 'Nitrogen'";

	$query = buildQuery();
	$stmt = sqlsrv_query( $conn, $query);
	//echo $query;
	//echo "<br/>";
	
	//$result = pg_prepare($connection, "qry2", $query);
	//$result = pg_execute($connection, "qry2", array()); 

	$index = 0;

	//while ($row = pg_fetch_row($result)) {
	while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
		
		$locAmtList[$index][0] = $row['fips_co'];	// fips_co
		$locAmtList[$index][1] = $row['amount'];	// amount
		$locAmtList[$index][2] = $row['co'];	// county name
		
		$index++;

	} 
	//echo "Count: ";
	//echo count($locAmtList);
	//echo "<br/>";
	//print_r($locAmtList);
	//echo "<br/>";

	$jsonArray = json_encode($locAmtList);

	echo $jsonArray;


	//pg_close($connection);
	sqlsrv_free_stmt( $stmt);
?>
