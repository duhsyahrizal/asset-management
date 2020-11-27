<?php

  include("header.php");
  $catLaptop = "SELECT aset_id FROM aset WHERE aset_kategori = 1";
  $catPC = "SELECT aset_id FROM aset WHERE aset_kategori = 2";
  $catAio = "SELECT aset_id FROM aset WHERE aset_kategori = 3";
  $catPrinter = "SELECT aset_id FROM aset WHERE aset_kategori = 4";
  $catRouter = "SELECT aset_id FROM aset WHERE aset_kategori = 5";
  $catAp = "SELECT aset_id FROM aset WHERE aset_kategori = 6";
  $catLain = "SELECT aset_id FROM aset WHERE aset_kategori = 7";
  
  $cLaptop = $conn->query($catLaptop);
  $cPc = $conn->query($catPC);
  $cAio = $conn->query($catAio);
  $cPrinter = $conn->query($catPrinter);
  $cRouter = $conn->query($catRouter);
  $cAp = $conn->query($catAp);
  $cLain = $conn->query($catLain);

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      &nbsp;
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Dashboard</h3>
          </div>
          
          <div class="box-body">
            <div class="row">
              <div class="col-lg-4 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                  <div class="inner">
                    <h3>
                      <?php 
                        $sql = "SELECT count(aset_id) AS jumlah FROM aset";
                        $result = $conn->query($sql);
                        $hasil = $result->fetch_assoc();
                        $count_aset = $hasil['jumlah'];
                        echo $hasil['jumlah'];
                      ?>
                    </h3>

                    <p>Asets</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-bag"></i>
                  </div>
                  <a href="list_new_aset.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <!-- ./col -->
              <div class="col-lg-4 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                  <div class="inner">
                    <h3>
                      <?php 
                        $sql = "SELECT count(id_lisensi) AS jumlah FROM lisensi";
                        $result = $conn->query($sql);
                        $hasil = $result->fetch_assoc();
                        $count_lisensi = $hasil['jumlah'];
                        echo $hasil['jumlah'];
                      ?>
                    </h3>

                    <p>Lisensi</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                  </div>
                  <a href="list_new_data_lisensi.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <!-- ./col -->
              <div class="col-lg-4 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                  <div class="inner">
                    <h3>
                      <?php 
                         $sql = "SELECT count(id_user) AS jumlah FROM user";
                         $result = $conn->query($sql);
                         $hasil = $result->fetch_assoc();
                         $count_user = $hasil['jumlah'];
                         echo $hasil['jumlah'];
                      ?>
                    </h3>

                    <p>User</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-person-add"></i>
                  </div>
                  <a href="list_new_user.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
               
			<!-- /.box -->
        </div>
        <div class="col-md-4">
</div>
       <!-- /.box-header -->
       <div class="col-md-4">
       <div class="box box-primary">
			  <div class="box-header with-border">
				<h3 class="box-title"></h3>
				<div class="box-tools pull-right">
				  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				</div>
			  </div>
			  <div class="box-body">
				  <div class="row">
	                <div class="col-lg-6">
	                  <div class="chart-responsive">
	                    <canvas id="pieChart" height="132px"></canvas>
	                  </div>
	                  <!-- ./chart-responsive -->
	                </div>
	                <!-- /.col -->
	                <div class="col-lg-6">
	                  <div class="chart-legend">
                      <ul style="list-style: none; padding: 4px 0;">
                        <li><small><i  style="color: #daea11; padding-bottom: 10px;" class="fa fa-circle"> </i></small> Laptop <span class='label' style='margin-left: 4px;background-color:#FFF;color:#000;border:1px solid #daea11'><?=$cLaptop->num_rows?></li>
                        <li><small><i  style="color: #058e29; padding-bottom: 10px;" class="fa fa-circle"> </i></small> PC Desktop <span class='label' style='margin-left: 4px;background-color:#FFF;color:#000;border:1px solid #058e29'><?=$cPc->num_rows?></li>
                        <li><small><i  style="color: #ff0000; padding-bottom: 10px;" class="fa fa-circle"> </i></small> All in One <span class='label' style='margin-left: 4px;background-color:#FFF;color:#000;border:1px solid #ff0000'><?=$cAio->num_rows?></li>
                        <li><small><i  style="color: #0000ff; padding-bottom: 10px;" class="fa fa-circle"> </i></small> Printer <span class='label' style='margin-left: 4px;background-color:#FFF;color:#000;border:1px solid #0000ff'><?=$cPrinter->num_rows?></li>
                        <li><small><i  style="color: #252758; padding-bottom: 10px;" class="fa fa-circle"> </i></small> Router <span class='label' style='margin-left: 4px;background-color:#FFF;color:#000;border:1px solid #252758'><?=$cRouter->num_rows?></li>
                        <li><small><i  style="color: #9083ca; padding-bottom: 10px;" class="fa fa-circle"> </i></small> Access Point <span class='label' style='margin-left: 4px;background-color:#FFF;color:#000;border:1px solid #9083ca'><?=$cAp->num_rows?></li>
                        <li><small><i  style="color: #20fead; padding-bottom: 10px;" class="fa fa-circle"> </i></small> Lainnya <span class='label' style='margin-left: 4px;background-color:#FFF;color:#000;border:1px solid #20fead'><?=$cLain->num_rows?></li>
                      </ul>
	                  </div>
	                </div>
	                <!--x  /.col -->
	              </div>
	              <!-- /.row -->
			  </div>
			  <!-- /.box-body -->
      </div>
</div>
    </div>
  </section>
  <!-- /.content -->
</div>

<!-- /.content-wrapper -->

<?php include("footer.php"); ?>