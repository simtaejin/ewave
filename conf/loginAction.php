<?php
session_start();
include_once "../connect.php";

$username = $_POST['user_id'];
$password = $_POST['user_pw'];

$sql = "SELECT CONCAT('*', UPPER(SHA1(UNHEX(SHA1('{$password}'))))) as pass";
$result = mysqli_query($conn, $sql);
$row_p = mysqli_fetch_array($result);
$password = $row_p['pass'];

$query = mysqli_query($conn , "SELECT * FROM member WHERE id='$username' AND password='$password'");

if (mysqli_num_rows($query) == 1) {
    $row = mysqli_fetch_array($query);
    $_SESSION['user_idx'] = $row['idx'];
    $_SESSION['user_id'] = $row['id'];
    $_SESSION['user_name'] = $row['name'];

    header("Location:../AdminLTE/");

} else if ($username == '' || $password == '') {
//    header("Location:../index.php?error=2");
} else {
//    header("Location:../index.php?error=1");
}