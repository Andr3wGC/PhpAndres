<HTML>
<HEAD><TITLE> EJ2-Direccion Red – Broadcast y Rango</TITLE></HEAD>
<BODY>
<?php
$ip="192.168.16.100/32";
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
	$ip = decbin($ip);
	echo $ip;
}else{
	$ip =decbin($ip);
	$ip=substr($ip,(0),+$Nred1);
	echo $ip;
	$cero=0;
	for($x=1;$x<=8-$Nred1;$x++){
	echo $cero;
	}
}
echo ".";
if($Nred2>=2){
	$ip1 = decbin($ip1);
	echo $ip1;
}elseif($Nred2==1){
	$ip1 =decbin($ip1);
	$ip1=substr($ip1,(0),+$Nred1);
	$cero="0";
	for($x=1;$x<=8-$Nred1;$x++){
	$ip1="$ip1$cero";
	}
	echo $ip1;
}elseif($Nred2<1){
	$ip1="00000000";
	echo $ip1;
}

echo ".";
if($Nred2>=3){
	$ip2 = decbin($ip2);
	echo $ip2;
}elseif($Nred2==2){
	$ip2 =decbin($ip2);
	$ip2=substr($ip2,(0),+$Nred1);
	$cero="0";
	for($x=1;$x<=8-$Nred1;$x++){
	$ip2="$ip2$cero";
	}
	echo $ip2;
}elseif($Nred2<2){
	$ip2="00000000";
	echo $ip2;
}

echo ".";
if($Nred2>=4){
	$ip3 = decbin($ip3);
	echo $ip3;
}elseif($Nred2==3){
	$ip3 =decbin($ip3);
	$ip3=substr($ip3,(0),+$Nred1);
	$cero="0";
	for($x=1;$x<=8-$Nred1;$x++){
	$ip3="$ip3$cero";
	}
	echo $ip3;
}elseif($Nred2<3){
	$ip3="00000000";
	echo $ip3;
}
echo "<br><br>";
echo bindec("$ip");
echo ".";
echo bindec("$ip1");
echo ".";
echo bindec("$ip2");
echo ".";
echo bindec("$ip3");





echo "<br>";

echo $ip2;
echo "<br>";
echo $ip3;
echo "<br>";
echo $mask;
?>
</BODY>
</HTML>
