<HTML>
<HEAD><TITLE> EJ1-Conversion IP Decimal a Binario </TITLE></HEAD>
<BODY>
<?php 
$ip="192.18.16.204";

$punto=".";
$ip1= substr($ip,(strpos($ip,$punto)+1) );
$ip2= substr($ip1,(strpos($ip1,$punto,1)+1));
$ip3= substr($ip2,(strpos($ip2,$punto,1)+1));


echo("Numero $ip se representa en binario como ");
echo decbin($ip);
echo ".";
echo decbin($ip1);
echo ".";
echo decbin($ip2);
echo ".";
echo decbin($ip3);
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";

echo $ip;
echo "<br>";
echo $ip1;
echo "<br>";
echo $ip2;
echo "<br>";
echo $ip3;
echo "<br>";
echo decbin($ip);
//echo (decbin(int ($ip3)));

//echo decbin(int $ip3) . "\n";






?>
</BODY>
</HTML>


