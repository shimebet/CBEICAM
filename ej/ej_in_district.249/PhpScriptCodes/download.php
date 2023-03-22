 
<?php
require_once("connection.php");

$Page_Type = trim($_POST['Date']);
$Terminal_Id = $_POST['Terminal_ID'];

 $Terminal_new=substr($Terminal_Id,0,8);

//echo "<meta http-equiv='refresh' content='0;URL=download.php'>";
header('Content-Type: application/.xls');	//define header info for browser
header('Content-Disposition: attachment; filename='.$Terminal_new.'_POS_Settlement_Report-'.date('Ymd').'.xls');
header('Pragma: no-cache');
header('Expires: 0');   


//$conn = oci_connect('mxatm', 'mxatm', '//10.1.6.13/mgxsid');

// $today = getdate();
// $report_time = $today['mday']."/".$today['mon']."/".$today['year'];
 
$Q = "SELECT  to_date(SYSDATE,'dd/mm/yyyy') FROM TGEN572";
$P = oci_parse($conn, $Q);
if (!$P)
	 {
    	$e = oci_error($conn);
    	print htmlentities($e['message']);
    	exit;
   	}
$R = oci_execute($P, OCI_DEFAULT);	 
while($RW = oci_fetch_array($P, OCI_RETURN_NULLS))
{
$TODAY_DATE ='24/06/2018';	
}

		
 $array = array('Terminal ID ','Terminal name','Transacion date','Trn. Time','Card number','Exchange<br>Rate','Trans<br>/ETB',	'Trans<br>/USD','Comision<br>/ETB','Comision<br>/USD','Net Amount<br>/ETB','Net Amount<br>/USD');
 
 echo "<hr>";
 echo "<center> <img src='C:\wamp\www\POS_REPORT\images/logo.png' width='150px' height='40px' align='right'>  </center>";
 echo "<br><br><br>";
 
if($Page_Type=='Single')
{

	$Sing_Date = (string)$_POST['dd'].'/'.$_POST['mm'].'/'.$_POST['yy'];	 
	if($Terminal_Id=="")
	{
	// AND (CHANGE.CHG_DATCONV='$TODAY_DATE')
	$Merchant_Name="";


	$query1  = "SELECT  TML_IDN_TXT,
LNG_MHT_NME_TXT,
TXN_CPR_DTE,
TXN_CPR_TME,
CRD_IDN_TXT,
CRY_RTE_NBR/10000,
OGL_TXN_TOT_AMT
FROM TGEN509,TGEN534,TGEN572
WHERE  (RTE_DTE = to_date('24/06/2018','dd/mm/yyyy') )
AND (TXN_CPR_DTE = to_date('$Sing_Date','dd/mm/yyyy') )  
and TXN_MHT_ITL_NBR=MHT_ITL_NBR
AND (EXT_MCC_CDE != '6011')
AND ((OGL_TXN_TOT_AMT/100) > 0.01)
ORDER BY LNG_MHT_NME_TXT";

	}
	else
	{ 
	//AND (CHANGE.CHG_DATCONV='$TODAY_DATE')
	$Merchant_Name="Temporary";	
	$q = "SELECT  TML_IDN_TXT,
LNG_MHT_NME_TXT,
TXN_CPR_DTE,
TXN_CPR_TME,
CRD_IDN_TXT,
CRY_RTE_NBR/10000,
OGL_TXN_TOT_AMT
FROM TGEN509,TGEN534,TGEN572
WHERE  (RTE_DTE = to_date('24/06/2018','dd/mm/yyyy') )
AND (TXN_CPR_DTE = to_date('$Sing_Date','dd/mm/yyyy') )  
and TXN_MHT_ITL_NBR=MHT_ITL_NBR
AND (EXT_MCC_CDE != '6011')
and TML_IDN_TXT='$Terminal_Id'
AND ((OGL_TXN_TOT_AMT/100) > 0.01)
ORDER BY LNG_MHT_NME_TXT";
	
	$p  = oci_parse($conn, $q);
    if (!$p)
	    {
			$e = oci_error($conn);
			print htmlentities($e['message']);
			exit;
    	}
     $r = oci_execute($p, OCI_DEFAULT);	 
	 
	$query1  = "SELECT  TML_IDN_TXT,
LNG_MHT_NME_TXT,
TXN_CPR_DTE,
TXN_CPR_TME,
CRD_IDN_TXT,
CRY_RTE_NBR/10000,
OGL_TXN_TOT_AMT
FROM TGEN509,TGEN534,TGEN572
WHERE  (RTE_DTE = to_date('24/06/2018','dd/mm/yyyy') )
AND (TXN_CPR_DTE = to_date('$Sing_Date','dd/mm/yyyy') )  
and TXN_MHT_ITL_NBR=MHT_ITL_NBR
AND (EXT_MCC_CDE != '6011')
and TML_IDN_TXT='$Terminal_Id'
AND ((OGL_TXN_TOT_AMT/100) > 0.01)
ORDER BY LNG_MHT_NME_TXT";
	}


$parse1 = oci_parse($conn, $query1);
if (!$parse1)
	 {
    	$e = oci_error($conn);
    	print htmlentities($e['message']);
    	exit;
   	}
     $result1 = oci_execute($parse1, OCI_DEFAULT);	 
	  $k=0;
	  $Tr_Birr_Tot=0;
	  $Tr_Doll_Tot=0;
	  
	  
	   if($Merchant_Name=="Temporary")
	   {
		   while($rr = oci_fetch_array($p, OCI_RETURN_NULLS))
			{
				$Merchant_Name = $rr[1];
			}
			echo "<b>Merchant Name : <font color='green'>".$Merchant_Name."</font></b><br>";
			 
	   }
	   echo "<b>Transaction Date : <font color='green'>".$Sing_Date."</font><br>";	   
	   echo "Report Generated Date : <font color='green'>".$TODAY_DATE."</font><br> </b><hr>";	 
	   echo "<table border='0px' width='100%'> <tr>";
	   for ($i = 0; $i < 7; $i++)	 
		echo "<th bgcolor='#882F6D'>".$array[$i].'</th>'; 
	    print('</tr>');	 
	    while($row1 = oci_fetch_array($parse1, OCI_RETURN_NULLS))
	    {  
	      $local  = substr($row1[4],0,6);
		 // $row1[4] = substr($row1[4],0,6)."xxxxxx".substr($row1[4],12,8); // Casting of card number
		 $row1[4] = substr($row1[4],0,6)."-".substr($row1[4],6,13);
		$currency_type =  $row1[5];
		  $void_or_not = $row1[6];
		 if($currency_type==840)
		 { 
		    if($void_or_not!='#')
		    {
				 $row1[7] = $row1[6]; // swapping Transaction in birr to Transaction in USD				
				 if($local==458300 || $local == 627383 || $local == 458571 || $local == 475194)	
				  $row1[9] = 0;
				 else
				  $row1[9]=(2*$row1[7])/100;
				   $row1[11] = $row1[7]-$row1[9];
				   $row1[6] ="---"; 
				   $row1[8]="---";
				   $row1[10]="---";
				   
				
			  $Tr_Doll_Tot=$Tr_Doll_Tot+$row1[7];		  
			 
			  ///m_Doll_Tot= $Com_Doll_Tot+ $row1[9];		  
			 
			  $Net_Doll_Tot=$Net_Doll_Tot+$row1[11];// Making Transaction in Birr void
		
		  $output = '<tr>';
		  for($j=0;$j<7;$j++)
		  {
		   if($k%2!=0) 
		   		$output .= "<td style='background-color:#E0C5DF'>$row1[$j]</td>";		
	       else 
		   		$output .= "<td style='background-color:white'>$row1[$j]</td>";		 
		  }
		  $k++;
		  		  
		  print(trim($output))."</tr>\t\n";
		  } // end of  if($void_or_not!='#')
		  
		 } // end of  if($currency_type==840)		 
		 
		 else 
		 {
		   if($void_or_not!='#')
		    {
				 if($local==458300 || $local == 627383 || $local == 458571 || $local == 475194 || $local == 927383 || $local == 471297 || $local == 419715 || $local == 431997 || $local == 465372)				
					$row1[8]=0;	// Commision in Birr
				 else
					$row1[8]=(2*$row1[6])/100;
					
				  $row1[7]= substr($row1[6]/ $row1[5],0,7);		
				  $row1[9] = substr($row1[8]/$row1[5],0,7);	
				  $row1[10] = $row1[6]-$row1[8];
				  $row1[11] = $row1[7]-$row1[9];
				  
				  $Tr_Birr_Tot=$Tr_Birr_Tot+$row1[6];
				  $Tr_Doll_Tot=$Tr_Doll_Tot+$row1[7];		
				  
				 
				  
		  $output = '<tr>';
		  for($j=0;$j<7;$j++)
		  {
		   if($k%2!=0) 
		   		$output .= "<td style='background-color:#E0C5DF'>$row1[$j]</td>";		
	       else 
		   		$output .= "<td style='background-color:white'>$row1[$j]</td>";		 
		  }
		  $k++;
		  		  
		  print(trim($output))."</tr>\t\n";
		  } // end of if($void_or_not!='#')	
		  
		 }// end of  else 
		 
	     
	   } // end of while 
	    $output = '<tr>';
	     for($t=0;$t<7;$t++)
		  {
		   $tot = array("","","","","","Total", $Tr_Birr_Tot,$Tr_Doll_Tot);
		   if($k%2!=0) 
		   		$output .= "<td style='background-color:#882F6D; font-weight:bold'>$tot[$t]</td>";		
	       else 
		   		$output .= "<td style='background-color:#882F6D; font-weight:bold'>$tot[$t]</td> ";		 
		  }
		   print(trim($output))."</tr>\t\n";
		 
	   
	   echo('</table>'); 
	    
	   
}


else if($Page_Type=='Interval')
{
   	$Date1 = $_POST['d1'].'/'.$_POST['m1'].'/'.$_POST['y1'];
	$Date2 = $_POST['d2'].'/'.$_POST['m2'].'/'.$_POST['y2'];	
    if(	$Terminal_Id == "")
	{	
	$Merchant_Name="";  
	

	
	
$query = "SELECT TRS_NUMCMR,CMR_NOM,TRS_TRTDATE,TRS_HEURETRS,TRS_CODPORTEUR,CHG_ACHAT,TRS_MONTANT,TRS_DEVISE,TRS_TYPTOP from BOCBE.TRANSACTION, MXPOS30.COMMERCANT,BOCBE.CHANGE WHERE (BOCBE.TRANSACTION.TRS_NUMCMR = MXPOS30.COMMERCANT.CMR_NUMCMR ) AND ( BOCBE.TRANSACTION.TRS_ETAT='02') AND ( BOCBE.TRANSACTION.TRS_ORIGINPOR='I') AND (BOCBE.CHANGE.CHG_CODDEV1 = '840') AND (TRS_TRTDATE BETWEEN to_date('$Date1','dd/mm/yyyy') AND to_date('$Date2','dd/mm/yyyy') ) ORDER BY 
TRS_NUMCMR ASC, TRS_TRTDATE ASC,TRS_HEURETRS ASC";
	}
	else
	{
	$Merchant_Name="Temporary";	
	$q = "SELECT TRS_NUMCMR,CMR_NOM,TRS_TRTDATE,TRS_HEURETRS,TRS_CODPORTEUR,CHG_ACHAT,TRS_MONTANT,TRS_DEVISE,TRS_TYPTOP from BOCBE.TRANSACTION, MXPOS30.COMMERCANT,BOCBE.CHANGE WHERE ( BOCBE.TRANSACTION.TRS_NUMCMR='$Terminal_Id' ) AND ( BOCBE.TRANSACTION.TRS_ETAT='02') AND ( BOCBE.TRANSACTION.TRS_ORIGINPOR='I') AND (BOCBE.TRANSACTION.TRS_NUMCMR = MXPOS30.COMMERCANT.CMR_NUMCMR ) AND (BOCBE.CHANGE.CHG_CODDEV1 = '840') AND (TRS_TRTDATE BETWEEN to_date('$Date1','dd/mm/yyyy') AND to_date('$Date2','dd/mm/yyyy') ) ORDER BY TRS_TRTDATE";
	$p  = oci_parse($conn, $q);
    if (!$p)
	    {
			$e = oci_error($conn);
			print htmlentities($e['message']);
			exit;
    	}
     $r = oci_execute($p, OCI_DEFAULT);	 
	 
		$query = "SELECT TRS_NUMCMR,CMR_NOM,TRS_TRTDATE,TRS_HEURETRS,TRS_CODPORTEUR,CHG_ACHAT,TRS_MONTANT,TRS_DEVISE,TRS_TYPTOP from BOCBE.TRANSACTION, MXPOS30.COMMERCANT,BOCBE.CHANGE WHERE ( BOCBE.TRANSACTION.TRS_NUMCMR='$Terminal_Id' ) AND ( BOCBE.TRANSACTION.TRS_ETAT='02') AND ( BOCBE.TRANSACTION.TRS_ORIGINPOR='I') AND (BOCBE.TRANSACTION.TRS_NUMCMR = MXPOS30.COMMERCANT.CMR_NUMCMR ) AND (BOCBE.CHANGE.CHG_CODDEV1 = '840') AND (TRS_TRTDATE BETWEEN to_date('$Date1','dd/mm/yyyy') AND to_date('$Date2','dd/mm/yyyy') ) ORDER BY TRS_TRTDATE";
	}
	$parse = oci_parse($conn, $query);
if (!$parse)
	 {
    	$e = oci_error($conn);
    	print htmlentities($e['message']);
    	exit;
   	}
     $result = oci_execute($parse, OCI_DEFAULT);	 
	  $k=0;
	  $Tr_Birr_Tot=0;
	  $Tr_Doll_Tot=0;
	  $Com_Birr_Tot=0;
	  $Com_Doll_Tot=0;
	  $Net_Birr_Tot=0;
	  $Net_Doll_Tot=0;
	  
	 if($Merchant_Name=="Temporary")
	   {
		   while($rr = oci_fetch_array($p, OCI_RETURN_NULLS))
			{
				$Merchant_Name = $rr[1];
			}
			echo "<b>Merchant Name : <font color='green'>".$Merchant_Name."</font></b><br>";
			 
	   }
	   echo "<b>Transaction Date : From <font color='green'>".$Date1."</font> To <font color='green'>".$Date2."</font> <br>";	   
	   echo "Report Generated Date : <font color='green'>".$TODAY_DATE."</font><br> </b><hr>";	 
	   echo "<table width='100%' border='0px'> <tr>";
	   for ($i = 0; $i < 8; $i++)	 
		echo "<th bgcolor='#882F6D'>".$array[$i].'</th>'; 
	    print('</tr>');	 
	    while($row = oci_fetch_array($parse, OCI_RETURN_NULLS))
	    {  
	      $local  = substr($row[4],0,6);
		  // $row1[4] = substr($row1[4],0,6)."xxxxxx".substr($row1[4],12,8); // Casting of card number
		  $row[4] = substr($row[4],0,6)."-".substr($row[4],6,13);
		 $currency_type =  $row[7];
		 $void_or_not = $row[8];
		 if($currency_type==840)
		 { 
		    if($void_or_not!='#')
		    {
		 	 $row[7] = $row[6]; // swapping Transaction in birr to Transaction in USD
			
			 if($local==458300 || $local == 627383 || $local == 458571 || $local == 475194 || $local == 927383 || $local == 471297 || $local == 419715 || $local == 431997 || $local == 465372)	
			 {
			  $row[9] = 0;
			 }
			 else
			 {
			  $row[9]=(2*$row[7])/100;
			 }
			   $row[11] = $row[7]-$row[9];
			   $row[6] ="---"; 
			   $row[8]="---";
			   $row[10]="---";
			   
			
		  $Tr_Doll_Tot=$Tr_Doll_Tot+$row[7];		  
		 
		  $Com_Doll_Tot= $Com_Doll_Tot+ $row[9];		  
		 
		  $Net_Doll_Tot=$Net_Doll_Tot+$row[11];
		  
			  $output = '<tr>';
			  for($j=0;$j<8;$j++)
			  {
			   if($k%2!=0) 
					$output .= "<td style='background-color:#E0C5DF'>$row[$j]</td>";		
			   else 
					$output .= "<td style='background-color:white'>$row[$j]</td>";		 
			  }
			  $k++;
					  
			  print(trim($output))."</tr>\t\n";  
			  
		 } // end of  if($void_or_not!='#')
		 } // end of if($currency_type==840)
		 else 
		 {
		  if($void_or_not!='#')
		    {
				 if($local==458300 || $local == 627383 || $local == 458571 || $local == 475194)	
				 {
								
						$row[8]=0;	// Commision in Birr
				 }
				
			  else
					$row[8]=(2*$row[6])/100;
					
			  $row[7]= substr($row[6]/ $row[5],0,7);		
			  $row[9] = substr($row[8]/$row[5],0,7);	
			  $row[10] = $row[6]-$row[8];
			  $row[11] = $row[7]-$row[9];
			  
			  $Tr_Birr_Tot=$Tr_Birr_Tot+$row[6];
			  $Tr_Doll_Tot=$Tr_Doll_Tot+$row[7];		
			  
			  $Com_Birr_Tot=$Com_Birr_Tot+$row[8];
			  $Com_Doll_Tot= $Com_Doll_Tot+$row[9];		
			  
			  $Net_Birr_Tot=$Net_Birr_Tot+$row[10];		
			  $Net_Doll_Tot=$Net_Doll_Tot+$row[11];		
		  
			  $output = '<tr>';
			  for($j=0;$j<8;$j++)
			  {
			   if($k%2!=0) 
					$output .= "<td style='background-color:#E0C5DF'>$row[$j]</td>";		
			   else 
					$output .= "<td style='background-color:white'>$row[$j]</td>";		 
			  }
			  $k++;
					  
			  print(trim($output))."</tr>\t\n";
		  } // end of  if($void_or_not!='#')
		 } // end of else
		 
	     
	   }
	    $output = '<tr>';
	     for($t=0;$t<8;$t++)
		  {
		   $tot = array("","","","","","Total", $Tr_Birr_Tot,$Tr_Doll_Tot,$Com_Birr_Tot,$Com_Doll_Tot,
		  $Net_Birr_Tot,$Net_Doll_Tot);
		   if($k%2!=0) 
		   		$output .= "<td style='background-color:#882F6D; font-weight:bold'>$tot[$t]</td>";		
	       else 
		   		$output .= "<td style='background-color:#882F6D; font-weight:bold'>$tot[$t]</td> ";		 
		  }
		   print(trim($output))."</tr>\t\n";	 
	   
	   echo('</table>'); 

} 

oci_close($conn);  
 
?>

