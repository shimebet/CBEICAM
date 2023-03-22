<?php

//connect database
include 'connection/config.php';

//display ui
?>
<html>
	<head>
		<title>Cassette Status</title>	
	</head>
	<body>
	<h1>Casset Notes Remaining Status</h1>
		<form name="search_term" method="POST">
		<label for="tid">Terminal ID : </label>
		<input type="text" name="term_id" id="tid"><br>
		<input type="radio" name="atm" value="ncr" checked> NCR<br>
		<input type="radio" name="atm" value="diebold"> Diebold<br>
		<input type="submit" name="search" value="Search">
		</form>
	</body>
</html>
<?php
//check ip
if(isset($_POST['search']))
{
		if($_POST['term_id'] == "")
		{
			echo "Terminal Id not specifed!";
		}
		else
		{
			$sql = "select * from terminal where terminal_id = '".$_POST["term_id"]."' ";
			$query = mysqli_query($con, $sql);
			$result = mysqli_fetch_assoc($query);
			if($result>0)
			{
				$host = $result["host"];
			}
			else
			{
				echo "Could not find the terminal!";
			}
		}
//ftp file
if(isset($host))
{
$term = $_POST["term_id"];
//exec ('net use "\\\\'.$host.'" /delete /yes');
if($_POST["atm"] == "ncr")
{
	exec ('net use "\\\\'.$host.'" /user:"administrator" "Sstautocbe2020NCR" /persistent:no');
	$URL='\\\\'.$host.'\\Data\\EJDATA.LOG';
}
if($_POST["atm"] == "diebold")
{
	exec ('net use "\\\\'.$host.'" /user:"manage_atm" "diebold" /persistent:no');
	$URL='\\\\'.$host.'\\Journal\\EJLogFile.dat';
	set_time_limit(120);
}
$DES='C:\\EJ\\'.$term.'\\EJlog.txt';
$BUP='C:\\EJ\\'.$term.'\\EJlog_old.txt';
$filename = 'C:\\EJ\\'.$term;
if(file_exists($URL)){
	$FILE = 1;
}
else{
	$FILE = 0;
}

if (file_exists($filename)) {
	if(file_exists($DES))
	{
		copy($DES, $BUP);
	}
	
	if($FILE == 1){
	copy($URL, $DES);
	}
	else{
		echo "could not access the terminal, here is the last EJ from server!<br>";
	}
    
} else {
    mkdir($filename, 0700);
	if(file_exists($DES))
	{
		copy($DES, $BUP);
	}
    if($FILE == 1){
	copy($URL, $DES);	
	}
	else{
		echo "could not access the terminal, here is the last EJ from server!<br>";
	}
}
exec ('net use "\\\\'.$host.'" /delete /yes');
}
?>

<?php
//read file
if($_POST["atm"] == "ncr")
{
if(isset($host))
{
if(file_exists($DES))
{
$handle = fopen($DES, "r");
if ($handle) {
	$buf =0;
    while (($buffer = fgets($handle, 4096)) !== false) {
        if (strpos($buffer, "REMAINING") !== false) 
		{
		$last = $buffer;
		$buffer = "";
		$buf = 1;
		}
    }
    if (!feof($handle)) {
        echo "Error: unexpected fgets() fail\n";
    }
	if($buf == 1){
	$last = str_replace('REMAINING        ', ' ',$last);
	$last = str_replace('      ', '_ERROR',$last);
	$last = str_replace(' ', '_',$last);
	
	echo "<pre>_Type1_Type2_Type3_Type4</pre>";
	echo "<pre>".$last."</pre>";
    fclose($handle);
	}
}
}
	else
	{
		echo "could not find any previous EJ log on server!";
	}
}
}
if($_POST["atm"] == "diebold")
{
if(isset($host))
{
if(file_exists($DES))
{
$handle = @fopen($DES, "r");
if ($handle) {
	$buf =0;
	$count = 0;
	$line1 = "error";
	$line2 = "error";
    while (($buffer = fgets($handle, 4096)) !== false) {
		if($count != 0){
			if($count == 2){
				$line1 = $buffer;
			}
			if($count == 1){
				$line2 = $buffer;
			}
			$count = $count -1;
		}
        if (strpos($buffer, 'REM') !== false) 
		{
		$last = $buffer;
		$buffer = "";
		$count = 2;
		$buf = 1;
		}
    }
    if (!feof($handle)) {
        echo "Error: unexpected fgets() fail\n";
    }
	if($buf == 1){
	echo $last;
	//echo "<br>";
	//echo $line1;
	//echo "<br>";
	//echo $line2;
    fclose($handle);
	}
}
}
	else
	{
		echo "could not find any previous EJ log on server!";
	}
}
}

}
?>
<?php
