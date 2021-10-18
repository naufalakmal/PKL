<?php
$CI = &get_instance();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $title; ?></title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="<?php echo base_url('assets/template/bootstrap/css/bootstrap.min.css') ?>">

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

  <link rel="stylesheet" href="<?php echo base_url('assets/template/plugins/iCheck/all.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/template/dist/css/skins/_all-skins.min.css') ?>">

  <link rel="stylesheet" href="<?php echo base_url('assets/template/dist/css/AdminLTE.min.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css') ?>">


  <script src="<?php echo base_url('assets/template/plugins/jQuery/jQuery-2.1.4.min.js') ?>"></script>

  <script src="<?php echo base_url('assets/template/bootstrap/js/bootstrap.min.js') ?>"></script>
  <script src="<?php echo base_url('assets/template/plugins/select2/select2.full.min.js') ?>"></script>
  <script src="<?php echo base_url('assets/template/plugins/iCheck/icheck.min.js') ?>"></script>
  <script src="<?php echo base_url('assets/template/plugins/fastclick/fastclick.min.js') ?>"></script>
  <script src="<?php echo base_url('assets/template/dist/js/app.min.js') ?>"></script>
</head>

<body class="hold-transition skin-blue layout-boxed sidebar-mini">
  <div class="wrapper">
    <header class="main-header">
      <!-- Logo -->
      <a href="" class="logo">
        <span class="logo-mini"><b>PMO</b></span>
        <span class="logo-lg"><b>EKSPEDISI</b></span>
      </a>

      <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </a>
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">

            <li class="dropdown user user-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <img src="<?php echo base_url('assets/template/dist/img/avatar5.png') ?>" class="user-image" alt="User Image">
                <span class="hidden-xs"><?php echo $CI->getLoginName(); ?></span>
              </a>
            </li>
            <li>
              <a href="<?php echo site_url('login/logout') ?>"><i class="glyphicon glyphicon-log-out"></i></a>
            </li>
          </ul>
        </div>
      </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
          <div class="pull-left image">
            <img src="<?php echo base_url('assets/template/dist/img/avatar5.png') ?>" class="img-circle" alt="User Image">
          </div>
          <div class="pull-left info">
            <p><?php echo $CI->getLoginName(); ?></p>
            <span class="hidden-xs"><?php echo $CI->getLoginID(); ?></span>
          </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
          <li class="header">MAIN NAVIGATION</li>
          <li>
            <a href="<?php echo site_url() ?>">
              <i class="fa fa-dashboard"></i> <span>Dashboard</span> <i class="fa pull-right"></i>
            </a>
          </li>
          <?php if ($CI->getStatus() == '1' || $CI->getStatus() == '4') : ?>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-edit"></i> <span>Master</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php echo site_url('master_karyawan') ?>"><i class="fa fa-circle-o"></i> Karyawan</a></li>
                <li><a href="<?php echo site_url('master_spv') ?>"><i class="fa fa-circle-o"></i> Spv</a></li>
                <li><a href="<?php echo site_url('master_driver') ?>"><i class="fa fa-circle-o"></i> Driver</a></li>
                <li><a href="<?php echo site_url('master_kendaraan') ?>"><i class="fa fa-circle-o"></i> Kendaraan</a></li>
                <li><a href="<?php echo site_url('master_tujuan') ?>"><i class="fa fa-circle-o"></i> Tujuan</a></li>
                <li><a href="<?php echo site_url('master_pool') ?>"><i class="fa fa-circle-o"></i> Pool</a></li>
                <li><a href="<?php echo site_url('master_pelanggan') ?>"><i class="fa fa-circle-o"></i> Pelanggan</a></li>
                <li><a href="<?php echo site_url('master_tarif') ?>"><i class="fa fa-circle-o"></i> Tarif</a></li>

                <li><a href="<?php echo site_url('user') ?>"><i class="fa fa-circle-o"></i> User</a></li>
              </ul>
            </li>
          <?php endif; ?>

          <?php if ($CI->getStatus() == '1' || $CI->getStatus() == '4') : ?>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-edit"></i> <span>Referensi</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php echo site_url('ref_provinsi') ?>"><i class="fa fa-circle-o"></i> Provinsi</a></li>
                <li><a href="<?php echo site_url('ref_kota') ?>"><i class="fa fa-circle-o"></i> Kota</a></li>
                <li><a href="<?php echo site_url('ref_kecamatan') ?>"><i class="fa fa-circle-o"></i> Kecamatan</a></li>
                <li><a href="<?php echo site_url('ref_jenis_layanan') ?>"><i class="fa fa-circle-o"></i> Jenis Layanan</a></li>
                <li><a href="<?php echo site_url('ref_jenis_pembayaran') ?>"><i class="fa fa-circle-o"></i> Jenis Pembayaran</a></li>

              </ul>
            </li>
          <?php endif; ?>

          <?php if ($CI->getStatus() == '1' || $CI->getStatus() == '4') : ?>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-edit"></i> <span>Order</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php echo site_url('transaksi_order') ?>"><i class="fa fa-circle-o"></i> Booking</a></li>
                <li><a href="<?php echo site_url('transaksi_ttb') ?>"><i class="fa fa-circle-o"></i> TTB</a></li>
              </ul>
            </li>
          <?php endif; ?>

          <?php if ($CI->getStatus() == '3' || $CI->getStatus() == '1') : ?>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-edit"></i> <span>Pengiriman</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php echo site_url('pengiriman') ?>"><i class="fa fa-circle-o"></i> Surat Pengiriman Barang</a></li>

              </ul>
            </li>
          <?php endif; ?>
          <?php if ($CI->getStatus() == '3' || $CI->getStatus() == '1') : ?>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-edit"></i> <span>Pembayaran</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php echo site_url('transaksi_pembayaran_amplop') ?>"><i class="fa fa-circle-o"></i> Pembayaran Amplop</a></li>

              </ul>
            </li>
          <?php endif; ?>
          <?php if ($CI->getStatus() == '2' || $CI->getStatus() == '1') : ?>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-files-o"></i> <span>Laporan</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php echo site_url('pengiriman/rekap') ?>"><i class="fa fa-circle-o"></i> Laporan Pengiriman</a></li>
                <li><a href="<?php echo site_url('laporan_piutang/rekap') ?>"><i class="fa fa-circle-o"></i> Laporan Piutang</a></li>
                <li><a href="<?php echo site_url('laporan_pembayaran/rekap') ?>"><i class="fa fa-circle-o"></i> Laporan Pembayaran</a></li>
              </ul>
            </li>
          <?php endif; ?>
          <?php if ($CI->getStatus() == '2' || $CI->getStatus() == '1') : ?>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-files-o"></i> <span>Monitoring</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php echo site_url('pengiriman/rekapbooking') ?>"><i class="fa fa-circle-o"></i> Status Booking</a></li>
                <li><a href="<?php echo site_url('pengiriman/rekapditerimastb') ?>"><i class="fa fa-circle-o"></i> Status Diterima Oleh STB</a></li>
                <li><a href="<?php echo site_url('pengiriman/rekapdikirim') ?>"><i class="fa fa-circle-o"></i> Status Dikirim</a></li>
                <li><a href="<?php echo site_url('pengiriman/rekapretur') ?>"><i class="fa fa-circle-o"></i> Status Retur</a></li>
                <li><a href="<?php echo site_url('pengiriman/rekapditerimapenerima') ?>"><i class="fa fa-circle-o"></i> Status Diterima Oleh Penerima</a></li>

              </ul>
            </li>
          <?php endif; ?>
          <?php if ($CI->getStatus() == '1' || $CI->getStatus() == '4') : ?>
            <li class="treeview">
              <a href="<?php echo site_url('lokasi') ?>">
                <i class="fa fa-dashboard"></i> <span>lokasi</span> <i class="fa pull-right"></i>
              </a>
            </li>
          <?php endif; ?>

          <li class="treeview">
            <a href="#">
              <i class="fa fa-gears"></i> <span>Settings</span>
              <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
              <li><a href="<?php echo site_url('changepassword') ?>"><i class="fa fa-circle-o"></i> Ganti Password</a></li>
            </ul>
          </li>
        </ul>
      </section>
    </aside>

    <?php echo $this->load->view($layout); ?>
    <div class="control-sidebar-bg"></div>
  </div><!-- ./wrapper -->
</body>

</html>
