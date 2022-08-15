<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title><?= $title ?></title>

  <!-- Custom fonts for this template-->
  <link href="<?= base_url('assets/') ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="<?= base_url('assets/') ?>css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fa-solid fa-code"></i>
        </div>
        <div class="sidebar-brand-text mx-3">WPU Admin</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- QUERY MENU -->
      <?php
      $role_id = $this->session->userdata('role_id');
      $queryMenu = "SELECT * FROM user_menu INNER JOIN user_access_menu ON user_menu.id_menu = user_access_menu.id_menu WHERE user_access_menu.role_id = $role_id  ORDER BY user_access_menu.id_menu ASC";
      $menu = $this->db->query($queryMenu)->result_array();
      ?>
      <!-- Heading -->
      <!--LOOPING MENU  -->
      <?php foreach ($menu as $m) : ?>
        <div class="sidebar-heading">
          <?= $m['menu']; ?>
        </div>
        <!-- SUB MENU SESUAI MENU -->
        <?php
        $id_menu = $m['id_menu'];
        $querySub = "SELECT * FROM user_sub_menu INNER JOIN user_menu ON user_sub_menu.id_menu = user_menu.id_menu WHERE user_sub_menu.id_menu = $id_menu AND user_sub_menu.is_active=1";
        $subMenu = $this->db->query($querySub)->result_array();
        ?>
        <?php foreach ($subMenu as $sm) : ?>
          <?php if ($title == $sm['title']) : ?>
            <li class="nav-item active">
            <?php else : ?>
            <li class="nav-item">
            <?php endif; ?>
            <a class="nav-link " href="<?= base_url($sm['url']) ?>">
              <i class="<?= $sm['icon'] ?>"></i>
              <span><?= $sm['title'] ?></span></a>
            </li>
          <?php endforeach; ?>
          <hr class="sidebar-divider">
        <?php endforeach; ?>

        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('auth/logout') ?>">
            <i class="fas fa-sign-out-alt fa-ww"></i>
            <span>Logout</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">
        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
          <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>
          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">


            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"> <?= $user['name'] ?></span>
                <img class="img-profile rounded-circle" src="<?= base_url('assets/img/profiel/') . $user['image'] ?>">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="<?= base_url('auth/logout') ?>" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->