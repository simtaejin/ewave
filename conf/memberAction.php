<?php
//print_r($_REQUEST);
include_once "../connect.php";

$response = array();

foreach ($_REQUEST as $k => $v) {
    $$k = $v;
}

$sql = "SELECT CONCAT('*', UPPER(SHA1(UNHEX(SHA1('{$password}'))))) as pass";
$result = mysqli_query($conn, $sql);
$row_p = mysqli_fetch_array($result);
$password = $row_p['pass'];

$query = "INSERT INTO `member` SET id='{$id}', name='{$name}', password='{$password}', create_at=now() ";
$result = mysqli_query($conn, $query);

if ($result) {
    $response['pay_load']['success'] = "success";
    $response['pay_load']['result'] = $result;
}

echo json_encode($response);

