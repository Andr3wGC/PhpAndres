<HTML>
<HEAD><TITLE> EJ4B – Tabla Multiplicar</TITLE></HEAD>
<BODY>

<?php
echo "<table style='border:1px solid black'>";
$binnums= array();
echo "<th style='border:1px solid black'> Indice </th><th style='border:1px solid black'> Binario </th><th style='border:1px solid black'> Octal </th>";


for($x=0;$x<20;$x++){
	$dividido=$x;
	$i=$x;
	$numbin="";
if($dividido==1){
		$numbin=1;
	}elseif($dividido==2){
		$numbin=10;
	}else{
	do{
	$dividido=$dividido%2;
	$numbin="$dividido $numbin";	
	$i=$i/2;
	$dividido=$i;
	}while($i>=1);

}
	$binnums[$x]=$numbin;
	echo "<tr>";
	echo "<td style='border:1px solid black'>$x </td><td style='border:1px solid black'>","$binnums[$x]","</td><td style='border:1px solid black'>",decoct($x),"</td>";
	echo "</tr>";
	
	$numbin="";
}
echo "<br>";
echo "</table>";

	$invertido=array();
	$i=0;
	for($x=19;$x>=0;$x--){
		$invertido[$i]=$binnums[$x];
		echo "$invertido[$i]","<br>";
		$i++;
		
		
	}









?>

</BODY>
</HTML>