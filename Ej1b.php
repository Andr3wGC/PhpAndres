<HTML>
<HEAD><TITLE> EJ1B – Conversor decimal a binario</TITLE></HEAD>
<BODY>
<?php
$num="0";
	$dividido=$num;
	$i=$num;
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

	
	
	echo $numbin;
?>
</BODY>
</HTML>