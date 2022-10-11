<?php
  ini_set( 'display_errors', '1' );
//S=2023-02-0999-0999-0999-0999-999-1-9999-9999-4-0^E
//3000-26.5-77.4-45664-3455-12.4-480.2-554 // id-온도-습도-조도-이산화탄소-ph-ec-pm
//MB  -T1  -T2  -T3   -T4  -T5  -T6   - T7 
//a(0) a(1) a(2) a(3) a(4) a(5) a(6)   a(7)
$ip = $_SERVER['REMOTE_ADDR'];
$time1 = date("Y-m-d H:i:s",$_SERVER['REQUEST_TIME']);
$time_board = date("H:i:s", $_SERVER['REQUEST_TIME']);
$data_board = date("Y-m-d", $_SERVER['REQUEST_TIME']);
$data = $_GET['S'];

$conn = mysqli_connect("localhost","root","UNpDc91Gz1hf","dudung") or die ("Can't access DB");
$array_data = explode('-',$data);

for ($i=0 ; $i<10; $i++)
{
        $array_data[$i] = $array_data[$i];
}
$num=1;


//$query = "insert into BORAM () values('".$data."','".$time1."')"; ▒ߵ▒
$query = "insert into wfarm ( `BOARD_DATE`, `BOARD_TIME`, `BOARD_IP`, `MB`, `T1`, `T2`, `T3`, `T4`,`T5`,`T6`,`T7`) 
                   values('".$data_board."','".$time_board."','".$ip."','".$array_data[0]."','".$array_data[1]."','".$array_data[2]."','".$array_data[3]."','".$array_data[4]."','".$array_data[5]."','".$array_data[6]."','".$array_data[7]."')";
$resut=mysqli_query($conn,$query);
mysqli_close($conn);

?>

