<?php
//S=2023-02-0999-0999-0999-0999-999-1-9999-9999-4-0^E

$ip = $_SERVER['REMOTE_ADDR'];
$time1 = date("Y-m-d h:i:s",$_SERVER['REQUEST_TIME']);

$data = $_GET['S'];
//$a = explode('-', $_GET['S']);
//echo $_GET['S'];
//echo $a; "<br>";
//echo nl2br($ip); 
//echo $time; 
//echo $data;
//exit;
//print_r($array);
//echo $str;

// Array ( [0] => 2023 [1] => 02 [2] => 0999 [3] => 0999 [4] => 0999 [5] => 0999 [6] => 999 [7] => 1 [8] => 9999 [9] => 9999 [10] => 4 [11] => 0^E )
//$dd = $a[0];
//$sb = $a[1];
//$t1 = $a[2];

//$array_data = explode('-',$data);
//print_r($array_data);
//exit;



//foreach ($_REQUEST as $key => $val) {


//    echo $key." => ".$val."<br>";
    	
//	$data = $key+$val+"<>";
	$text="$time1-$ip-$data\n";
     $file_pointer = fopen("data.txt", "a");
      fwrite($file_pointer, $text);
	  fclose($file_pointer);    
//}

/*
$conn = mysqli_connect("localhost","root","autoset","dudung") or die ("Can't access DB");
$query = "insert into first (data,time) values('".$data."','".$time1."')";
$resut=mysqli_query($conn,$query);
mysqli_close($conn);
*/
$conn = mysqli_connect("localhost","root","autoset","dudung") or die ("Can't access DB");
$array_data = explode('-',$data);
$num=1;
for (i=0; i<count($array_data)-1; $i++) {
	

$conn = mysqli_connect("localhost","root","autoset","dudung") or die ("Can't access DB");




      $con_file = file_get_contents('./control.txt', true);

      $con_file = split("#",$con_file);
      $con_data=$con_file[0]+$con_file[1]+$con_file[2]+$con_file[3];

      $con_data=$con_data%2;
      if($con_data) $con_data=1;
      else if(!$con_data) $con_data=0;
      $con_text="@$con_file[0]$con_file[1]$con_file[2]$con_file[3]$con_data";  
      echo $con_text;

?>