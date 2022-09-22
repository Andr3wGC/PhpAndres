<HTML>
<HEAD><TITLE> EJ2-Direccion Red – Broadcast y Rango</TITLE></HEAD>
<BODY>
<?php
$ip="192.168.16.100/31";
$punto=".";
$slash="/";
$ip1= substr($ip,(strpos($ip,$punto)+1) );
$ip2= substr($ip1,(strpos($ip1,$punto,1)+1));
$ip3= substr($ip2,(strpos($ip2,$punto,1)+1));
$mask= substr($ip3,(strpos($ip3,$slash,1)+1));
$Nred1= ($mask % 8);
echo $Nred1;
echo "<br>";
$Nred2= ($mask / 8);
$Nred2=(int)$Nred2;
echo $Nred2;

echo "<br>";
echo "<br>";
echo "<br>";

echo "IP $ip";
echo "<br>";
echo "Mascara $mask";
echo "<br>";
echo "";

echo "El numero de Direccion de red de $ip es ";
if($Nred2>=1){
	echo decbin($ip);
}else{
	$ipRed=substr($ip,(strpos($ip)+$Nred2) );
}
echo ".";
if($Nred2>=2){
	echo decbin($ip1);
}
echo ".";
if($Nred2>=3){
	echo decbin($ip2);
}
echo ".";
if($Nred2>=4){
	echo decbin($ip3);
}



//echo ".";
//printf("%b",$ip1);

echo "<br>";

echo $ip2;
echo "<br>";
echo $ip3;
echo "<br>";
echo $mask;
?>
</BODY>
</HTML>