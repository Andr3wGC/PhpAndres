<HTML>
<HEAD><TITLE> EJ2-Direccion Red – Broadcast y Rango</TITLE></HEAD>
<BODY>
<?php
$ip="192.168.16.100/16";
$ipog=$ip;
$punto=".";
$slash="/";
$ip1= substr($ip,(strpos($ip,$punto)+1) );
$ip2= substr($ip1,(strpos($ip1,$punto,1)+1));
$ip3= substr($ip2,(strpos($ip2,$punto,1)+1));
$ipb= $ip;
$ipb1= $ip1;
$ipb2=$ip2;
$ipb3=$ip3;
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

echo "El numero de Direccion de red de $ipog es ";
if($Nred2>=1){
	$ip = decbin($ip);
	//echo $ip;
}else{
	$ip =decbin($ip);
	$ip=substr($ip,(0),+$Nred1);
	echo "<br>";
	echo $ip;
	echo "<br>";
	$cero=0;
	for($x=1;$x<=8-$Nred1;$x++){
	$ip= "$ip$cero";
	}
}
//echo ".";
if($Nred2>=2){
	$ip1 = decbin($ip1);
	//echo $ip1;
}elseif($Nred2==1){
	$ip1 =decbin($ip1);
	$ip1=substr($ip1,(0),+$Nred1);
	$cero="0";
	for($x=1;$x<=8-$Nred1;$x++){
	$ip1="$ip1$cero";
	}
	//echo $ip1;
}elseif($Nred2<1){
	$ip1="00000000";
	//echo $ip1;
}

//echo ".";
if($Nred2>=3){
	$ip2 = decbin($ip2);
	//echo $ip2;
}elseif($Nred2==2){
	$ip2 =decbin($ip2);
	$ip2=substr($ip2,(0),+$Nred1);
	$cero="0";
	for($x=1;$x<=8-$Nred1;$x++){
	$ip2="$ip2$cero";
	}
	//echo $ip2;
}elseif($Nred2<2){
	$ip2="00000000";
	//echo $ip2;
}

//echo ".";
if($Nred2>=4){
	$ip3 = decbin($ip3);
	//echo $ip3;
}elseif($Nred2==3){
	$ip3 =decbin($ip3);
	$ip3=substr($ip3,(0),+$Nred1);
	$cero="0";
	for($x=1;$x<=8-$Nred1;$x++){
	$ip3="$ip3$cero";
	}
	//echo $ip3;
}elseif($Nred2<3){
	$ip3="00000000";
	//echo $ip3;
}

echo bindec("$ip");
echo ".";
echo bindec("$ip1");
echo ".";
echo bindec("$ip2");
echo ".";
echo bindec("$ip3");

//--------------------------------------------------------------------------------------------------------------------------------
echo "<br>";

echo "El numero de Direccion de Broadcast de $ipog es ";
if($Nred2>=1){
	$ipb = decbin($ipb);
	//echo $ip;
}else{
	$ipb =decbin($ipb);
	$ipb=substr($ipb,(0),+$Nred1);
	echo "<br>";
	echo $ipb;
	echo "<br>";
	$uno=1;
	for($x=1;$x<=8-$Nred1;$x++){
	$ipb= "$ipb$uno";
	}
}
//echo ".";
if($Nred2>=2){
	$ipb1 = decbin($ipb1);
	//echo $ip1;
}elseif($Nred2==1){
	$ipb1 =decbin($ipb1);
	$ipb1=substr($ipb1,(0),+$Nred1);
	$uno="1";
	for($x=1;$x<=8-$Nred1;$x++){
	$ipb1="$ipb1$uno";
	}
	//echo $ip1;
}elseif($Nred2<1){
	$ipb1="11111111";
	//echo $ip1;
}

//echo ".";
if($Nred2>=3){
	$ipb2 = decbin($ipb2);
	//echo $ip2;
}elseif($Nred2==2){
	$ipb2 =decbin($ipb2);
	$ipb2=substr($ipb2,(0),+$Nred1);
	$uno="1";
	for($x=1;$x<=8-$Nred1;$x++){
	$ipb2="$ipb2$uno";
	}
	//echo $ip2;
}elseif($Nred2<2){
	$ipb2="11111111";
	//echo $ip2;
}

//echo ".";
if($Nred2>=4){
	$ipb3 = decbin($ipb3);
	//echo $ip3;
}elseif($Nred2==3){
	$ipb3 =decbin($ipb3);
	$ipb3=substr($ipb3,(0),+$Nred1);
	$uno="1";
	for($x=1;$x<=8-$Nred1;$x++){
	$ipb3="$ipb3$uno";
	}
	//echo $ip3;
}elseif($Nred2<3){
	$ipb3="11111111";
	//echo $ip3;
}

echo bindec("$ipb");
echo ".";
echo bindec("$ipb1");
echo ".";
echo bindec("$ipb2");
echo ".";
echo bindec("$ipb3");
echo "<br>";
echo "<br>";
echo "El rango de $ipog es "; 
echo bindec("$ip");
echo ".";
echo bindec("$ip1");
echo ".";
echo bindec("$ip2");
echo ".";
echo bindec("$ip3"+1);
echo " a ";
echo bindec("$ipb");
echo ".";
echo bindec("$ipb1");
echo ".";
echo bindec("$ipb2");
echo ".";
echo bindec("$ipb3"-1);







//echo "<br>";

//echo $ip2;
//echo "<br>";
//echo $ip3;
//echo "<br>";
//echo $mask;
?>
</BODY>
</HTML>
