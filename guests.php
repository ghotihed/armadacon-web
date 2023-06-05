<!doctype html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Guests</title>
<link rel="stylesheet" href="ArmadaCon.css" type="text/css">

<script type="text/javascript">
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
</script>
</head>

<body>
  
<?php
$foo="GuestsTable";
include('Header.php');
?>
    
  <td><table width="750" border="0">
  <tbody>
   <tr>
      <td width="50%" rowspan="1" align="center" valign="top"><a href="guest1.php"><h1>Guest1</h1><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="Images/guest.jpg" width="224" height="249" alt="guest1" /></h1></a></td>
      
<td width="50%" rowspan="1" valign="top" align="center"><a href="guest2.php"><h1>Guest2</h1><img src="Images/guest.jpg" width="224" height="249" alt="guest2" /></h1></a></td>
    </tr>

    <td width="50%" rowspan="1" valign="top" align="center"><a href="guest3.php"><h1>Guest3</h1><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="Images/guest.jpg" width="224" height="224" alt="guest3" /></h1></a></td>    

    <td width="50%" rowspan="1" valign="top" align="center"><a href="guest4.php"><h1>Guest4</h1><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="Images/guest.jpg" width="224" height="224" alt="guest4" /></h1></a></td> 
    
  </tbody>
</table>
<?php
include('Sponsors-Footer.php');
?>

</body>
</html>
