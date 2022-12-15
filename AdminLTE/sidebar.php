<div class="sidebar">
  <!-- Sidebar user panel (optional) -->
  <div class="user-panel mt-3 pb-3 mb-3 d-flex">
    <div class="image">
<!--      <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">-->
    </div>
    <div class="info">
<!--      <a href="#" class="d-block">--><?php //echo $_SESSION['name'].'|'.$_SESSION['level'];?><!--</a>-->

    </div>
  </div>

  <!-- Sidebar Menu -->
  <nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->

      <li class="nav-header">Memeber</li>
        <li class="nav-item">
            <a href="member.php" class="nav-link  <?php if (basename($_SERVER["PHP_SELF"]) == "member.php") {echo 'active';} ?>  ">
                <i class="nav-icon far fa-address-card"></i>
                <p>Member</p>
            </a>
        </li>
        <li class="nav-header">Date</li>
        <li class="nav-item">
            <a href="detaildata.php" class="nav-link <?php if (basename($_SERVER["PHP_SELF"]) == "detaildata.php") {echo 'active';} ?> ">
                <i class="nav-icon far fa-address-card"></i>
                <p>DetailDate</p>
            </a>
        </li>

        <li class="nav-header"><a href="/logout.php">Logout</a></li>
    </ul>
  </nav>
  <!-- /.sidebar-menu -->
</div>
