<?php include("connection.php"); 

if (empty($_SESSION['username']) || $_SESSION['username'] == ""){
  echo '<script language="javascript">';
  echo 'alert("Silahkan login terlebih dahulu");';
  echo 'window.location.href = "index.php";';
  echo '</script>';
}

$sql = "SELECT * FROM user WHERE username = '".$_SESSION['username']."'";
$result = $conn->query($sql);

while($row = $result->fetch_assoc()){
  $role = $row['role'];
}

?>
<?php  ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Aset Manajemen</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="shortcut icon" href="uploads/icon.png">
  <link rel="apple-touch-icon" href="uploads/icon-large.png">
  <link rel="image_src" href="uploads/icon-large.png">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="addon/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="addon/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="addon/bower_components/Ionicons/css/ionicons.min.css">
  <!-- DataTables -->
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css"> -->
  <link rel="stylesheet" href="addon/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <!-- <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.dataTables.min.css"> -->
  <!-- <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.bootstrap4.min.css"> -->
  <!-- daterange picker -->
  <link rel="stylesheet" href="addon/bower_components/bootstrap-daterangepicker/daterangepicker.css">

  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="addon/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="addon/plugins/iCheck/all.css">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="addon/bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">
  <!-- Bootstrap time Picker -->
  <link rel="stylesheet" href="addon/plugins/timepicker/bootstrap-timepicker.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="addon/bower_components/select2/dist/css/select2.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="addon/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <!-- <link rel="stylesheet" href="addon/dist/css/skins/_all-skins.min.css"> -->
  <link rel="stylesheet" href="addon/dist/css/skins/skin-red-light.min.css">

  <link rel="stylesheet" href="addon/dist/sweetalert/dist/sweetalert2.min.css">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-red-light sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="addon/index2.html" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>A</b>M</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Aset</b> Manajemen</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <span class="hidden-xs">
                <?php 
                  $sql = "SELECT * FROM user WHERE username = '".$_SESSION['username']."'";
                  $result = $conn->query($sql);
                  while ($hasil = $result->fetch_assoc()) {
                 ?>
                <?php echo $hasil['nama'] ?>
             
              </span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <p>
              Selamat Datang, <br><?php echo $hasil['nama'] ?>
              <br><br>Kini anda login sebagai <br><?php if($hasil['role'] == 1){ 
              echo "Manager"; } 
              else{
                echo " Operator";}
                ?>            </p>
              </li>
              <?php } ?>
              <!-- Menu Footer-->
              <li class="user-footer">
                <!-- <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Profile</a>
                </div> -->
                <div class="pull-right">
                  <a href="process.php?action=logout" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
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
      <!-- search form -->
      <!-- <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form> -->
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li>
          <a href="home.php">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-th"></i> <span>Inventaris</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="list_new_aset.php"><i class="fa fa-desktop"></i> Data Aset</a></li>
            <li><a href="list_new_data_lisensi.php"><i class="fa fa-certificate "></i> Data Lisensi</a></li>
            </li>
          </ul>
        </li>
        <li class="header">OTHER</li>
        <li>
          <a href="decrypt.php">
            <i class="fa fa-unlock-alt"></i> <span>Dekripsi</span>
          </a>
        </li>
        <li>
          <a href="laporan.php">
            <i class="fa fa-bar-chart"></i> <span>Laporan</span>
          </a>
        </li>
        <?php 
          if($role != 0){
        ?>
        <li>
          <a href="list_new_user.php">
            <i class="fa fa-users"></i> <span>Pengguna</span>
          </a>
        </li>
        <?php 
          }
          else{

          }
        ?>  
        
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>