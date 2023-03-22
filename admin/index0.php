

	<link rel="stylesheet" type="text/css" href="mycss.css" />
	<script type="text/javascript" src="JavaScriptCodes.js"></script>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv="Content-Style-Type" content="text/css">
	<meta name="CocoaVersion" content="1038.35">
	<style></style>
	<center>

	<fieldset class="Search_Radio_Fieldset">
	<form name="openview_term" method="POST" >
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
	<input type="date" name="date_fld" id="date_id" placeholder= "yyyy-mm-dd"><br><br>
	<label for="drp">District: </label>
	<?php
	$db = mysqli_connect('localhost', 'root', '', 'cbe_db');
	$sql="SELECT DISTRICT_NAME FROM district GROUP BY DISTRICT_NAME"; 
	echo "<select name=dropdown id='drp' onchange='this.nextElementSibling.value=this.value' >DISTRICT_NAME</option>"; // list box select command
	foreach ($db->query($sql) as $row){//Array or records stored in $row
	echo "<option value=$row[DISTRICT_NAME]>$row[DISTRICT_NAME]</option>"; 
	}
	echo "</select>";// Closing of list box
	?>

	<br>
	</td>
	</tr>

	<tr>
	<td>
	<br>
	<!-- <input type="radio" name="source" value="server" onClick="checked();" checked > SERVER<br> -->
	<input type="radio" name="source" value="atms" onClick="checked();" checked> ATM &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br><br>


	</td>
	</tr>
	<tr>
	<td>
	<input type="submit" name="download" value="Download" onclick="go_to_download()" >
	</td>
	</tr>
	<label id="view" style = "color:red;"></label>
	</form>
	</fieldset>
	</center>
	</br>
	<br>
	<br>

	<script type="text/javascript">
	$(function () {
	$("#date_id").date_fld({ dateFormat: 'dd/mm/y' });
	});
	</script>
	<?php
	$today=date("Y-m-d");
	if(isset($_POST['date_fld']) && !empty($_POST['date_fld']) && $_POST['date_fld'] == $today){
	if(isset($_POST['source']) && $_POST['source']== "atms"){
	if(isset($_POST["download"])){
	if (isset($_POST['term_id']) && !empty($_POST['term_id'])){
	if (isset($_POST['date_fld']) && !empty($_POST['date_fld'])){
	$dte=$_POST['date_fld'];
	$yyyy = substr($dte,0,4);
	$mm = substr($dte,5,2);
	$dd = substr($dte,8,2);
	$rev_date = $dd."".$mm."".$yyyy;
	$_POST['term_id']=strtoupper($_POST['term_id']);
	$URL1="Atmlist.txt";
	if (file_exists($URL1)== 1){
	//echo "file found <br>";

	if ($file = fopen($URL1, "r")) {
	while(($line=fgets($file))!==false) {

	$split = explode(";",$line);
	$terminal_id= $split[0];
	$ip= $split[1];
	$atm_type =$split[2];
	$dwnld_file_name = $terminal_id."".$rev_date.".txt";

	if ($_POST['term_id']==$terminal_id){
	$host = $ip;
	break;
	}
	}}
	}else{
	?>
	<script>
	document.getElementById("view").innerHTML =  "Terminal id and ip adress list does not exist!";<!---check if the terminal id list file is empty-->
	</script>
	<?php		
	}
	if(substr($atm_type,0,3) == "NCR"){
	//echo"ncr's offfff";
	?>
	<script>
	document.getElementById("view").innerHTML =  " ";<!--- erase-->
	</script>
	<?php

	set_time_limit(120);
	$output=shell_exec('ping -n 1 '.$host);

	//echo "<pre>$output</pre>"; //for viewing the ping result, if not need it just remove it
	if(strpos($output, 'out') !== false)
	{				
	?>
	<div class ="view_class">
	<center class = "center_view">
	<?php

	echo "<pre>$output</pre>";
	echo "<p style = 'color:red'> The ATM does not Respond!<br> check the connection.";

	?>
	</center>
	</div>
	<?php
	}
	elseif(strpos($output, 'expired') !== false)
	{
	?>
	<div class ="view_class">
	<center class = "center_view">
	<?php

	echo "<pre>$output</pre> <p style = 'color:red'> Network Error!<br>";

	?>
	</center>
	</div>
	<?php
	}
	
	}
	if(substr($atm_type,0,3)== "DIE"){
	//echo"diaboldds";
	set_time_limit(120);
	$output=shell_exec('ping -n 1 '.$host);
	//echo "<pre>$output</pre>"; //for viewing the ping result, if not need it just remove it
	if(strpos($output, 'out') !== false)
	{				
	?>
	<div class ="view_class">
	<center class = "center_view">
	<?php

	echo "<pre>$output</pre>";
	echo "<p style = 'color:red'> The ATM does not Respond!<br> check the connection. </p>";

	?>
	</center>
	</div>
	<?php
	}
	elseif(strpos($output, 'expired') !== false)
	{
	?>
	<div class ="view_class">
	<center class = "center_view">
	<?php


	echo "<pre>$output</pre> <p style = 'color:red'> Network Error!<br>";

	?>
	</center>
	</div>
	<?php
	}
	}
	}
	}
	}
	}	

	}else{
	if(isset($_POST['source'])){
	/*****************************************************this below is only to download EJ's directly from the atm's**********************************************************************/

	if($_POST['source']== "atms"){
	if(isset($_POST['openview'])){
	?>
	<script>
	document.getElementById("view").innerHTML =  "You can Only download direct from atm!"; <!---URL-->
	</script>
	<?php	
	}	
	if(isset($_POST["download"])){

	//if (isset($_POST['ip_ad']) && !empty($_POST['ip_ad'])){
	if (isset($_POST['term_id']) && !empty($_POST['term_id'])){
	if (isset($_POST['date_fld']) && !empty($_POST['date_fld'])){
	$dte=$_POST['date_fld'];
	$yyyy = substr($dte,0,4);
	$mm = substr($dte,5,2);
	$dd = substr($dte,8,2);
	$rev_date = $dd."".$mm."".$yyyy;
	$rev_date1 = $mm."".$dd."".$yyyy;
	$_POST['term_id']=strtoupper($_POST['term_id']);
	$URL1="Atmlist.txt";
	if (file_exists($URL1)== 1){
	//echo "file found <br>";	
	if ($file = fopen($URL1, "r")) {
	while(($line=fgets($file))!==false) {		
	$split = explode(";",$line);
	$terminal_id= $split[0];
	@$ip= $split[1];
	@$atm_type =$split[2];
	$dwnld_file_name = $terminal_id."".$rev_date.".txt";		
	if ($_POST['term_id']==$terminal_id){
	$host = $ip;
	break;
	}
	}}
	}else{
	?>
	<script>
	document.getElementById("view").innerHTML =  "Terminal id and ip adress list does not exist!";<!---check if the terminal id list file is empty-->
	</script>
	<?php		
	}	
	if(substr($atm_type,0,3) == "NCR"){
	//echo"ncr's offfff";
	?>
	<script>
	document.getElementById("view").innerHTML =  " ";<!--- erase-->
	</script>
	<?php

	set_time_limit(120);
	$output=shell_exec('ping -n 1 '.$host);

	//echo "<pre>$output</pre>"; //for viewing the ping result, if not need it just remove it
	if(strpos($output, 'out') !== false)
	{				
	?>
	<div class ="view_class">
	<center class = "center_view">
	<?php

	echo "<pre>$output</pre>";
	echo "<p style = 'color:red'> The ATM does not Respond!<br> check the connection.";

	?>
	</center>
	</div>
	<?php
	}
	elseif(strpos($output, 'expired') !== false)
	{
	?>
	<div class ="view_class">
	<center class = "center_view">
	<?php

	echo "<pre>$output</pre> <p style = 'color:red'> Network Error!<br>";

	?>
	</center>
	</div>
	<?php
	}
	elseif (strpos($output, 'data') !== false) {
	exec ('net use "\\\\'.$host.'" /user:"abcdwxyz" "admin1234ADMIN" /persistent:no') ;
	$URL="\\\\".$host."\\EjLogs\\";

	$file_existed = file_exists($URL);
	if($file_existed == 1 && is_dir($URL)){
	$fname=$URL."\\".$_POST['date_fld'];
	$fileList = glob($fname."*");
	foreach($fileList as $fname1){
	//Use the is_file function to make sure that it is not a directory.
	if(is_file($fname1)){
	//echo $fname1, '<br>'; 
	break;
	}
	}
	if (!empty($fname1) && is_file($fname1) && file_exists($fname1)){	
	header('Content-Description: File Transfer');
	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename='.basename($dwnld_file_name));
	header('Expires: 0');
	header('Cache-Control: must-revalidate');
	header('Pragma: public');
	header('Content-Length: ' . filesize($fname1));
	ob_clean();
	flush();
	if(readfile($fname1));
	exit;

	exec ('net use "\\\\'.$host.'" /delete /yes');
	}else{
	?>
	<script>
	document.getElementById("view").innerHTML =  "The ATM did not store EJ on this DATE!";<!---check if the date fld is empty-->
	</script>
	<?php			
	}
	}else{
	?>
	<div class ="view_class">
	<center class = "center_view">
	<?php
	echo $URL." : diractory not exists OR not shared! <br>";
	?>
	</center>
	</div>
	<?php	
	}
	exec ('net use "\\\\'.$host.'" /delete /yes');
	}else
	{
	?>
	<div class ="view_class">
	<center class = "center_view">
	<?php
	echo "<pre>$output</pre> <p style = 'color:red'> Unknown Error!<br>";
	?>
	</center>
	</div>
	<?php
	}
	}
	if(substr($atm_type,0,3)== "DIE"){
	set_time_limit(120);
	$output=shell_exec('ping -n 1 '.$host);
	//echo "<pre>$output</pre>"; //for viewing the ping result, if not need it just remove it
	if(strpos($output, 'out') !== false)
	{				
	?>
	<div class ="view_class">
	<center class = "center_view">
	<?php
	echo "<pre>$output</pre>";
	echo "<p style = 'color:red'> The ATM does not Respond!<br> check the connection. </p>";
	?>
	</center>
	</div>
	<?php
	}
	elseif(strpos($output, 'expired') !== false)
	{
	?>
	<div class ="view_class">
	<center class = "center_view">
	<?php
	echo "<pre>$output</pre> <p style = 'color:red'> Network Error!<br>";	
	?>
	</center>
	</div>
	<?php
	}
	elseif (strpos($output, 'data') !== false) {
	exec ('net use "\\\\'.$host.'" /user:"manage_atm" "diebold" /persistent:no') ;
	$URL="\\\\".$host."\\EjLogs\\";

	$file_existed = file_exists($URL);
	if($file_existed == 1 && is_dir($URL)){
	//echo $URL;	
	$fname=$URL;
	$fileList = glob($fname."*".$rev_date1."*");
	foreach($fileList as $fname1){
	//Use the is_file function to make sure that it is not a directory.
	if(is_file($fname1)){
	//echo $fname1, '<br>'; 
	break;
	}
	}
	if (!empty($fname1) && is_file($fname1) && file_exists($fname1)){
	header('Content-Description: File Transfer');
	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename='.basename($dwnld_file_name));
	header('Expires: 0');
	header('Cache-Control: must-revalidate');
	header('Pragma: public');
	header('Content-Length: ' . filesize($fname1));
	ob_clean();
	flush();
	if(readfile($fname1));
	exit;
	exec ('net use "\\\\'.$host.'" /delete /yes');
	}else{
	?>
	<script>
	document.getElementById("view").innerHTML =  "The ATM did not store EJ on this DATE!";<!---check if the date fld is empty-->
	</script>
	<?php			
	}
	}else{
	?>
	<div class ="view_class">
	<center class = "center_view">
	<?php

	echo $URL." : diractory not exists OR not shared! <br>";

	?>
	</center>
	</div>
	<?php			
	}
	exec ('net use "\\\\'.$host.'" /delete /yes');
	}else
	{
	?>
	<div class ="view_class">
	<center class = "center_view">
	<?php
	echo "<pre>$output</pre> <p style = 'color:red'> Unknown Error!<br>";
	?>
	</center>
	</div>
	<?php
	}
	}
	}else{
	?>
	<script>
	document.getElementById("view").innerHTML =  "Please select the date!";<!---check if the date fld is empty-->
	</script>
	<?php					
	}
	}else{
	?>
	<script>
	document.getElementById("view").innerHTML =  "Empty terminal id!";<!---check if the terminal id fld is empty-->
	</script>
	<?php					
	}

	}
	}//atm source has set
	}
	}//if the date is not today

	?>
	</div>
