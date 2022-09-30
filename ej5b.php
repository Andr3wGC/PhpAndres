<HTML>
<HEAD><TITLE> EJ4B – Tabla Multiplicar</TITLE></HEAD>
<BODY>

<?php
$num="8";
echo "<table style='border:1px solid black'>";
for($i=1;$i<11;$i++){
	echo "<tr>";
	echo "<td style='border:1px solid black'>$num x $i </td><td style='border:1px solid black'>",$num*$i,"</td>";
	
	echo "</tr>";
	

}
echo "</table>";
?>

</BODY>
</HTML>