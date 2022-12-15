<!DOCTYPE html>
<html lang="en">
<?php session_start(); ?>
<?php  include_once "../connect.php"; ?>
<?php  include_once "header.php"; ?>
<?php // include_once "../conf/router.php"; ?>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Preloader -->
    <?php include_once "preloader.php" ?>

    <!-- Navbar -->
    <?php  include_once "navbar.php"; ?>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <?php include_once "logo.php" ?>

        <!-- Sidebar -->
        <?php include_once "sidebar.php"; ?>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Content Header (Page header) -->
        <?php include_once "content_header.php"; ?>
        <!-- /.content-header -->

        <!-- Main content -->
        <?php include_once "./data/data_detaildata.php"; ?>

        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 3.2.0
        </div>
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<?php include_once "footer.php"; ?>
</body>
</html>
<?php
