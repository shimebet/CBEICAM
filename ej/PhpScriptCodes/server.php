
<?php require_once("connection.php"); ?>

<?php 



//$conn = oci_connect('mxatm', 'mxatm', '//10.1.6.13/mgxsid');


$Page_Type = $_GET['Page_Type'];
$Terminal_Id = $_GET['Terminal_ID'];
 $array = array('Terminal ID ','Terminal name','Transacion date','Trn. Time','Card number','Exchange<br>Rate','Trans<br>/ETB',	'Trans<br>/USD','Comision<br>/ETB','Comision<br>/USD','Net Amount<br>/ETB','Net Amount<br>/USD');
 
$Q = "SELECT  to_date(SYSDATE,'dd/mm/yyyy') FROM TGEN572";//24/06/2018
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
 

if($Page_Type=='Single')
{

	$Sing_Date = $_GET['S_Date'];
	if($Terminal_Id == "")
	{
	//  AND (BOCBE.CHANGE.CHG_DATCONV='$TODAY_DATE') 
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
and (CRD_IDN_TXT LIKE '458300%' OR CRD_IDN_TXT LIKE '419714%' OR CRD_IDN_TXT LIKE '419715%'
OR CRD_IDN_TXT LIKE '465372%' OR  CRD_IDN_TXT LIKE '458571%' OR  CRD_IDN_TXT LIKE '475194%'
  OR  CRD_IDN_TXT LIKE '925511%' OR  CRD_IDN_TXT LIKE '227383%'
OR  CRD_IDN_TXT LIKE '970907%' OR  CRD_IDN_TXT LIKE '471297%' )
ORDER BY LNG_MHT_NME_TXT";

	}
	else
	{ 
	//AND (BOCBE.CHANGE.CHG_DATCONV='$TODAY_DATE')CRY_RTE_NBR,
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
and (CRD_IDN_TXT LIKE '458300%' OR CRD_IDN_TXT LIKE '419714%' OR CRD_IDN_TXT LIKE '419715%'
OR CRD_IDN_TXT LIKE '465372%' OR  CRD_IDN_TXT LIKE '458571%' OR  CRD_IDN_TXT LIKE '475194%'
  OR  CRD_IDN_TXT LIKE '925511%' OR  CRD_IDN_TXT LIKE '227383%'
OR  CRD_IDN_TXT LIKE '970907%' OR  CRD_IDN_TXT LIKE '471297%' )

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
	  //$Com_Birr_Tot=0;
	  //$Com_Doll_Tot=0;
	  //$Net_Birr_Tot=0;
	  //$Net_Doll_Tot=0;
	  
	   echo "<b> <font size='+1'>This table shows the POS settlement report you searched for </font></b> ";
	   
	   echo "<table border='0px'> <tr>";
	   for ($i = 0; $i < 7; $i++)	 
		echo "<th bgcolor='#882F6D'>".$array[$i].'</th>'; 
	    print('</tr>');	 
	    while($row1 = oci_fetch_array($parse1, OCI_RETURN_NULLS))
	    {  
	      $local  = substr($row1[4],0,6);
		 // $row1[4] = substr($row1[4],0,6)."xxxxxx".substr($row1[4],12,8); // Casting of card number
		  $currency_type =  $row1[5];
		  $void_or_not = $row1[6];
		 if($currency_type==840)
		 { 
		    if($void_or_not!='#')
		    {
				 $row1[7] = $row1[6]; // swapping Transaction in birr to Transaction in USD				
				if($local==471297 || $local==458300 || $local == 419714 || $local == 419715 || $local == 465372 || $local == 458571 || $local == 475194 || $local == 925511 || $local == 227383 || $local == 970907)	
				  $row1[9] = 0;
				 else
				  $row1[9]=(2*$row1[7])/100;

			  $row1[11] = $row1[7]-$row1[9];
			  $row1[6] ="---"; 
			  $row1[8]="---";
			  $row1[10]="---";
			   
				
			  $Tr_Doll_Tot=$Tr_Doll_Tot+$row1[7];		  
			 
			  //$Com_Doll_Tot= $Com_Doll_Tot+ $row1[9];		  
			 
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
				 if($local==471297 || $local==458300 || $local == 419714 || $local == 419715 || $local == 465372 || $local == 458571 || $local == 475194 || $local == 925511 || $local == 227383 || $local == 970907)				
					$row1[8]=0;	// Commision in Birr
				 else
					$row1[8]=(2*$row1[6])/100;
					
				  $row1[7]= substr($row1[6]/ $row1[5],0,7);		
				  $row1[9] = substr($row1[8]/$row1[5],0,7);	
				  $row1[10] = $row1[6]-$row1[8];
				  $row1[11] = $row1[7]-$row1[9];
				  
				  $Tr_Birr_Tot=$Tr_Birr_Tot+$row1[6];
				  $Tr_Doll_Tot=$Tr_Doll_Tot+$row1[7];		
				  
				  //$Com_Birr_Tot=$Com_Birr_Tot+$row1[8];
				  //$Com_Doll_Tot= $Com_Doll_Tot+$row1[9];		
				  
				  //$Net_Birr_Tot=$Net_Birr_Tot+$row1[10];		
				  //$Net_Doll_Tot=$Net_Doll_Tot+$row1[11];
				  
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
		   		$output .= "<td style='background-color:#E0C5DF; font-weight:bold'>$tot[$t]</td>";		
	       else 
		   		$output .= "<td style='background-color:white; font-weight:bold'>$tot[$t]</td> ";		 
		  }
		   print(trim($output))."</tr>\t\n";
		 
	   
	   echo('</table>'); 
	   
}


else if($Page_Type=='Interval')
{
   //$CONPW = mysql_real_escape_string($_GET['Conf']);
   $Date1 = $_GET['Date1'];
   $Date2 = $_GET['Date2'];		
    if(	$Terminal_Id == '')
	{	  // AND (BOCBE.CHANGE.CHG_DATCONV='$TODAY_DATE')
$query = "SELECT  TML_IDN_TXT,
LNG_MHT_NME_TXT,
TXN_CPR_DTE,
TXN_CPR_TME,
CRD_IDN_TXT,
CRY_RTE_NBR/10000,
OGL_TXN_TOT_AMT
FROM TGEN509,TGEN534,TGEN572
WHERE  (RTE_DTE = to_date('24/06/2018','dd/mm/yyyy') )
AND (TXN_CPR_DTE BETWEEN to_date('$Date1','dd/mm/yyyy') AND to_date('$Date2','dd/mm/yyyy') )   
and TXN_MHT_ITL_NBR=MHT_ITL_NBR
AND (EXT_MCC_CDE != '6011')
AND ((OGL_TXN_TOT_AMT/100) > 0.01)
ORDER BY LNG_MHT_NME_TXT";
	}
	else
	{// AND (BOCBE.CHANGE.CHG_DATCONV='$TODAY_DATE')
	$query = "SELECT  TML_IDN_TXT,
LNG_MHT_NME_TXT,
TXN_CPR_DTE,
TXN_CPR_TME,
CRD_IDN_TXT,
CRY_RTE_NBR/10000,
OGL_TXN_TOT_AMT
FROM TGEN509,TGEN534,TGEN572
WHERE  (RTE_DTE = to_date('24/06/2018','dd/mm/yyyy') )
AND (TXN_CPR_DTE BETWEEN to_date('$Date1','dd/mm/yyyy') AND to_date('$Date2','dd/mm/yyyy') )  
and TXN_MHT_ITL_NBR=MHT_ITL_NBR
AND (EXT_MCC_CDE != '6011')
and TML_IDN_TXT='$Terminal_Id'
AND ((OGL_TXN_TOT_AMT/100) > 0.01)
ORDER BY LNG_MHT_NME_TXT";
		
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
	  //om_Birr_Tot=0;
	  //om_Doll_Tot=0;
	  //et_Birr_Tot=0;
	  //et_Doll_Tot=0;
	  
	   echo "<b> <font size='+1'>This table shows the POS settlement report you searched for </font></b> ";
	   
	   echo "<table border='0px'> <tr>";
	   for ($i = 0; $i < 7; $i++)	 
		echo "<th bgcolor='#882F6D'>".$array[$i].'</th>'; 
	    print('</tr>');	 
	    while($row = oci_fetch_array($parse, OCI_RETURN_NULLS))
	    {  
	      $local  = substr($row[4],0,6);
		 // $row[4] = substr($row[4],0,6)."xxxxxx".substr($row[4],12,8); // Casting of card number
		 $currency_type =  $row[5];
		 $void_or_not = $row[6];
		 if($currency_type==840)
		 { 
		    if($void_or_not!='#')
		    {
		 	 $row[7] = $row[6]; // swapping Transaction in birr to Transaction in USD
			
			 if($local==458300 || $local == 627383 || $local == 458571 || $local == 475194)	
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
		 
		  //om_Doll_Tot= $Com_Doll_Tot+ $row[9];		  
		 
		  $Net_Doll_Tot=$Net_Doll_Tot+$row[11];
		  
			  $output = '<tr>';
			  for($j=0;$j<7;$j++)
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
				 	$row[8]=0;	// Commision in Birr			 
				 else
					$row[8]=(2*$row[6])/100;
					
			  $row[7]= substr($row[6]/ $row[5],0,7);		
			  $row[9] = substr($row[8]/$row[5],0,7);	
			  $row[10] = $row[6]-$row[8];
			  $row[11] = $row[7]-$row[9];
			  
			  $Tr_Birr_Tot=$Tr_Birr_Tot+$row[6];
			  $Tr_Doll_Tot=$Tr_Doll_Tot+$row[7];		
			  
			  //om_Birr_Tot=$Com_Birr_Tot+$row[8];
			 //Com_Doll_Tot= $Com_Doll_Tot+$row[9];		
			  
			 //Net_Birr_Tot=$Net_Birr_Tot+$row[10];		
			  //et_Doll_Tot=$Net_Doll_Tot+$row[11];		
		  
			  $output = '<tr>';
			  for($j=0;$j<7;$j++)
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
	     
	   }//end of while
	    $output = '<tr>';
	     for($t=0;$t<7;$t++)
		  {
		   $tot = array("","","","","","Total", $Tr_Birr_Tot,$Tr_Doll_Tot);
		   if($k%2!=0) 
		   		$output .= "<td style='background-color:#E0C5DF; font-weight:bold'>$tot[$t]</td>";		
	       else 
		   		$output .= "<td style='background-color:white; font-weight:bold'>$tot[$t]</td> ";		 
		  }
		   print(trim($output))."</tr>\t\n";
		 
	   
	   echo('</table>'); 
	   
	  
}




oci_close($conn);  
?>
