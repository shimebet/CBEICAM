<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd"> 

<?php

//connect database
//include 'connection/config.php';

//display ui
$output=null;
$retval=null;
$host = "10.8.64.102";
 exec ('net use "\\\\'.$host.'" /user:"andu" "Welcome2cbe" /persistent:no',$output,$retval) ;
if ($output){
	print_r($output);
	?>
	<br/>
	<?php
	echo $output[0]. "//..".$retval."...first";
}else{
	echo  "//..".$retval.".....second";
}
	//."....first";
?>