<div class="sidebar">
  <!-- Sidebar user panel (optional) -->
  <div class="user-panel mt-3 pb-3 mb-3 d-flex">
    <div class="image">
      <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
    </div>
    <div class="info">
      <a href="#" class="d-block"><?php echo $_SESSION['name'].'|'.$_SESSION['level'];?></a>
    </div>
  </div>



  <!-- Sidebar Menu -->
  <nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->

      <li class="nav-header">EXAMPLES</li>
        <li class="nav-item">
            <a href="member.php" class="nav-link active">
                <i class="nav-icon far fa-address-card"></i>
                <p>Member</p>
            </a>
        </li>
    </ul>
  </nav>
  <!-- /.sidebar-menu -->
</div>
