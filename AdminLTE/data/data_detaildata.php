
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <form id="frm" name="frm" action=""  method="post">
        <div class="row">
            <div class="col-md-3">

                <!-- About Me Box -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">검색 조건</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="form-group">
                            <?php
                            $sql = "select distinct (gid) from geteway";
                            $result = mysqli_query($conn, $sql);
                            ?>
                            <label for="exampleInputEmail1">geteway</label>
                            <select class="custom-select rounded-0" id="geteway" name="geteway">
                                <option value="">선택하세요.</option>
                                <?php
                                while($row = mysqli_fetch_array($result)) {
                                    ?>
                                    <option value="<?php echo $row['gid']; ?>"><?php echo $row['gid']; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>

                        <hr>

                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">node</label>
                            <select class="custom-select rounded-0" id="node" name="node">
                                <option value="">선택하세요.</option>
                            </select>

                        </div>

                        <hr>

                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">센서</label>
                            <select class="custom-select rounded-0" id="sensor" name="sensor">
                                <option value="">선택하세요.</option>
                            </select>
                        </div>

                        <hr>

                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header p-2">
                        <div class="row">
                            <!-- Date and time range -->
                            <div class="form-group col-md-5">
                                <label>시작일시과 종료일 </label>

                                <div class="input-group">
                                    <input type="text" class="form-control float-right" id="reservationtime" name="sdateAtedate">
                                </div>
                                <!-- /.input group -->
                            </div>


                            <!-- radio -->
                            <div class="form-group col-md-7 " style="text-align: center">
                                <label>시간간격 </label>
                                <div class="input-group" style="display: inline-block;text-align: center;">
                                    <div class="icheck-primary d-inline col-sm-1">
                                        <input type="radio" id="radioPrimary1" name="bun" value="1m" checked>
                                        <label for="radioPrimary1">
                                            1m
                                        </label>
                                    </div>
                                    <div class="icheck-primary d-inline col-sm-1">
                                        <input type="radio" id="radioPrimary2" name="bun" value="5m">
                                        <label for="radioPrimary2">
                                            5m
                                        </label>
                                    </div>
                                    <div class="icheck-primary d-inline col-sm-1">
                                        <input type="radio" id="radioPrimary3" name="bun" value="10m">
                                        <label for="radioPrimary3">
                                            10m
                                        </label>
                                    </div>
                                    <div class="icheck-primary d-inline col-sm-1">
                                        <input type="radio" id="radioPrimary4" name="bun" value="60m">
                                        <label for="radioPrimary4">
                                            60m
                                        </label>
                                    </div>
                                    <div class="icheck-primary d-inline col-sm-1">
                                        <input type="radio" id="radioPrimary5" name="bun" value="1h">
                                        <label for="radioPrimary5">
                                            1h
                                        </label>
                                    </div>
                                    <div class="icheck-primary d-inline col-sm-1">
                                        <input type="radio" id="radioPrimary6" name="bun" value="6h">
                                        <label for="radioPrimary6">
                                            6h
                                        </label>
                                    </div>
                                    <div class="icheck-primary d-inline col-sm-1">
                                        <input type="radio" id="radioPrimary7" name="bun" value="1day">
                                        <label for="radioPrimary7">
                                            1day
                                        </label>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <canvas id="myChart" style="height: 900px;"></canvas>
                        <button type="button" class="btn btn-block bg-gradient-primary" id="chart_image_download">Chart Download</button>
                        <button type="button" class="btn btn-block bg-gradient-primary" id="excel_image_download">Excel Download</button>
                    </div><!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        </form>
        <!-- /.row -->

<!--        <div class="card">-->
<!--            <div class="card-header">-->
<!--                <h3 class="card-title">DataTable with default features</h3>-->
<!--            </div>-->
<!--            <div class="card-body">-->
<!--                <table id="example" class="table table-bordered table-striped"></table>-->
<!--            </div>-->
<!--        </div>-->

    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->



<!-- /.modal -->
<script src="plugins/jquery/jquery.min.js"></script>
<script>

    $(function () {
        $("#geteway").change(function () {
            if ($(this).val()) {
                $.ajax({
                    url:'../conf/dashboardAction.php',
                    type:'post',
                    data: {mode:'select_1', select_value:$(this).val()},
                    dataType: "json",
                    success:function(obj){
                        if (obj.pay_load.success == "success") {
                            if (obj.pay_load.result.nid[0]) {
                                $("#node option:gt(0)").remove();
                                obj.pay_load.result.nid.forEach(function (el, index) {
                                    $('#node').append($('<option>', {
                                        value: obj.pay_load.result.nid[index],
                                        text : el+' | node_'+obj.pay_load.result.nid_type[index]
                                    }));
                                })
                            }
                        }
                    }
                })
            }
        })

        $("#node").change(function () {

            // alert($("[name='bun']:checked").val());
            // alert($("[name='sdateAtedate']").val());

            if ($(this).val()) {
                $.ajax({
                    url:'../conf/dashboardAction.php',
                    type:'post',
                    data: {mode:'select_2', select_value1:$("#geteway").val(), select_value2:$(this).val(), sdateAtedate:$("[name='sdateAtedate']").val(), bun:$("[name='bun']:checked").val()},
                    dataType: "json",
                    success:function(obj){
                        if (obj.pay_load.success == "success") {
                            console.log(obj.pay_load.result)
                            if (obj.pay_load.result[0]) {
                                $("#sensor option:gt(0)").remove();
                                obj.pay_load.result.forEach(function (el, index) {
                                    $('#sensor').append($('<option>', {
                                        value: el,
                                        text : el
                                    }));
                                })

                                const labels = obj.pay_load.chart_labels

                                const data = {
                                    labels: labels,
                                    datasets: obj.pay_load.datasets
                                };

                                const config = {
                                    type: 'line',
                                    data: data,
                                    options: {
                                        scales:{
                                            yAxes: [{
                                                ticks: {
                                                    min: 0,
                                                    max: 600,
                                                    stepSize : 10
                                                }
                                            }]
                                        }
                                    }
                                };

                                const myChart = new Chart(
                                    document.getElementById('myChart'),
                                    config
                                );


                            }
                        }
                    }
                })
            }
        })

        $("#chart_image_download").click(function () {
            const imageLink = document.createElement('a')
            const canvas = document.getElementById('myChart')
            imageLink.download = 'chart.png'
            imageLink.href = canvas.toDataURL('image/png', 1)
            imageLink.click()
        })


        $("#excel_image_download").click(function () {
            $("#frm").attr("action", "../../conf/excelDownAction.php").submit()
        })


        var dataSet = [
            ['Tiger Nixon', 'System Architect', 'Edinburgh', '5421', '2011/04/25', '$320,800'],
            ['Garrett Winters', 'Accountant', 'Tokyo', '8422', '2011/07/25', '$170,750'],
            ['Ashton Cox', 'Junior Technical Author', 'San Francisco', '1562', '2009/01/12', '$86,000'],
            ['Cedric Kelly', 'Senior Javascript Developer', 'Edinburgh', '6224', '2012/03/29', '$433,060'],
            ['Airi Satou', 'Accountant', 'Tokyo', '5407', '2008/11/28', '$162,700'],
            ['Brielle Williamson', 'Integration Specialist', 'New York', '4804', '2012/12/02', '$372,000'],
            ['Herrod Chandler', 'Sales Assistant', 'San Francisco', '9608', '2012/08/06', '$137,500'],
            ['Rhona Davidson', 'Integration Specialist', 'Tokyo', '6200', '2010/10/14', '$327,900'],
            ['Colleen Hurst', 'Javascript Developer', 'San Francisco', '2360', '2009/09/15', '$205,500'],
            ['Sonya Frost', 'Software Engineer', 'Edinburgh', '1667', '2008/12/13', '$103,600'],
            ['Jena Gaines', 'Office Manager', 'London', '3814', '2008/12/19', '$90,560'],
            ['Quinn Flynn', 'Support Lead', 'Edinburgh', '9497', '2013/03/03', '$342,000'],
            ['Charde Marshall', 'Regional Director', 'San Francisco', '6741', '2008/10/16', '$470,600'],
            ['Haley Kennedy', 'Senior Marketing Designer', 'London', '3597', '2012/12/18', '$313,500'],
            ['Tatyana Fitzpatrick', 'Regional Director', 'London', '1965', '2010/03/17', '$385,750'],
            ['Michael Silva', 'Marketing Designer', 'London', '1581', '2012/11/27', '$198,500'],
            ['Paul Byrd', 'Chief Financial Officer (CFO)', 'New York', '3059', '2010/06/09', '$725,000'],
            ['Gloria Little', 'Systems Administrator', 'New York', '1721', '2009/04/10', '$237,500'],
            ['Bradley Greer', 'Software Engineer', 'London', '2558', '2012/10/13', '$132,000'],
            ['Dai Rios', 'Personnel Lead', 'Edinburgh', '2290', '2012/09/26', '$217,500'],
            ['Jenette Caldwell', 'Development Lead', 'New York', '1937', '2011/09/03', '$345,000'],
            ['Yuri Berry', 'Chief Marketing Officer (CMO)', 'New York', '6154', '2009/06/25', '$675,000'],
            ['Caesar Vance', 'Pre-Sales Support', 'New York', '8330', '2011/12/12', '$106,450'],
            ['Doris Wilder', 'Sales Assistant', 'Sydney', '3023', '2010/09/20', '$85,600'],
            ['Angelica Ramos', 'Chief Executive Officer (CEO)', 'London', '5797', '2009/10/09', '$1,200,000'],
            ['Gavin Joyce', 'Developer', 'Edinburgh', '8822', '2010/12/22', '$92,575'],
            ['Jennifer Chang', 'Regional Director', 'Singapore', '9239', '2010/11/14', '$357,650'],
            ['Brenden Wagner', 'Software Engineer', 'San Francisco', '1314', '2011/06/07', '$206,850'],
            ['Fiona Green', 'Chief Operating Officer (COO)', 'San Francisco', '2947', '2010/03/11', '$850,000'],
            ['Shou Itou', 'Regional Marketing', 'Tokyo', '8899', '2011/08/14', '$163,000'],
            ['Michelle House', 'Integration Specialist', 'Sydney', '2769', '2011/06/02', '$95,400'],
            ['Suki Burks', 'Developer', 'London', '6832', '2009/10/22', '$114,500'],
            ['Prescott Bartlett', 'Technical Author', 'London', '3606', '2011/05/07', '$145,000'],
            ['Gavin Cortez', 'Team Leader', 'San Francisco', '2860', '2008/10/26', '$235,500'],
            ['Martena Mccray', 'Post-Sales support', 'Edinburgh', '8240', '2011/03/09', '$324,050'],
            ['Unity Butler', 'Marketing Designer', 'San Francisco', '5384', '2009/12/09', '$85,675'],
        ];

        // $('#example').DataTable({
        //     data: dataSet,
        //     columns: [
        //         { title: 'Name' },
        //         { title: 'Position' },
        //         { title: 'Office' },
        //         { title: 'Extn.' },
        //         { title: 'Start date' },
        //         { title: 'Salary' },
        //     ],
        // });

    });
</script>