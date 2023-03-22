// JavaScript Document
 
var DateForm;
  function view_hide_terminal()
  {
	 if(document.FilterForm.Terminal_ID_Check.checked)
	 {
	 document.getElementById("Terminal_ID_TD").style.display="block";
	 }
	 else
	 {	  
	  document.getElementById("Terminal_ID").value="";	  
	  document.getElementById("Terminal_ID_TD").style.display="none";
	  }
  }
  
  function display_txt_box(date_form)
  {
        if(date_form=="Terminal")
		{
		  	document.getElementById("Single_Txt_Box").style.display="block";
			document.getElementById("Interval_Txt_Box").style.display="none";
			DateForm = "Sing";
		}
  		if(date_form=="Single")
		{
		  	document.getElementById("Single_Txt_Box").style.display="block";
			document.getElementById("Interval_Txt_Box").style.display="none";
			DateForm = "Sing";
		}
		if(date_form=="Interval")
		{
			document.getElementById("Interval_Txt_Box").style.display="block";
			document.getElementById("Single_Txt_Box").style.display="none";
			DateForm="Inter";
		}
  }
  
  function go_to_filter()
  {
     var Trans_Type = document.getElementById("Trans_Type").value;
	 var Terminal_ID = document.getElementById("Terminal_ID").value.trim();
 	 var req;
	 var url;
	
	
	 if(typeof XMLHttpRequest != "undefined") {
            req = new XMLHttpRequest();
        } 
		else if (window.ActiveXObject){
            req = new ActiveXObject("Microsoft.XMLHTTP");
        }   
		
	if(Trans_Type=="Settled Transactions")
	{
	 if(DateForm=="Sing")
	 {
	 	var Single_date = document.getElementById("dd").value.trim()+'/'+
		document.getElementById("mm").value.trim()+'/'+
		document.getElementById("yy").value.trim();		
		url = "PhpScriptCodes/server.php?Page_Type=Single&Terminal_ID="+Terminal_ID+"&S_Date="+Single_date;	
        req.open('GET',url,true); 			 
        req.send(null);
		
        req.onreadystatechange= function()
        {  
		    
		   if(req.readyState==4 && req.status==200)
		   { 	 	                      
			 
			  document.getElementById("Div_Display").innerHTML = req.responseText; 
		 
           } 
		}
	 } // end of if"(DateForm="Sing")
	 
	 if(DateForm=="Inter")
	 { 
	   var date1 =  document.getElementById("d1").value.trim()+'/'+
		document.getElementById("m1").value.trim()+'/'+
		document.getElementById("y1").value.trim();
		
		var date2 =  document.getElementById("d2").value.trim()+'/'+
		document.getElementById("m2").value.trim()+'/'+
		document.getElementById("y2").value.trim();		
		
		url = "PhpScriptCodes/server.php?Page_Type=Interval&Terminal_ID="+Terminal_ID+"&Date1="+date1+"&Date2="+date2;
        req.open('GET',url,true);
        req.send(null);		
        req.onreadystatechange= function()
        {  
		   //document.getElementById("Uname_required").style.display ="none";
		   if(req.readyState==4 && req.status==200)
		   {	 
	           document.getElementById("Div_Display").innerHTML = req.responseText; 
           } 
		}
	 } //  if(DateForm=="Inter")	 
	} // end of if trans_type = "settled"
	if(Trans_Type=="All Transactions")
	{
		alert("Coming Soon");
	}
  }
  
  function go_to_download()
  {
  var S =  document.getElementById("Single_Date").value;
  var I =  document.getElementById("Ìnterval_Date").value; 

  if(document.FilterForm.Single_Date.checked || document.FilterForm.Ìnterval_Date.checked)
  	document.forms["FilterForm"].submit(); 
  else
  	alert("Please Select Either Single or Interval Date !"); 	  	
  }

  