<section class="content">
  <div class="container-fluid">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-lg-3 col-6">
          <div class="info-box bg-info">
              <span class="info-box-icon"><i class="far fa-bookmark"></i></span>
              <?php
                $sql="select gid,
                               (select if(count(*) > 0, 1, 0) from nodeA where gid = g.gid and create_at > now() - INTERVAL 5 MINUTE) as nodeA
                        from geteway as g
                        group by gid";
                $result = mysqli_query($conn, $sql);
                $_total_node = 0;
                $_active_node = 0;
                while($row = mysqli_fetch_array($result)) {
                    if ($row) {

                        if ($row['nodeA'] == 1) {
                            $_active_node++;
                        }
                        $_total_node++;
                    }
                }
              if ($_total_node > 0) $operating_rate = ($_active_node / $_total_node) *100;
              ?>
              <div class="info-box-content">
                  <span class="info-box-text">geteway 가동율</span>
                  <span class="info-box-number"><?php echo $operating_rate;?>%</span>

                  <div class="progress">
                      <div class="progress-bar" style="width: <?php echo $operating_rate;?>%"></div>
                  </div>
                  <span class="progress-description">
<!--                  70% Increase in 30 Days-->
                </span>
              </div>
              <!-- /.info-box-content -->
          </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
          <div class="info-box bg-success">
              <span class="info-box-icon"><i class="far fa-thumbs-up"></i></span>
              <?php
              $sql="select gid, nid,
                           (select if(count(*) >0, 1, 0 ) from nodeA where gid = g.gid and a_nid = g.nid and create_at > now() - INTERVAL 5 MINUTE) as nodeA
                    from geteway as g
                    group by nid";
              $result = mysqli_query($conn, $sql);
              $_total_node = 0;
              $_active_node = 0;
              while($row = mysqli_fetch_array($result)) {
                  if ($row) {

                      if ($row['nodeA'] == 1) {
                          $_active_node++;
                      }
                      $_total_node++;
                  }
              }
              if ($_total_node > 0) $node_rate = ($_active_node / $_total_node) *100;
              ?>
              <div class="info-box-content">
                  <span class="info-box-text">node 가동율</span>
                  <span class="info-box-number"><?php echo $node_rate;?>%</span>

                  <div class="progress">
                      <div class="progress-bar" style="width: <?php echo $node_rate;?>%"></div>
                  </div>
                  <span class="progress-description">
<!--                  70% Increase in 30 Days-->
                </span>
              </div>
              <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
      </div>
      <!-- ./col -->
      <div class="col-lg-6 col-6">
          <div class="info-box bg-warning">
              <span class="info-box-icon"><i class="far fa-calendar-alt"></i></span>

              <div class="info-box-content">
                  <span class="info-box-text">Last input</span>
                  <span class="info-box-number">41,410</span>

                  <div class="progress">
                      <div class="progress-bar" style="width: 70%"></div>
                  </div>
                  <span class="progress-description">
<!--                  70% Increase in 30 Days-->
                </span>
              </div>
              <!-- /.info-box-content -->
          </div>
      </div>
      <!-- ./col -->

    </div>
    <!-- /.row -->
    <!-- Main row -->
    <div class="row">
      <!-- Left col -->
      <section class="col-lg-9 connectedSortable">
        <!-- Custom tabs (Charts with tabs)-->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">
              <i class="fas fa-chart-pie mr-1"></i>
              Sales
            </h3>

          </div><!-- /.card-header -->
          <div class="card-body">
              <form class="form-horizontal">
                  <div class="card-body">
                      <div class="row">
                          <?php
                            $sql = "select distinct (gid) from geteway";
                            $result = mysqli_query($conn, $sql);
                          ?>
                          <div class="form-group col-5">
                              <label for="inputEmail3" class="col-sm-2 col-form-label">geteway</label>
                              <div class="col-sm-10">
                                  <select class="custom-select rounded-0" id="geteway">
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
                          </div>
                          <div class="form-group col-3">
                              <label for="inputEmail3" class="col-sm-2 col-form-label">node</label>
                              <div class="col-sm-10">
                                  <select class="custom-select rounded-0" id="node">
                                      <option value="">선택하세요.</option>
                                  </select>
                              </div>
                          </div>
                          <div class="form-group col-3">
                              <label for="inputEmail3" class="col-sm-2 col-form-label">센서</label>
                              <div class="col-sm-10">
                                  <select class="custom-select rounded-0" id="sensor">
                                      <option value="">선택하세요.</option>
                                  </select>
                              </div>
                          </div>
                      </div>

                      <div class="chart" style="">
                          <canvas id="myChart" style=""></canvas>
                      </div>
                  </div>
              </form>
          </div><!-- /.card-body -->
        </div>
        <!-- /.card -->
      </section>
      <!-- /.Left col -->
      <!-- right col (We are only adding the ID to make the widgets sortable)-->
      <section class="col-lg-3 connectedSortable">
          <div class="card">
              <div class="card-header">
                  <h3 class="card-title">
                      <i class="fas fa-chart-pie mr-1"></i>
                      Gateway 정보
                  </h3>

              </div>
              <!-- /.card-header -->
              <?php
                    $sql = "select gid,
                                   (select count(nid_type) from geteway where gid = g.gid and nid_type = 'a') as nodeA,
                                   (select count(nid_type) from geteway where gid = g.gid and nid_type = 'b') as nodeB,
                                   note
                            from geteway as g
                            group by gid
                            ";
                    $result = mysqli_query($conn, $sql);
              ?>
              <div class="card-body table-responsive p-0" style="height: 340px;">
                  <table class="table table-head-fixed text-nowrap">
                      <thead>
                      <tr>
                          <th>gid</th>
                          <th>nodeA</th>
                          <th>nodeB</th>
                          <th>site</th>
                      </tr>
                      </thead>
                      <tbody>
                      <?php
                        while($row = mysqli_fetch_array($result)) {
                      ?>
                      <tr>
                          <td><?php echo $row['gid'];?></td>
                          <td><?php echo $row['nodeA'];?></td>
                          <td><?php echo $row['nodeB'];?></td>
                          <td><span class="tag tag-success"><?php echo $row['note'];?></span></td>
                      </tr>
                      <?
                        }
                      ?>
                      </tbody>
                  </table>
              </div>
              <!-- /.card-body -->
          </div>
          <!-- /.card -->

        <!-- /.card -->
      </section>
      <!-- right col -->
    </div>
    <!-- /.row (main row) -->
  </div><!-- /.container-fluid -->
</section>
<script src="plugins/jquery/jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.0.1/chart.min.js" integrity="sha512-tQYZBKe34uzoeOjY9jr3MX7R/mo7n25vnqbnrkskGr4D6YOoPYSpyafUAzQVjV6xAozAqUFIEFsCO4z8mnVBXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
            if ($(this).val()) {
                $.ajax({
                    url:'../conf/dashboardAction.php',
                    type:'post',
                    data: {mode:'select_2', select_value1:$("#geteway").val(), select_value2:$(this).val()},
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


    });
</script>
