// JavaScript Document
function ValidateIPaddress(inputText)
 {
 var ipformat = /^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/;
 if(inputText.value.match(ipformat))
 {
	 
	// document.getElementById("ID").reset(); 
	 
document.form1.IP_address.focus();
	 
// document.getElementById("form1").reset(); 
	 
 var frm = document.getElementsByName('form1')[0];
   frm.submit(); // Submit the form
   frm.reset();  // Reset all form data
   //return false;
	 
 return true; 
	
	 
	 
 }
 else
 {
 alert("You have entered an invalid IP address!");
 document.form1.IP_address.focus();return false;
 }
 }



