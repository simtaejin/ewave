<?php
//print_r($_REQUEST);
include_once "../connect.php";

$response = array();

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

if ($mode == "select_1") {

    $query = "select * from `geteway` where `gid`='{$select_value}' ";
    $result = mysqli_query($conn, $query);
    while($row = mysqli_fetch_array($result)) {
        $arr['nid'][] = $row['nid'];
        $arr['nid_type'][] = $row['nid_type'];
    }

    if ($arr) {
        $response['pay_load']['success'] = "success";
        $response['pay_load']['result'] = $arr;
    }
    echo json_encode($response);

} else if ($mode == "select_2") {

    $_dateTime = explode(' - ', $sdateAtedate);
    $sdate = $_dateTime[0];
    $edate = $_dateTime[1];

    if ($bun == '1m') {
        $bum = 1;
    } else if ($bun == '5m') {
        $bum = 5;
    } else if ($bun == '10m') {
        $bum = 10;
    } else if ($bun == '1h') {
        $bum = 60;
    } else if ($bun == '6h') {
        $bum = 360;
    } else if ($bun == '1day') {
        $bum = 1440;
    }

    $query = "select * from `geteway` where `gid`='{$select_value1}' and `nid`='{$select_value2}' ";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result);

    if ($row['nid_type'] == "a") {
        $arr = array_keys($label_a_array);
        $table = "nodeA";

        /* char data */
        $chart_data = createChartA($select_value1, $select_value2, $table, 'all', $bum, $sdate, $edate);

    } else if ($row['nid_type'] == "b") {
        $arr = array_keys($label_b_array);
        $table = "nodeB";

        /* char data */
        $chart_data = createChartB($select_value1, $select_value2, $table, 'all', $bum, $sdate, $edate);
    }


    if ($arr) {
        $response['pay_load']['success'] = "success";
        $response['pay_load']['result'] = $arr;
        $response['pay_load']['chart_labels'] = $chart_data['chart_labels'];
        $response['pay_load']['datasets'] = $chart_data['dataset'];
    }
    echo json_encode($response);

}



function createChartA( $select_value1, $select_value2, $table, $field='all', $bun=5, $sdate, $edate) {
    global $label_a_array, $conn;

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

    if (is_array($rows) ) {
        foreach ($rows as $k => $v) {
            $_labels[] = $v['tDate'];
            if ($v['d1sum']) $_d1datas[] = $v['d1sum'];
            if ($v['d2sum']) $_d2datas[] = $v['d2sum'];
            if ($v['d3sum']) $_d3datas[] = $v['d3sum'];
            if ($v['d4sum']) $_d4datas[] = $v['d4sum'];
            if ($v['d5sum']) $_d5datas[] = $v['d5sum'];
            if ($v['d6sum']) $_d6datas[] = $v['d6sum'];
            if ($v['d7sum']) $_d7datas[] = $v['d7sum'];
            if ($v['d8sum']) $_d8datas[] = $v['d8sum'];
        }

        $rgb = array(
            '',
            'rgb(255, 0, 0)',
            'rgb(255, 94, 0)',
            'rgb(255, 228, 0)',
            'rgb(0, 255, 0)',
            'rgb(0, 0, 255)',
            'rgb(5, 0, 153)',
            'rgb(217, 65, 197)',
            'rgb(117, 0, 197)',
        );

        $arrs = array();

        for ($i=1; $i<9; $i++) {
            if (is_array(${'_d'.$i.'datas'})) {
                array_push($arrs, array(
                    'label' => $label_a_array['data_'.$i],
                    'backgroundColor' => 'rgba(0, 0, 0, 0)',
                    'borderColor' => $rgb[$i],
                    'data' => ${'_d'.$i.'datas'},
                    'tension'=> '0.1'
                ));
            }
        }

        $chart_labels = $_labels;
    }

    $return = array();
    $return['dataset'] = $arrs;
    $return['chart_labels'] = $chart_labels;


    return $return;
}

function createChartB( $select_value1, $select_value2, $table, $field='all', $bun=5, $sdate, $edate) {
    global $label_b_array, $conn;

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

    if (is_array($rows) ) {
        foreach ($rows as $k => $v) {
            $_labels[] = $v['tDate'];
            if ($v['d1sum']) $_d1datas[] = $v['d1sum'];
            if ($v['d2sum']) $_d2datas[] = $v['d2sum'];
            if ($v['d3sum']) $_d3datas[] = $v['d3sum'];
            if ($v['d4sum']) $_d4datas[] = $v['d4sum'];
            if ($v['d5sum']) $_d5datas[] = $v['d5sum'];
            if ($v['d6sum']) $_d6datas[] = $v['d6sum'];
            if ($v['c7sum']) $_c7datas[] = $v['c7sum'];
            if ($v['c8sum']) $_c8datas[] = $v['c8sum'];
        }

        $rgb = array(
            '',
            'rgb(255, 0, 0)',
            'rgb(255, 94, 0)',
            'rgb(255, 228, 0)',
            'rgb(0, 255, 0)',
            'rgb(0, 0, 255)',
            'rgb(5, 0, 153)',
            'rgb(217, 65, 197)',
            'rgb(117, 0, 197)',
        );

        $arrs = array();

        for ($i=1; $i<9; $i++) {
            if ($i < 7) {
                if (is_array(${'_d'.$i.'datas'})) {
                    array_push($arrs, array(
                        'label' => $label_b_array['data_'.$i],
                        'backgroundColor' => 'rgba(0, 0, 0, 0)',
                        'borderColor' => $rgb[$i],
                        'data' => ${'_d'.$i.'datas'},
                        'tension'=> '0.1'
                    ));
                }
            } else {
                if (is_array(${'_c'.$i.'datas'})) {
                    array_push($arrs, array(
                        'label' => $label_b_array['control_'.$i],
                        'backgroundColor' => $rgb[$i],
                        'borderColor' => $rgb[$i],
                        'data' => ${'_c'.$i.'datas'},
                        'tension'=> '0.1'
                    ));
                }
            }

        }

        $chart_labels = $_labels;
    }

    $return = array();
    $return['dataset'] = $arrs;
    $return['chart_labels'] = $chart_labels;


    return $return;
}