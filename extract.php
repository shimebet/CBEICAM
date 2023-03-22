
<?php
include('Extractor.class.php');
$extractor = new Extractor;

$archivepath = 'source/22.zip';
$destination = 'destination/';

$extract = $extractor -> extract($archivepath, $destination);

if ($extract) {
	echo $GLOBALS['status']['success'];
}
else{
	echo $GLOBALS['status']['error']; 
}


?>