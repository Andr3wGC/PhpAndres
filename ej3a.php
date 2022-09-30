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

	echo "<tr>";
	echo "<td style='border:1px solid black'>$x </td><td style='border:1px solid black'>","$numbin","</td><td style='border:1px solid black'>",decoct($x),"</td>";
	echo "</tr>";
	$numbin="";
}






/*$arrlength = count($imnums);
$i=0;
$suma=0;

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
$num="127";
$dividido=$num;
$numbin="";
	 if($dividido%2==0){
		 $numbin="0 $numbin";
	 }else{
		 $numbin="1 $numbin";
	 }

echo $numbin;
*/


echo "<br>";
echo "</table>";
?>

</BODY>
</HTML>