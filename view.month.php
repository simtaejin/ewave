<?php
include_once "connect.php";
include_once "session.php";
if (!empty($_REQUEST['mb']) &&
    !empty($_REQUEST['sb']) &&
    !empty($_REQUEST['sdate']) &&
    !empty($_REQUEST['edate'])) {

    foreach ($_REQUEST as $k => $v) {
        $$k = $v;
    }


    $sql = "select board_date,
                   max(water),
                   (max(water) - ifnull(LAG(max(water)) OVER (ORDER BY board_date, ID), 0)) * 10 as water
            from boram
            where mb = '{$mb}'
              and sb = '{$sb}'
              and board_date between DATE_SUB('{$sdate}', INTERVAL 1 DAY) and '{$edate}'
            group by board_date;";


    $result = mysqli_query($conn, $sql);

    while($row[] = mysqli_fetch_array($result));

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

    <script src="./js/datepicker.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        $(document).ready(function(){

        });
    </script>

    <style>

    </style>
</head>
<body>
<!--<div id="test"></div>-->
<form action="./view.month.php" method="post">
    mb : <input type="text" style="width:180px;" id="mb" name="mb" value="<?php echo $mb;?>" >
    sb : <input type="text" style="width:180px;" id="sb" name="sb" value="<?php echo $sb;?>" >
    시작일: <input type="text" id="datepicker_from" style="width:80px;" name="sdate" value="<?php echo $sdate;?>">
    종료일: <input type="text" id="datepicker_to" style="width:80px;" name="edate" value="<?php echo $edate;?>">
    <button type="submit" style="width:100px; height: 100px;">검색</button>
</form>

<div style="width: 80%">
    <canvas id="myChart" ></canvas>
</div>

<table border="0" style="width:100%;">
    <tr>
        <td>board_date</td>
        <td>&nbsp;</td>
        <td>water</td>
    </tr>

    <?php
        foreach ($row as $k => $v) {
            if ($k > 0) {
                echo "<tr>";
                echo "<td>".$v['board_date']."</td>";
                echo "<td>&nbsp;</td>";
                echo "<td>".$v['water']."</td>";
                echo "</tr>";
                $data_1[] = $v['board_date'];
                $data_2[] = $v['water'];
            }
        }

        $chart_labels = json_encode($data_1);
        $chart_datas = json_encode($data_2);
    ?>

</table>

<script>
    const labels = <?php echo $chart_labels;?>;

    const data = {
        labels: labels,
        datasets: [{
            label: '<?php echo $sdate;?>~<?php echo $edate;?>_water',
            backgroundColor: 'rgb(99,255,242)',
            borderColor: 'rgb(99,255,242)',
            data: <?php echo $chart_datas;?>,
        }]
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