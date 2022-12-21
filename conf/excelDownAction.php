<?php
include_once "../connect.php";


header( "Content-type: application/vnd.ms-excel; charset=utf-8");
header( "Content-Disposition: attachment; filename = excel_test.xls" );     //filename = 저장되는 파일명을 설정합니다.
header( "Content-Description: PHP4 Generated Data" );

$label_a_array = array(
    'data_1' => '온도도',
    'data_2' => '조도센서',
    'data_3' => 'co2',
    'data_4' => 'pm센서',
    'data_5' => '토양센서',
    'data_6' => 'PH',
    'data_7' => 'EC',
    'data_8' => '외부계측',
);
$label_b_array = array(
    'data_1' => '온도도',
    'data_2' => '수온센서',
    'data_3' => '계량기',
    'data_4' => '계량기',
    'data_5' => '외부계측',
    'data_6' => '외부계측',
    'control_7' => '릴레이',
    'control_8' => '릴레이',
);

foreach ($_REQUEST as $k => $v) {
    $$k = $v;
}

$_dateTime = explode(' - ', $sdateAtedate);
$sdate = $_dateTime[0];
$edate = $_dateTime[1];

if ($bun == '1m') {
    $bum = 60;
} else if ($bun == '5m') {
    $bum = 300;
} else if ($bun == '10m') {
    $bum = 600;
} else if ($bun == '1h') {
    $bum = 3600;
} else if ($bun == '6h') {
    $bum = 21600;
} else if ($bun == '1day') {
    $bum = 86400;
}

$query = "select * from `geteway` where `gid`='{$geteway}' and `nid`='{$node}' ";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_array($result);

if ($row['nid_type'] == "a") {;
    $table = "nodeA";

    $_data = createDateA($geteway, $node, $table, 'all', $bum, $sdate, $edate);

} else if ($row['nid_type'] == "b") {
    $table = "nodeB";

    $chart_data = createDateB($select_value1, $select_value2, $table, 'all', $bum, $sdate, $edate);
}

function createDateA( $select_value1, $select_value2, $table, $field='all', $bun, $sdate, $edate) {
    global $conn;

    if (!$bun) $bun=3600;
    if (!$sdate) $sdate=date("Y-m-d 00:00:00");
    if (!$edate) $edate=date("Y-m-d 23:59:59");


    if ($field == 'all') {
        $field = " TRUNCATE(avg(date_1),2) d1sum,
         TRUNCATE(avg(date_2),2) d2sum,
         TRUNCATE(avg(date_3),2) d3sum,
         TRUNCATE(avg(date_4),2) d4sum,
         TRUNCATE(avg(date_5),2) d5sum,
         TRUNCATE(avg(date_6),2) d6sum,
         TRUNCATE(avg(date_7),2) d7sum,
         TRUNCATE(avg(date_8),2) d8sum,";
    } else {
        $_t = explode('_', $field);
        $sum = "d".$_t[1].'sum';
        $field = " TRUNCATE(avg({$field}),2) {$sum} ";
    }

    $sql = "SELECT FROM_UNIXTIME(CAST(FLOOR(UNIX_TIMESTAMP(concat(`date`,' ',`time`))/{$bun}) AS SIGNED)*{$bun}) AS tDate,
               {$field}
               `date`
            FROM {$table} where gid='{$select_value1}' and a_nid='{$select_value2}' and concat(`date`,' ',`time`) between '{$sdate}' and '{$edate}'
            group by tDate";

    $result = mysqli_query($conn, $sql);

    while($row = mysqli_fetch_array($result)) {
        if ($row) $rows[] = $row;
    }

    return $rows;
}

function createDateB( $select_value1, $select_value2, $table, $field='all', $bun, $sdate, $edate) {
    global $label_b_array, $conn;

    if (!$bun) $bun=3600;
    if (!$sdate) $sdate=date("Y-m-d 00:00:00");
    if (!$edate) $edate=date("Y-m-d 23:59:59");

    if ($field == 'all') {
        $field = " TRUNCATE(avg(date_1),2) d1sum,
         TRUNCATE(avg(date_2),2) d2sum,
         TRUNCATE(avg(date_3),2) d3sum,
         TRUNCATE(avg(date_4),2) d4sum,
         TRUNCATE(avg(date_5),2) d5sum,
         TRUNCATE(avg(date_6),2) d6sum,
         TRUNCATE(avg(control_7),2) c7sum,
         TRUNCATE(avg(control_8),2) c8sum,";
    } else {
        $_t = explode('_', $field);
        $sum = "d".$_t[1].'sum';
        $field = " TRUNCATE(avg({$field}),2) {$sum} ";
    }

    $sql = "SELECT FROM_UNIXTIME(CAST(FLOOR(UNIX_TIMESTAMP(concat(`date`,' ',`time`))/{$bun}) AS SIGNED)*{$bun}) AS tDate,
               {$field}
               `date`
            FROM {$table} where gid='{$select_value1}' and b_nid='{$select_value2}' and concat(`date`,' ',`time`) between '{$sdate}' and '{$edate}'
            group by tDate";

    $result = mysqli_query($conn, $sql);

    while($row = mysqli_fetch_array($result)) {
        if ($row) $rows[] = $row;
    }

    return $rows;
}

?>



<?php
if ($row['nid_type'] == "a") {;
?>
    <table style="border: 1px solid black">
        <tr>
            <td>날짜</td>
            <?php if ($_data[0]['d1sum']) { ?><td><?php echo $label_a_array['data_1'];?></td><?php } ?>
            <?php if ($_data[0]['d2sum']) { ?><td><?php echo $label_a_array['data_2'];?></td><?php } ?>
            <?php if ($_data[0]['d3sum']) { ?><td><?php echo $label_a_array['data_3'];?></td><?php } ?>
            <?php if ($_data[0]['d4sum']) { ?><td><?php echo $label_a_array['data_4'];?></td><?php } ?>
            <?php if ($_data[0]['d5sum']) { ?><td><?php echo $label_a_array['data_5'];?></td><?php } ?>
            <?php if ($_data[0]['d6sum']) { ?><td><?php echo $label_a_array['data_6'];?></td><?php } ?>
            <?php if ($_data[0]['d7sum']) { ?><td><?php echo $label_a_array['data_7'];?></td><?php } ?>
            <?php if ($_data[0]['d8sum']) { ?><td><?php echo $label_a_array['data_8'];?></td><?php } ?>
        </tr>
        <?php foreach ($_data as $k => $v) { ?>
            <tr>
                <td><?php echo $v['tDate']; ?></td>
                <?php if ($_data[0]['d1sum']) { ?><td><?php echo $v['d1sum'];?></td><?php } ?>
                <?php if ($_data[0]['d2sum']) { ?><td><?php echo $v['d2sum'];?></td><?php } ?>
                <?php if ($_data[0]['d3sum']) { ?><td><?php echo $v['d3sum'];?></td><?php } ?>
                <?php if ($_data[0]['d4sum']) { ?><td><?php echo $v['d4sum'];?></td><?php } ?>
                <?php if ($_data[0]['d5sum']) { ?><td><?php echo $v['d5sum'];?></td><?php } ?>
                <?php if ($_data[0]['d6sum']) { ?><td><?php echo $v['d6sum'];?></td><?php } ?>
                <?php if ($_data[0]['d7sum']) { ?><td><?php echo $v['d7sum'];?></td><?php } ?>
                <?php if ($_data[0]['d8sum']) { ?><td><?php echo $v['d8sum'];?></td><?php } ?>
            </tr>
        <?php } ?>
    </table>
<?php } else if ($row['nid_type'] == "b") { ?>
    <table style="border: 1px solid black">
        <tr>
            <td>날짜</td>
            <?php if ($_data[0]['d1sum']) { ?><td><?php echo $label_b_array['data_1'];?></td><?php } ?>
            <?php if ($_data[0]['d2sum']) { ?><td><?php echo $label_b_array['data_2'];?></td><?php } ?>
            <?php if ($_data[0]['d3sum']) { ?><td><?php echo $label_b_array['data_3'];?></td><?php } ?>
            <?php if ($_data[0]['d4sum']) { ?><td><?php echo $label_b_array['data_4'];?></td><?php } ?>
            <?php if ($_data[0]['d5sum']) { ?><td><?php echo $label_b_array['data_5'];?></td><?php } ?>
            <?php if ($_data[0]['d6sum']) { ?><td><?php echo $label_b_array['data_6'];?></td><?php } ?>
            <?php if ($_data[0]['c7sum']) { ?><td><?php echo $label_b_array['control_7'];?></td><?php } ?>
            <?php if ($_data[0]['c8sum']) { ?><td><?php echo $label_b_array['control_8'];?></td><?php } ?>
        </tr>
        <?php foreach ($_data as $k => $v) { ?>
            <tr>
                <td><?php echo $v['tDate']; ?></td>
                <?php if ($_data[0]['d1sum']) { ?><td><?php echo $v['d1sum'];?></td><?php } ?>
                <?php if ($_data[0]['d2sum']) { ?><td><?php echo $v['d2sum'];?></td><?php } ?>
                <?php if ($_data[0]['d3sum']) { ?><td><?php echo $v['d3sum'];?></td><?php } ?>
                <?php if ($_data[0]['d4sum']) { ?><td><?php echo $v['d4sum'];?></td><?php } ?>
                <?php if ($_data[0]['d5sum']) { ?><td><?php echo $v['d5sum'];?></td><?php } ?>
                <?php if ($_data[0]['d6sum']) { ?><td><?php echo $v['d6sum'];?></td><?php } ?>
                <?php if ($_data[0]['c7sum']) { ?><td><?php echo $v['c7sum'];?></td><?php } ?>
                <?php if ($_data[0]['c8sum']) { ?><td><?php echo $v['c8sum'];?></td><?php } ?>
            </tr>
        <?php } ?>
    </table>
<?php } ?>


