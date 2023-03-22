<center class = "center_view"><h2 style= "align:center;">DISTRICT ATM's CASSET STATUS</h2>
<?php


	 if(isset($_POST["cassetview"])){
	    if((!empty($_POST['term_id']) && isset($_POST["term_id"]))||(!empty($_POST['dropdown']) && isset($_POST["dropdown"]))){
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
		
if ($file2 = fopen($URL1, "r")) {
	
    while(($line1=fgets($file2))!==false) {
		
        $split = explode(";",$line1);
		$terminal_id= $split[0];
		$ip= $split[1];
		$atm_type =$split[2];
		$dwnld_file_name = $terminal_id."".$rev_date.".txt";
				
				
				if((!empty($_POST['term_id']) && isset($_POST["term_id"]))){
				$district_name = substr($_POST['term_id'],0,3);
				}else{
				$district_name=$_POST['dropdown'];
				}
 if ($district_name==substr($terminal_id,0,3)){
		$host = $ip;
		   //echo $line1."<br>";
           //print_r ($split);
	       //echo $terminal_id ."<br>andu<br>". $host."<br>";
		   
		   
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

<h3><?php
	echo "<pre>".$terminal_id."<br>";
	?></h3><?php
	
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

<h3><?php
	echo "<pre>".$terminal_id."<br>";
	?></h3><?php

echo "<pre>$output</pre> <p style = 'color:red'> Network Error!<br>";
	
	?>
	</center>
	</div>
<?php
}
    elseif (strpos($output, 'data') !== false) {
    //echo "LIVE<br>";
	 ?>
<div class ="view_class">
	<center class = "center_view">
<?php
	
			//echo $URL."<br>";
			
				
			exec ('net use "\\\\'.$host.'" /user:"Administrator" "Sstautocbe2020NCR" /persistent:no') ;
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
	
                    //$myfile = fopen($fname1, "r+") or die("Unable to open file!");
//$pr =  fread($myfile,filesize($fname1));

	//set_time_limit(360);
	if ($file = fopen($fname1, "r")) {
		$c=0;
    while(!feof($file)) {
        $line = fgets($file);
        # do same stuff with the $line
		//echo strlen($line)."\n";
$CASH_TOTAL =explode("CASH TOTAL",$line);
$DENOMINATION=explode("DENOMINATION",$line);
$DISPENSED=explode("DISPENSED",$line);
$REJECTED=explode("REJECTED",$line);
$REMAINING=explode("REMAINING",$line);

$cash ="CASH TOTAL........".substr($CASH_TOTAL[sizeof($CASH_TOTAL)-1],0,30);
$denominations ="DENOMINATION......".substr($DENOMINATION[sizeof($DENOMINATION)-1],0,28);
$despens ="DISPENSED.........".substr($DISPENSED[sizeof($DISPENSED)-1],0,31);
$reject ="REJECTED.........".substr($REJECTED[sizeof($REJECTED)-1],0,32);
$remain ="REMAINING.........".substr($REMAINING[sizeof($REMAINING)-1],0,31);


    }?>

	<div class = "column">
	
	<h3><?php
	echo "<pre>".$terminal_id." ___ ".$host."<br>";
	?></h3><?php
echo "<pre>".$cash."<br>";
echo "<pre>".$denominations."<br>";
echo "<pre>".$despens."<br>";
echo "<pre>".$reject."<br>";
echo "<pre>".$remain."<br>";
?></div><?php

    fclose($file);
}

	
}else{
	?>
					<script>
document.getElementById("view").innerHTML =  "EJ not found!!"; <!---check if file name is not found-->
</script>
<?php  
}
 
?>
	</center>
	</div>
<?php 

		}else{
			?>
<div class ="view_class">
	<center class = "center_view">


<h3><?php
	echo "<pre>".$terminal_id."<br>";
	?></h3><?php
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
<h3><?php
	echo "<pre>".$terminal_id."<br>";
	?></h3><?php

echo "<pre>$output</pre> <p style = 'color:red'> Unknown Error!<br>";
	
	?>
	</center>
	</div>
<?php
}


}
		   
		   //break;
		}
	}}
	}else{
		?>
					<script>
document.getElementById("view").innerHTML =  "Terminal id and ip adress list does not exist!";<!---check if the terminal id list file is empty-->
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
document.getElementById("view").innerHTML =  "Empty terminal id!";<!---check if the terminal id fld is empty-->
</script>
<?php					
		}
}

?>