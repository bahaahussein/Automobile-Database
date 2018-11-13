<?php
function flash(&$sess) {
	if ( isset($sess['message']) ) {
        echo("<p style='color:red'>".$sess['message']."</p>\n");
        unset($sess['message']);
    } else if( isset($sess['success']) ) {
    	echo("<p style='color:green'>".$sess['success']."</p>\n");
        unset($sess['success']);
    }
}

function isValid($make, $year, $mileage, $model) {
	$out = true;
	if(strlen($make) < 1 || strlen($model) < 1 || strlen($year) < 1 || strlen($mileage) < 1) {
		$out = "All fields are required";
	} else if(!is_numeric($year)) {
		$out = "year must be numeric";
	} else if(!is_numeric($mileage)) {
		$out = "Mileage must be numeric";
	}
	return $out;
}
?>