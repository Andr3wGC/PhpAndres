<HTML>
<HEAD><TITLE> EJ4B – Tabla Multiplicar</TITLE></HEAD>
<BODY>

<?php
echo "<table style='border:1px solid black'>";
$imnums= array();
$arrlength = count($imnums);
$i=0;
$suma=0;
echo "<th style='border:1px solid black'> Indice </th><th style='border:1px solid black'> Valor </th><th style='border:1px solid black'> Suma </th>";
for($x=1;$x<40;$x++){
  if(($x%2)==0){ 	
}else{$imnums[$i] = "$x";
	$suma+=$imnums[$i];
	echo "<tr>";
	echo "<td style='border:1px solid black'>$i </td><td style='border:1px solid black'>",$imnums[$i],"</td><td style='border:1px solid black'>",$suma,"</td>";
	//echo $imnums[$i];
	echo "</tr>";
	
	$i++;
	
}
}
//for

















/*
for($i=1;$i<11;$i++){
	
	
	
	
	

}
*/
echo "</table>";
?>

</BODY>
</HTML>
