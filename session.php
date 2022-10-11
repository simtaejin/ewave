<?php
session_start();

if (!isset($_SESSION['user_idx'])) {
    echo "<script>alert('로그인 후 이용가능합니다.');</script>";
    echo "<meta http-equiv='refresh' content='0;url=/'>";
    exit;
}
?>