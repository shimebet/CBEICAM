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
		<input type="text" name="date_fld" id="date_id" placeholder= "ddmmyyyy"><br><br>
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
		<input type="submit" name="search" value="veiw" >
		<input type="submit" name="download" value="Download" onclick="go_to_download()">
		</td>
		</tr>
		<label id="view" style = "color:red;"></label>
		</form>
		
		
		</fieldset>
		</center>
		</div>
	</div>
	
	
<script type="text/javascript">
      $(function () {
          $("#date_id").date_fld({ dateFormat: 'dd/mm/y' });
      });
  </script>
<?php

if(isset($_POST["download"])){
	//$date_vl = new DateTime($_POST['date_fld']);
	//$date_vl = date_format('ddmmyy',$date_vl);
	if(!empty($_POST["term_id"]) && isset($_POST["term_id"])) {
  
				$host = "10.1.7.150";
			exec ('net use "\\\\'.$host.'" /user:"Reconciliation@cbe.com.et" "Welcome2cbe" /persistent:no');
			//$URL='\\\\'.$host.'\\\\'.$_POST['term_id'];
	       // $fname =$URL."\\".$_POST['date_fld'];
	
	$URL='\\\\'.$host.'\\\\atm\\atmej\\'.$_POST['date_fld'];
			$fname =$URL."\\".$_POST['term_id']."".$_POST['date_fld'];
			
			if (isset($_POST['date_fld']) && !empty($_POST['date_fld'])){
				
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
if(isset($_POST['search']))
{
		if(!empty($_POST['term_id']) && isset($_POST["term_id"])){
			
			$host = "10.1.7.150";
			exec ('net use "\\\\'.$host.'" /user:"Reconciliation@cbe.com.et" "Welcome2cbe" /persistent:no');
	//$URL='\\\\'.$host.'\\\\'.$_POST['term_id'];
	//		$fname =$URL."\\".$_POST['date_fld'];
	
            $URL='\\\\'.$host.'\\\\ATM\\ATMEJ\\'.$_POST['date_fld'];
			$fname =$URL."\\".$_POST['term_id']."".$_POST['date_fld'];	
			
		if (isset($_POST['date_fld']) && !empty($_POST['date_fld'])){
			
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
										
					$myfile = fopen($fname1, "r+") or die("Unable to open file!");
//$pr =  fread($myfile,filesize($fname1));
?>
<div class ="view_class">
	<center class = "center_view">
	<?php
	if ($file = fopen($fname1, "r")) {
    while(!feof($file)) {
        $line = fgets($file);
        # do same stuff with the $line
		echo "<pre style='align:left'>" .$line."</pre>";
		?>
		<br>
		<?php
    }
    fclose($file);
}
//echo $pr;
	
	?>
	</center>
	</div>
<?php
fclose($myfile);
				
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
}
?>
<?php?>
	</br>
		</div>
	
	<div class ="Entire_Page">
	<center>
	<div class="footer">
	<p style="padding-top:5px;">Commercial Bank of Ethiopia | <a href="http://www.combanketh.et/" target="_blank" style="text-decoration:none; color:#FF9900">www.combanketh.com </a> </p>
	<p   style = "padding-bottom:0px;margin-bottom:0px;">Copyright 2019-Commercial Bank of Ethiopia. All Rights Reserved!<p style = "font-size:12px; color:#CC6600;font-style:italic;padding-top:0px;float :right;" >developed by switch management team</p></p>
	
			</div>
		
		</center>
		</div>
		
		</body>
</html>
