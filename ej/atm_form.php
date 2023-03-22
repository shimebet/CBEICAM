<?php

if(isset($_POST['save']))

{
 
	
	$IP_address=@$_POST['IP_address'];
	
	$atm_type=@$_POST['ATM_TYPE'];
	
	$ID=@$_POST['ID'];
	
	$f="Atmlist.txt";

	$file=$f;
	
	
$dataString =$ID.";".$IP_address.";".$atm_type. "\r\n"; 
	 
	  $dataString .= "\n"; 
	
	
	
	//$dataString2 =$ID.";".$IP_address.";".$atm_type;
//if(file_exists($file))

	//{

	//echo "<font color='red'>file already exists</font>";$username = $_POST['username'];
 //path = 'Atmlist.txt';
$filename = $f;
$searchfor = $dataString;
$fh = fopen($filename, 'r');
$olddata = fread($fh, filesize($filename));
if(strpos($olddata, $searchfor)) {
         //strpos($olddata, $searchfor);
		 echo "ATM Teminal"  ." "  .$dataString ." already exist please insert Unique ID! ";
    		 //fount it


}

	//}



	else

	{


	$fh = fopen($f,"a");

	@fwrite($fh,$dataString);
  

	//@fclose($fWrite);
		
		echo '<div align= "center">';
		 
			echo "<B>";
			echo "your data is saved";
			echo "<B>";
			
			echo "</div>";
			
			
		}
	@fclose($fWrite);
		

}

?>


<div align= "center" >
	
	
	
<script type="text/javascript">
/*function validate(){
    x=document.form1
    input=x.ID.value
    if (input.length<8||input.length>8){
        alert("ATM ID contain comination of 3 characters and 5 numeric E.g ASA00060 !")
        return true
    }
	else {
        return false
		 document.getElementById("form1").reset(); 
		
		
    }
	 */
function validate() {
  var x = document.forms["form1"]["IP_address"].value;
	var y = document.forms["form1"]["ID"].value;
	var f = document.forms["form1"]["ATM_TYPE"].value;
	
	
  if (x == "") {
	 
	 document.form1.IP_address.focus();
	  
    alert("IP_address must be filled out");
    return false;
  }


if (/^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/.test(myForm.emailAddr.value))
  {
    return (true)
  }
alert("You have entered an invalid IP address!")
return (false)
	

if (y == "") {
	document.form1.ID.focus();
    alert("ID must be filled out");
    return false;
  }

	
}
	</script>
	
	
<script type="text/javascript">
	
function vvalidate() {
  var select = document.getElementById("select");
        if (select.value == "") {
            //If the "Please Select" option is selected display error.
            alert("Please select an option!");
            return false;
        }
        return true;
    
}

</script>
	
<script type="text/javascript">
function myFunction() {
  document.getElementById("form1").reset();
}
</script>
	

<body onload='document.form1.IP_address.focus()'>
	
<form method="post" name="form1" action="#"  onsubmit="return validate()">

	IP address: <input type="text" placeholder="IP_address" name="IP_address" required>  <br/> 
	 <br/> <br/>
	ATM_ID:<input type="text" placeholder="Terminal_ID" name="ID" maxlength="10" required> <br/> <br/><br/> 
	 
	ATM TYPE:
	<select name="ATM_TYPE" id="select">
	<option value=""></option>
	<option>NCR</option>
	<option>DIEBOLD</option>
	
	
	</select><br/><br/> <!--<script src="javascript.js"></script>-->
	

<input type="submit" value="save" name="save" onclick="return vvalidate()" />
<a href="read.php"> views</a>
</form> 
		
		
</div>