<HTML>
<HEAD><TITLE> EJ2B – Conversor Decimal a base n </TITLE></HEAD>
<BODY>
<?php
$num="1515";
 $base="16";
 $dividido=$num;
$numrestos="";
$p=0;
	 $numrestos=$dividido%$base;
	 if($numrestos==10){
	 $numrestos="A";
	 }elseif($numrestos==11){
		 $numrestos="B";
	 }elseif($numrestos==12){
		 $numrestos="C";
	 }elseif($numrestos==13){
		 
		 $numrestos="D";
	 }elseif($numrestos==14){
		 $numrestos="E";
	 }elseif($numrestos==15){
		 $numrestos="F";
	 }
	 
	 if($num>=16){
do{
	
	$dividido=$dividido/$base;
	 $p=$dividido%$base;
	 if($p==10){
	 $p="A";
	 }elseif($p==11){
		 $p="B";
	 }elseif($p==12){
		 $p="C";
	 }elseif($p==13){
		 $p="D";
	 }elseif($p==14){
		 $p="E";
	 }elseif($p==15){
		 $p="F";
	 }
	 $numrestos="$p $numrestos";
	 }while($dividido>=$base);
	 
}
	  
	  

echo $numrestos;
?>
</BODY>
</HTML>
