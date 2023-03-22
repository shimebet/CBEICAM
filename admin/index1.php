

<link rel="stylesheet" type="text/css" href="mycss.css" />
<script type="text/javascript" src="JavaScriptCodes.js"></script>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta http-equiv="Content-Style-Type" content="text/css">
  <meta name="CocoaVersion" content="1038.35">

			<center>
			<fieldset class="Search_Radio_Fieldset">
		<form name="openview_term" method="POST">
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
		<input type="radio" name="source" value="server" onClick="checked();" checked > SERVER<br>
		<input type="radio" name="source" value="atms" onClick="checked();"> ATM &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br><br>
		
		 
		</td>
		</tr>
		<tr>
		<td>
		<input type="submit" name="openview" value="veiw" >
		<!--<input type="submit" name="cassetview" value="check cassets" >-->
		<!-- <input type="submit" name="download" value="Download" onclick="go_to_download()"> -->
		
		<!--<input type="submit" name="pings" value="pos network monitoring" target="_blank">
		-->

		
		</td>
		</tr>
		<!-- <br>
		<li>
		<br>
		<a href="index_def.php ">new terminal defination </a></li>
		<br
		
		</br>
		<li><a href="http://localhost/ej/pos_monitoring/">click here to check all registered POS terminal status</a></li>
		<br>   -->
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


if(isset($_POST["pings"])){
//	header('location: ../pos_monitoring/index.php');
header('location: maintain.html');
}




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
		   //echo $line."<br>";
           //print_r ($split);
	       //echo $terminal_id ."<br>andu<br>". $host."<br>";
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
			//echo $line."<br>";
               //print_r ($split);
	        //echo $terminal_id ."<br>andu<br>". $host."<br>".$atm_type."<br>";
				
			


			
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
    //echo "LIVE<br>";
	
	
			//echo $URL."<br>";
			
				
			exec ('net use "\\\\'.$host.'" /user:"abcdwxyz" "admin1234ADMIN" /persistent:no') ;
		//echo "connected <br>";

$URL="\\\\".$host."\\Data\\";

			$file_existed = file_exists($URL);
			if($file_existed == 1 && is_dir($URL)){
						
           $fname1=$URL."EJDATA.LOG";
			/*$fileList = glob($fname."*");
foreach($fileList as $fname1){
    //Use the is_file function to make sure that it is not a directory.
    if(is_file($fname1)){
        //echo $fname1, '<br>'; 
   break;
}
}*/

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
    elseif (strpos($output, 'data') !== false) {
    //echo "LIVE<br>";
	
	
			//echo $URL."<br>";
			
				
			exec ('net use "\\\\'.$host.'" /user:"manage_atm" "diebold" /persistent:no') ;
		//echo "connected <br>";

$URL="\\\\".$host."\\Journal\\";

			$file_existed = file_exists($URL);
			if($file_existed == 1 && is_dir($URL)){
					//echo $URL;	
           $fname=$URL."EJLogFile";
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




/*}else{
	?>
					<script>
document.getElementById("view").innerHTML =  "ATM type not is selected!";<!---check if the date fld is empty-->
</script>
<?php			
}//radio bn */






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
}else{
	?>
					<script>
document.getElementById("view").innerHTML =  "you should choose  'ATM'  source for today's EJ repot!"; <!---URL-->
</script>

<?php
}	
	if(isset($_POST['openview'])){
		?>
					<script>
document.getElementById("view").innerHTML =  "You can Only download direct from atm!"; <!---URL-->
</script>

<?php
		
	}
	
	
}else{
/*if(isset($_POST['source'])){
	//echo "breadsssssssssssssss";
	if($_POST['source']== "server"){
	
	
	}
	if($_POST['source']== "diebold"){
		echo "<br> diebold is set<br>";
	}
}else{echo "not settttttttttt";}
*/

if(isset($_POST['source'])){
	
if($_POST['source']== "server"){
	
	
  if(isset($_POST["download"])){
	
	              //$date_vl = new DateTime($_POST['date_fld']);
	             //$date_vl = date_format('ddmmyy',$date_vl);
	   if(!empty($_POST["term_id"]) && isset($_POST["term_id"])) {
            if (isset($_POST['date_fld']) && !empty($_POST['date_fld'])){
	            $dte=$_POST['date_fld'];
				$yyyy = substr($dte,0,4);
				$mm = substr($dte,5,2);
				$dd = substr($dte,8,2);
				$rev_date = $dd."".$mm."".$yyyy;
				 $_POST['term_id']=strtoupper($_POST['term_id']);
				//echo $dte.":dte<br>date:".$rev_date;
				$host = "10.1.7.150";
			exec ('net use "\\\\'.$host.'" /user:"Reconciliation@cbe.com.et" "Welcome2cbe" /persistent:no');
			//$URL='\\\\'.$host.'\\\\'.$_POST['term_id'];
	       // $fname =$URL."\\".$_POST['date_fld'];
	
	$URL='\\\\'.$host.'\\\\atm\\atmej\\'.$rev_date;
			$fname =$URL."\\".$_POST['term_id']."".$rev_date;
			
			
				
			$file_existed = file_exists($URL);
			if($file_existed == 1 && is_dir($URL)){
						
           
			$fileList = glob($fname."*");
foreach($fileList as $fname1){
    //Use the is_file function to make sure that it is not a directory.
    if(is_file($fname1)){
      //  echo $fname1, '<br>'; 
   
}
break;
}
?>
					<script>
document.getElementById("view").innerHTML =  " ";<!--- erase-->
</script>
<?php
if (!empty($fname1) && file_exists($fname1)== 1){
	
                 //  $file_exist = file_exists($fname1);
//echo $fname;
	//			if($file_exist == 1){//&& is_dir($fname)){
		
					header('Content-Description: File Transfer');
					header('Content-Type: application/octet-stream');
					header('Content-Disposition: attachment; filename='.basename($fname1));
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
document.getElementById("view").innerHTML =  "EJ not found!!";<!---check if file name is not found-->
</script>
<?php
				}
				}else{
	?>

					<script>
document.getElementById("view").innerHTML =  "No data found! correct date format!";<!---URL-->
</script>
<?php
  }	
				}else{
					?>
					<script>
document.getElementById("view").innerHTML =  "Please select the date!";<!---check if the date fld is empty-->
</script>
<?php					
				}
			}

			else{
?>
					<script>
document.getElementById("view").innerHTML =  "please enter terminal id!";<!---check if term_id fld is empty-->
</script>
<?php
				}
	}
//check ip


if(isset($_POST['openview'])){
	
			if(!empty($_POST['term_id']) && isset($_POST["term_id"])){
			if (isset($_POST['date_fld']) && !empty($_POST['date_fld'])){
				$dte=$_POST['date_fld'];
				$yyyy = substr($dte,0,4);
				$mm = substr($dte,5,2);
				$dd = substr($dte,8,2);
				$rev_date = $dd."".$mm."".$yyyy;
				 $_POST['term_id']=strtoupper($_POST['term_id']);
			$host = "10.1.7.150";
			exec ('net use "\\\\'.$host.'" /user:"Reconciliation@cbe.com.et" "Welcome2cbe" /persistent:no');
	//$URL='\\\\'.$host.'\\\\'.$_POST['term_id'];
	//		$fname =$URL."\\".$_POST['date_fld'];
	
            $URL='\\\\'.$host.'\\\\ATM\\ATMEJ\\'.$rev_date;
			$fname =$URL."\\".$_POST['term_id']."".$rev_date;	
			$file_existed = file_exists($URL);
			if($file_existed == 1 && is_dir($URL)){
			$fileList = glob($fname."*");
foreach($fileList as $fname1){
    //Use the is_file function to make sure that it is not a directory.
    if(is_file($fname1)){
        //echo $fname1, '<br>'; 
		
   }
   break;
 } 
if (!empty($fname1) && file_exists($fname1)== 1){
				//$file_exist = file_exists($fname1);
//echo $fname;
				//if($file_exist == 1 ){//&& is_dir($fname)){
					//echo $fname;
										
					//$myfile = fopen($fname1, "r+") or die("Unable to open file!");
//$pr =  fread($myfile,filesize($fname1));
?>
<div class ="view_class">
	<center class = "center_view">
	<?php
	if ($file = fopen($fname1, "r")) {
    while(!feof($file)) {
        $line = fgets($file);
        # do same stuff with the $line
		echo "<pre>";
        echo "<p align ='left' style='margin-left:250px';>".$line;
        echo "</pre>";
		
    }
    fclose($file);
}
//echo $pr;
	
	?>
	</center>
	</div>
<?php
//fclose($myfile);
				
}else{
	?>
					<script>
document.getElementById("view").innerHTML =  "EJ not found!!"; <!---check if file name is not found-->
</script>
<?php  
}

exec ('net use "\\\\'.$host.'" /delete /yes');
}else{
	?>
					<script>
document.getElementById("view").innerHTML =  "No data found to view on this date!"; <!---URL-->
</script>

<?php
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
document.getElementById("view").innerHTML =  "please enter terminal id!";<!---check empty terminal id fld-->
</script>
<?php
		}
		     }//openview btn is set

                   }//server source has set


				   
				   
				   
				   
/*****************************************************this below is only to download EJ's directly from the atm's**********************************************************************/




if($_POST['source']== "atms"){
	if(isset($_POST['openview'])){
		?>
					<script>
document.getElementById("view").innerHTML =  "You can Only download direct from atm!"; <!---URL-->
</script>

<?php
		
	}
	/*
	if (file_exists($URL1)== 1){
		echo "file found <br>";
		
if ($file = fopen($URL1, "r")) {
    while(($line=fgets($file))!==false) {
		
        $split = explode(";",$line);
		$tid= $split[0];
		$ip= $split[1];
		$atm_type =$split[2];
		$host = $ip;
		//echo $line."<br>";
//print_r ($split);
	//echo $tid ."<br>andu<br>". $ip."<br>";
	}}}else{echo "losted tuit ";}
			echo $line."<br>";
//print_r ($split);
	        echo $tid ."<br>andu<br>". $ip."<br>".$atm_type."<br>";
			
			*/
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
		   //echo $line."<br>";
           //print_r ($split);
	       //echo $terminal_id ."<br>andu<br>". $host."<br>";
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
			//echo $line."<br>";
               //print_r ($split);
	        //echo $terminal_id ."<br>andu<br>". $host."<br>".$atm_type."<br>";
				
			


			
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
    //echo "LIVE<br>";
	
	
			//echo $URL."<br>";
			
				
			exec ('net use "\\\\'.$host.'" /user:"abcdwxyz" "admin1234ADMIN" /persistent:no') ;
		//echo "connected <br>";

$URL="\\\\".$host."\\D$\Camera\Images\\";

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
    elseif (strpos($output, 'data') !== false) {
    //echo "LIVE<br>";
	
	
			//echo $URL."<br>";
			
				
			exec ('net use "\\\\'.$host.'" /user:"manage_atm" "diebold" /persistent:no') ;
		//echo "connected <br>";
		$URL="\\\\".$host."\\EjLogs\\";
    $URL="\\\\".$host."\\D$\Camera\Images\\";

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




/*}else{
	?>
					<script>
document.getElementById("view").innerHTML =  "ATM type not is selected!";<!---check if the date fld is empty-->
</script>
<?php			
}//radio bn */






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
