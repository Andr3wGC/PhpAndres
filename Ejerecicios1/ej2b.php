<HTML>
<HEAD><TITLE> EJ2B – Conversor Decimal a base n </TITLE></HEAD>
<BODY>
<?php
$num="48";
 $base="2";
 $dividido=$num;
$numrestos="";
$p=0;
	 $numrestos=$dividido%$base;
do{
	$dividido=$dividido/$base;
	 $p=$dividido%$base;
	  $numrestos="$p $numrestos";
}while($dividido>=$base);
echo $numrestos;
?>
</BODY>
</HTML>
