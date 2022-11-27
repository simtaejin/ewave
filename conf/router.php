<?php

$content_header = "content_header.php";
$content_main = "index.php";

if (basename($_SERVER["PHP_SELF"]) == "index.php") {
    $content_header = "content_header.php";
    $content_main = "index.php";
} else if (basename($_SERVER["PHP_SELF"]) == "data_member.php") {

    $content_header = "content_header.php";
    $content_main = "data_member.php";
}
