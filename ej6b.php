<HTML>
<HEAD><TITLE> EJ6B – Factorial</TITLE></HEAD>
<BODY>
<?php
$num="4";
echo "$num!= ";
$text = "";
$resul=$num;
for($i=1; $i<=$num-1; $i++){

		$resul= $resul*$i;
		echo "$i"," x ";
}
echo "$num","= $resul";

?>
</BODY>
</HTML>