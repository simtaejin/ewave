<?php
include_once "connect.php";
include_once "session.php";

if (!empty($_REQUEST['mb']) &&
    !empty($_REQUEST['sdate']) &&
    !empty($_REQUEST['edate']) &&
    !empty($_REQUEST['d'])
    ) {

    foreach ($_REQUEST as $k => $v) {
        $$k = $v;
    }

    $bun = $d * 60;

    if ($t == "T1") {
        $field = " TRUNCATE(avg(T1),2) t1sum, ";
    } else if ($t == "T2") {
        $field = " TRUNCATE(avg(T2),2) t2sum, ";
    } else if ($t == "T3") {
        $field = " TRUNCATE(avg(T3),2) t3sum, ";
    } else if ($t == "T4") {
        $field = " TRUNCATE(avg(T4),2) t4sum, ";
    } else if ($t == "T5") {
        $field = " TRUNCATE(avg(T5),2) t5sum, ";
    } else if ($t == "T6") {
        $field = " TRUNCATE(avg(T6),2) t6sum, ";
    } else if ($t == "T7") {
        $field = " TRUNCATE(avg(T7),2) t7sum, ";
    } else {
        $field = " TRUNCATE(avg(T1),2) t1sum, TRUNCATE(avg(T2),2) t2sum, TRUNCATE(avg(T3),2) t3sum, TRUNCATE(avg(T4),2) t4sum, TRUNCATE(avg(T5),2) t5sum, TRUNCATE(avg(T6),2) t6sum, TRUNCATE(avg(T7),2) t7sum, ";
    }

    $sql = "SELECT FROM_UNIXTIME(CAST(FLOOR(UNIX_TIMESTAMP(concat(BOARD_DATE,' ',BOARD_TIME))/{$bun}) AS SIGNED)*{$bun}) AS tDate,
               {$field}
               BOARD_DATE
            FROM wfarm where MB='{$mb}' and concat(BOARD_DATE,' ',BOARD_TIME) between '{$sdate}' and '{$edate}'
            group by tDate";

    $result = mysqli_query($conn, $sql);

    while($row[] = mysqli_fetch_array($result));

    foreach ($row as $k => $v) {
        if ($k > 0){
            $_labels[] = $v['tDate'];
            if ($v['t1sum']) $_t1datas[] = $v['t1sum'];
            if ($v['t2sum']) $_t2datas[] = $v['t2sum'];
            if ($v['t3sum']) $_t3datas[] = $v['t3sum'];
            if ($v['t4sum']) $_t4datas[] = $v['t4sum'];
            if ($v['t5sum']) $_t5datas[] = $v['t5sum'];
            if ($v['t6sum']) $_t6datas[] = $v['t6sum'];
            if ($v['t7sum']) $_t7datas[] = $v['t7sum'];
        }
    }

    $rgb = array(
        'rgb(255, 0, 0)',
        'rgb(255, 94, 0)',
        'rgb(255, 228, 0)',
        'rgb(0, 255, 0)',
        'rgb(0, 0, 255)',
        'rgb(5, 0, 153)',
        'rgb(217, 65, 197)',
    );

    $arr = array();
    $label_array = array(
            'T1' => '온도',
            'T2' => '습도',
            'T3' => '조도',
            'T4' => 'co2',
            'T5' => 'PH',
            'T6' => 'EC',
            'T7' => 'PM',
    );

    for ($i=1; $i<8; $i++) {
//        echo $i;
//        echo "<xmp>";
//        print_r(${'_t'.$i.'datas'});
//        echo "</xmp>";

        if (is_array(${'_t'.$i.'datas'})) {
            array_push($arr, array(
                'label' => $label_array['T'.$i],
                'backgroundColor' => $rgb[$i],
                'borderColor' => $rgb[$i],
                'data' => ${'_t'.$i.'datas'},
                'tension'=> '0.1'
            ));
        }
    }


    $chart_labels = json_encode($_labels);

//    $arry = array( 'label'=> 'My First dataset',
//      'backgroundColor'=> 'rgb(255, 99, 132)',
//      'borderColor'=> 'rgb(255, 99, 132)',
//      'data'=> array(10,20,30,20,30,20,13,14,11,12,9));

    //  {"label":"My First dataset","backgroundColor":"rgb(255, 99, 132)","borderColor":"rgb(255, 99, 132)","data":"0"}

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chart</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.js" integrity="sha512-s5u/JBtkPg+Ff2WEr49/cJsod95UgLHbC00N/GglqdQuLnYhALncz8ZHiW/LxDRGduijLKzeYb7Aal9h3codZA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.css" integrity="sha512-LT9fy1J8pE4Cy6ijbg96UkExgOjCqcxAC7xsnv+mLJxSvftGVmmc236jlPTZXPcBRQcVOWoK1IJhb1dAjtb4lQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/i18n/jquery-ui-timepicker-addon-i18n.min.js" integrity="sha512-t2ZIJH81Sh+SWSb4BuA9en4j6fwja+sYOEXbqoepD9lJ+efUGD94gSWqdmgQchGmPez2ojECq4Fm6bKMUAzIiQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        $(document).ready(function(){
            var startDateTextBox = $('#datepicker_from');
            var endDateTextBox = $('#datepicker_to');

            $.timepicker.datetimeRange(
                startDateTextBox,
                endDateTextBox,
                {
                    minInterval: (1000*60*60), // 1hr
                    dateFormat: 'yy-mm-dd',
                    timeFormat: 'HH:mm',
                    start: {}, // start picker options
                    end: {} // end picker options
                }
            );
        });
    </script>

    <style>

    </style>
</head>
<body>

<form action="./view.time.php" method="post">
    mb : <input type="text" style="width:180px;" id="mb" name="mb" value="<?php echo $mb;?>" >
    t :
    <select name="t">
        <option value="">전체</option>
        <option value="T1" <? if ($t=="T1") echo "selected" ?> ><?php echo $label_array['T1']?></option>
        <option value="T2" <? if ($t=="T2") echo "selected" ?> ><?php echo $label_array['T2']?></option>
        <option value="T3" <? if ($t=="T3") echo "selected" ?> ><?php echo $label_array['T3']?></option>
        <option value="T4" <? if ($t=="T4") echo "selected" ?> ><?php echo $label_array['T4']?></option>
        <option value="T5" <? if ($t=="T5") echo "selected" ?> ><?php echo $label_array['T5']?></option>
        <option value="T6" <? if ($t=="T6") echo "selected" ?> ><?php echo $label_array['T6']?></option>
        <option value="T7" <? if ($t=="T7") echo "selected" ?> ><?php echo $label_array['T7']?></option>
    </select>
    시작일: <input type="text" id="datepicker_from" style="width:180px;" name="sdate" value="<?php echo $sdate;?>">
    종료일: <input type="text" id="datepicker_to" style="width:180px;" name="edate" value="<?php echo $edate;?>">
    시간 간격 :
    <select name="d">
        <?php for ($i=1; $i<61; $i++) { ?>
            <option value="<?php echo $i; ?>" <? if ($i==$d) echo "selected" ?> ><?php echo $i;?></option>
        <?php } ?>
    </select>
    분
    <button type="submit" style="width:100px; height: 100px;">검색</button>
</form>

<div style="width: 80%">
    <canvas id="myChart"  ></canvas>
</div>

<table border="0" style="width:100%;">
    <tr>
        <td style="width: 300px;">board_date</td>
        <td>MB</td>
        <?php if (is_array($_t1datas)) {?>  <td><?php echo $label_array['T1']?></td>  <?php } ?>
        <?php if (is_array($_t2datas)) {?>  <td><?php echo $label_array['T2']?></td>  <?php } ?>
        <?php if (is_array($_t3datas)) {?>  <td><?php echo $label_array['T3']?></td>  <?php } ?>
        <?php if (is_array($_t4datas)) {?>  <td><?php echo $label_array['T4']?></td>  <?php } ?>
        <?php if (is_array($_t5datas)) {?>  <td><?php echo $label_array['T5']?></td>  <?php } ?>
        <?php if (is_array($_t6datas)) {?>  <td><?php echo $label_array['T6']?></td>  <?php } ?>
        <?php if (is_array($_t7datas)) {?>  <td><?php echo $label_array['T7']?></td>  <?php } ?>
    </tr>
    <?php
    if (is_array($_labels)) {
        foreach ($_labels as $k => $v) {
    ?>
    <tr>
        <td><?php echo $v ?></td>
        <td><?php echo $mb ?></td>
        <?php if (is_array($_t1datas)) {?>  <td><?php echo $_t1datas[$k] ?></td>  <?php } ?>
        <?php if (is_array($_t2datas)) {?>  <td><?php echo $_t2datas[$k] ?></td>  <?php } ?>
        <?php if (is_array($_t3datas)) {?>  <td><?php echo $_t3datas[$k] ?></td>  <?php } ?>
        <?php if (is_array($_t4datas)) {?>  <td><?php echo $_t4datas[$k] ?></td>  <?php } ?>
        <?php if (is_array($_t5datas)) {?>  <td><?php echo $_t5datas[$k] ?></td>  <?php } ?>
        <?php if (is_array($_t6datas)) {?>  <td><?php echo $_t6datas[$k] ?></td>  <?php } ?>
        <?php if (is_array($_t7datas)) {?>  <td><?php echo $_t7datas[$k] ?></td>  <?php } ?>
    </tr>
    <?
        }
    }
    ?>
</table>

<script>
    const labels = <?php echo $chart_labels;?>;

    const data = {
        labels: labels,
        datasets: <?php echo json_encode($arr);?>
    };

    const config = {
        type: 'line',
        data: data,
        options: {}
    };

    const myChart = new Chart(
        document.getElementById('myChart'),
        config
    );
</script>
</body>
</html>

