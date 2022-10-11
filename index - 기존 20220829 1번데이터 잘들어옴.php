<?php
//S=2023-02-0999-0999-0999-0999-999-1-9999-9999-4-0^E

$ip = $_SERVER['REMOTE_ADDR'];
$time = date("Y-m-d h:m:s",$_SERVER['REQUEST_TIME']);

$a = explode('-', $_GET['S']);
//echo $_GET['S'];
//echo $a; "<br>";
echo $ip; "<br>";
echo $time; "<br>";

//exit;
//print_r($array);
//echo $str;

// Array ( [0] => 2023 [1] => 02 [2] => 0999 [3] => 0999 [4] => 0999 [5] => 0999 [6] => 999 [7] => 1 [8] => 9999 [9] => 9999 [10] => 4 [11] => 0^E )
//$dd = $a[0];
//$sb = $a[1];
//$t1 = $a[2];





foreach ($_REQUEST as $key => $val) {


    echo $key." => ".$val."<br>";
    	
	$data = $key+$val+"<>";
	$text="$time-$ip-$data#\n";
     $file_pointer = fopen("data.txt", "a");
      fwrite($file_pointer, $text);
	  fclose($file_pointer);    
}
?>