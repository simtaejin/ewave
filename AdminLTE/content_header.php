<?php
    if (basename($_SERVER["PHP_SELF"]) == "index.php") {
        $_title = "Dashboard";
    } else if (basename($_SERVER["PHP_SELF"]) == "member.php") {
        $_title = "Member";
    } else if (basename($_SERVER["PHP_SELF"]) == "detaildata.php") {
        $_title = "DetailData";
    }
?>

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0"><?php echo $_title;?></h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="/AdminLTE/">Home</a></li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>