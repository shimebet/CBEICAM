<?php

//connect database
//include 'connection/config.php';

//display ui
?>
<html>
	<head>
		<title>EJ report download</title>	

<link href="images/favicon.ico" rel="icon" />
<link rel="stylesheet" type="text/css" href="mycss.css" />
<script type="text/javascript" src="JavaScriptCodes.js"></script>
 
</head>
<body background="images/Side.jpg">
    <div class="Entire_Page"> 
	 
		<div class="header">
		 	  <img src="images/logo.png" class="image"> 		   
			 
			  <div class="profile">
			  <h1>EJ report download</h1>
			  
			 </div> 
			 <div class="body" id="body">
		<br>
			<center>
			<fieldset class="Search_Radio_Fieldset">
		<form name="search_term" method="POST">
		<tr>
		<td>
				<fieldset class="Radio_Fieldset">
		<label for="tid">Terminal ID : </label>
		<input type="text" name="term_id" id="tid"><br><br>
		</td>
		</tr>
		<tr>
		<td>
		<label for="date_id">Date: </label>
		<input type="date" name="date_fld" id="date_id" format= "dd-mm-yy"><br><br>
		</td>
		</tr>
		<tr>
		<td>

		<input type="radio" name="atm" value="ncr" checked> NCR<br><br>
		<td>
		<input type="radio" name="atm" value="diebold"> Diebold<br><br>
		</fieldset>
		</td>
		</td>
		</tr>
		<tr>
		<td>
		<input type="submit" name="search" value="veiw">
		<input type="submit" name="download" value="Download" onclick="go_to_download()">
		</td>
		</tr>
		</form>
		</center>
		
		</fieldset>
		
		</div>
	</div>
	
	
<script type="text/javascript">
      $(function () {
          $("#date_id").date_fld({ dateFormat: 'dd/mm/y' });
      });
  </script>
<?php
if(isset($_POST["download"])){
	
	echo $_POST["date_fld"];
}

if(isset($_POST["download"])){
	//$date_vl = new DateTime($_POST['date_fld']);
	//$date_vl = date_format('ddmmyy',$date_vl);
				$fname ="E:\\".$_POST['term_id']."/".$_POST['date_fld']."_aci.txt";
				$file_exist = file_exists($fname);
echo $fname;
				if($file_exist == 1){
					header('Content-Description: File Transfer');
					header('Content-Type: application/octet-stream');
					header('Content-Disposition: attachment; filename='.basename($fname));
					header('Expires: 0');
					header('Cache-Control: must-revalidate');
					header('Pragma: public');
					header('Content-Length: ' . filesize($fname));
					ob_clean();
					flush();
					if(readfile($fname));
					exit;
					?>
					<script>
document.getElementById("view").innerHTML =  "your download";
</script>

<?php
				}
				else{
					?>
					<script>
document.getElementById("view").innerHTML =  "File Doesn't exist";
</script>

<?php
				
				}
			}
//check ip
if(isset($_POST['search']))
{
		if($_POST['term_id'] == "")
		{
			

			
			?>
					<script>
document.getElementById("view").innerHTML =  "File Doesn't exist";
</script>

<?php
			
		}
		else
		{
			$fname ="E:\\".$_POST['term_id']."/".$_POST['date_fld']."_aci.txt";
				$file_exist = file_exists($fname);
echo $fname;
				if($file_exist == 1){
					$myfile = fopen($fname, "r") or die("Unable to open file!");
$pr =  fread($myfile,filesize($fname));
?>
<div class ="view_class">
	<center class = "center_view">
	<?php
	echo $pr;
	?>
	</center>
	</div>


					<script type="text/javascript">
var strmejs = "<?php echo $pr ;?>" + "<br>";
document.getElementById("view").innerHTML = strmejs;
</script>

<?php
fclose($myfile);

					if ($myfile_rd = fopen($fname, "r")) {
    while(!feof($myfile_rd)) {
        $line = fgets($myfile_rd);
        # do same stuff with the $line
        $strme .= $line;
        					
    }
	
    fclose($myfile_rd);
}
						}
				else{
					?>
					<script>
document.getElementById("view").innerHTML =  "File Doesn't exist";
</script>

<?php
				}
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
        if (strpos($buffer, 'REMAINING') !== false) 
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
	echo "<br>";
	echo $line1;
	echo "<br>";
	echo $line2;
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
<?php?>
	</br>
	</body>
</html>
