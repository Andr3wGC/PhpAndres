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

	echo "</tr>";
	$i++;	
}
}
$sumaPares=0;
for($x = 0; $x < 20; $x++,$x++) {
  $sumaPares+=$imnums[$x];
}
echo "La media de los pares es ",$sumaPares/10;

echo "<br>";
$sumaImpares=0;
for($x = 1; $x < 20; $x++,$x++) {
  $sumaImpares+=$imnums[$x];
}
echo "La media de los impares es ", $sumaImpares/10;
echo "</table>";
?>

</BODY>
</HTML>




