<?php
	    $conn = oci_connect('ACQCBEPD', 'ACQCBEPD', '//10.1.8.126/ACQCBEPD'); //10.1.8.15  old ip addresss
		if (!$conn) 
		{
    		$e = oci_error();
    		print htmlentities($e['message']);
    		exit;
    	}
?>