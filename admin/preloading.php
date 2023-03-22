<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>jQuery show loading image on button click example</title>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script type="text/javascript">
$(function () {
$('#btnloading').click(function () {
$(this).html('<img src="http://www.bba-reman.com/images/fbloader.gif" />');
return false
})
$('#btnreset').click(function () {
$('#btnloading').html('Click to Set Loading Image')
})
})
</script>
</head>
<body>
<form id="form1">
<div>
<button id="btnloading" >Click to Set Loading Image</button>
<button id="btnreset" >Reset</button>
</div>
</form>
</body>
</html>