<?php
include_once "./connect.php";

foreach ($_REQUEST as $k => $v) {
    $$k = $v;
}

$date = date("Y-m-d");
$time = date("H:i:s");
$create_at = date("Y-m-d H:i:s");

if ($type=='typeA') {

    $sql = "INSERT INTO nodeA (`gid`, `a_nid`, `date`, `time`, `date_1`, `date_2`, `date_3`, `date_4`, `date_5`, `date_6`, `date_7`, `date_8`, `create_at`)
    VALUES ($gid, $nid, '$date', '$time',$date_1,$date_2,$date_3,$date_4,$date_5,$date_6,$date_7,$date_8, '{$create_at}')";
    $result = mysqli_query($conn, $sql);
} else if ($type=='typeB') {

    $sql = "INSERT INTO nodeB (`gid`, `b_nid`, `date`, `time`, `date_1`, `date_2`, `date_3`, `date_4`, `date_5`, `date_6`, `control_7`, `control_8`, `create_at`)
    VALUES ($gid, $nid, '$date', '$time',$date_1,$date_2,$date_3,$date_4,$date_5,$date_6,$control_7,$control_8, '{$create_at}')";

echo $sql;exit;
    $result = mysqli_query($conn, $sql);
}
