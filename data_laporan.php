<?php

  require_once('vigenere.php');
  include("header.php");
  $id_user = $_SESSION['id_user'];
                $query_status_cipher = "SELECT `status` from status_cipher WHERE `user_id` = $id_user";
                $response = $conn->query($query_status_cipher);
                $status_cipher = $response->fetch_assoc();
  $vigenere = new Vigenere($chiave);

  if(isset($_POST['nik'])){
    $nik = $_POST['nik'];
    $sql = "SELECT 
            aset.aset_id,
            aset.nik,
            aset.nama_karyawan,
            aset.model,
            aset.divisi,
            aset.serialnumber,
            aset.hostname,
            aset.aset_kategori,
            aset.status,
            aset.aset_input_date,
            kategori_aset.nama_kategori_aset,
            stat.nama_status
            FROM aset 
            INNER JOIN kategori_aset ON aset.aset_kategori = kategori_aset.id_kategori_aset
            INNER JOIN stat ON aset.status = stat.id_status
            WHERE nik = '".$nik."'";
  }else{
    $tgl_awal = $_POST['tgl_awal'];
    $tgl_akhir = $_POST['tgl_akhir'];
    $sql = "SELECT 
            aset.aset_id,
            aset.nik,
            aset.nama_karyawan,
            aset.model,
            aset.divisi,
            aset.serialnumber,
            aset.hostname,
            aset.aset_kategori,
            aset.status,
            aset.aset_input_date,
            kategori_aset.nama_kategori_aset,
            stat.nama_status
            FROM aset 
            INNER JOIN kategori_aset ON aset.aset_kategori = kategori_aset.id_kategori_aset
            INNER JOIN stat ON aset.status = stat.id_status
            WHERE (aset_input_date BETWEEN '".$tgl_awal."' AND '".$tgl_akhir."')";
  }  
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Data Laporan Aset
    </h1>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <!-- /.box-header -->
          <div class="box-body">
          
          <table id="table-aset" class="table table-bordered table-striped">

              <thead>
                <tr>
                  <th style="width: 10px">No</th>
                  <th>NIK</th>
                  <th>Nama Karyawan</th>
                  <th>Model</th>
                  <th>Divisi</th>
                  <th>Serial Number</th>
                  <th>Hostname</th>
                  <th>Kategori Perangkat</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                  // create condition for encrypt/decrypt
                  $id_user = $_SESSION['id_user'];
                  $query_status_cipher = "SELECT `status` from status_cipher WHERE `user_id` = $id_user";
                  $response = $conn->query($query_status_cipher);
                  $status_cipher = $response->fetch_assoc();

                  if($status_cipher['status'] == 0){
                    if($_POST['data'] == 'tanggal'){
                      if($status_cipher['status'] == 0){
                        $tgl_awal = $_POST['tgl_awal'];
                        $tgl_akhir = $_POST['tgl_akhir'];
                        $sql = "SELECT 
                                aset.aset_id,
                                aset.nik,
                                aset.nama_karyawan,
                                aset.model,
                                aset.divisi,
                                aset.serialnumber,
                                aset.hostname,
                                aset.aset_kategori,
                                aset.status,
                                aset.aset_input_date,
                                kategori_aset.nama_kategori_aset,
                                stat.nama_status
                                FROM aset 
                                INNER JOIN kategori_aset ON aset.aset_kategori = kategori_aset.id_kategori_aset
                                INNER JOIN stat ON aset.status = stat.id_status
                                WHERE (aset_input_date BETWEEN '".$tgl_awal."' AND '".$tgl_akhir."')";
                        $no = 0;
                        $result = $conn->query($sql);
                        while ($hasil = $result->fetch_assoc()) {
                          $no = $no + 1;
                    ?>
                    <tr>
                        <td><?php echo $no; ?></td>
                        <td><?php echo $hasil['nik'] ?></td>
                        <td><?php echo $hasil['nama_karyawan'] ?></td>
                        <td><?php echo $hasil['divisi'] ?></td>
                        <td><?php echo $hasil['model'] ?></td>
                        <td><?php echo $hasil['serialnumber'] ?></td>
                        <td><?php echo $hasil['hostname'] ?></td>
                        <td><?php echo $vigenere->cifratura($hasil['nama_kategori_aset']) ?></td>
                        <td><?php echo $vigenere->cifratura($hasil['nama_status']) ?></td>
                    </tr>
                  <?php
                        }
                      }
                      elseif($status_cipher['status']==1){
                    $result = $conn->query($sql);
                    if($result->num_rows >0){
                      $no = 0;
                      while ($hasil = $result->fetch_assoc()) {
                          $no = $no + 1;
                          $nik = $vigenere->decifratura($hasil['nik']);
                          $name_up = $vigenere->decifratura($hasil['nama_karyawan']);
                          $divisi_up = $vigenere->decifratura($hasil['divisi']);
                          $model_up = $vigenere->decifratura($hasil['model']);
                          $serial_number = $vigenere->decifratura($hasil['serialnumber']);
                          $hostname_up = $vigenere->decifratura($hasil['hostname']);
                          $kategori = $hasil['nama_kategori_aset'];
                          $nama_karyawan = strtolower($name_up);
                          $divisi = strtolower($divisi_up);
                          $model = strtolower($model_up);
                          $hostname = strtolower($hostname_up);
                          $status = $hasil['nama_status'];
                      ?>
                        <tr>
                          <td><?= $no; ?></td>
                          <td><?= $nik ?></td>
                          <td><?= ucwords($nama_karyawan) ?></td>
                          <td><?= ucwords($divisi) ?></td>
                          <td><?= ucwords($model) ?></td>
                          <td><?= $serial_number ?></td> 
                          <td><?= ucwords($hostname) ?></td>
                          <td><?= $kategori ?></td>
                          <td><?= $status ?></td>
                        </tr>
                      <?php
                      }
                        }
                      }
                 }elseif($_POST['data'] == 'nik'){
                  $result = $conn->query($sql);
                  if($result->num_rows >0){
                    $no = 0;
                    while ($hasil = $result->fetch_assoc()) {
                  $no = 0;
                    $no = $no + 1;
                    
                ?>
                      <tr>
                          <td><?= $no; ?></td>
                          <td><?= $hasil['nik'] ?></td>
                          <td><?= $hasil['nama_karyawan'] ?></td>
                          <td><?= $hasil['divisi'] ?></td>
                          <td><?= $hasil['model'] ?></td>
                          <td><?= $hasil['serialnumber'] ?></td> 
                          <td><?= $hasil['hostname'] ?></td>
                          <td><?= $vigenere->cifratura($hasil['nama_kategori_aset']) ?></td>
                          <td><?= $vigenere->cifratura($hasil['nama_status']) ?></td>
                        </tr>
                  <?php
                      }
                    }
                  }
                }    
                  
                  else{
                    if($_POST['data'] == 'tanggal'){
                      if($status_cipher['status'] == 0){
                        $tgl_awal = $_POST['tgl_awal'];
                        $tgl_akhir = $_POST['tgl_akhir'];
                        $sql = "SELECT 
                                aset.aset_id,
                                aset.nik,
                                aset.nama_karyawan,
                                aset.model,
                                aset.divisi,
                                aset.serialnumber,
                                aset.hostname,
                                aset.aset_kategori,
                                aset.status,
                                aset.aset_input_date,
                                kategori_aset.nama_kategori_aset,
                                stat.nama_status
                                FROM aset 
                                INNER JOIN kategori_aset ON aset.aset_kategori = kategori_aset.id_kategori_aset
                                INNER JOIN stat ON aset.status = stat.id_status
                                WHERE (aset_input_date BETWEEN '".$tgl_awal."' AND '".$tgl_akhir."')";
                        $no = 0;
                        while ($hasil = $result->fetch_assoc()) {
                          $no = $no + 1;
                    ?>
                    <tr>
                        <td><?php echo $no; ?></td>
                        <td><?php echo $hasil['nama_lisensi'] ?></td>
                        <td><?php echo $vigenere->cifratura($hasil['nama_kategori_lisensi']) ?></td>
                        <td><?php echo $hasil['serialnumber'] ?></td>
                        <td><?php echo $vigenere->cifratura($hasil['banyak_lisensi']) ?></td>
                        <td><?php echo $vigenere->cifratura($hasil['nama_status']) ?></td>
                    </tr>
                  <?php
                        }
                      }
                      elseif($status_cipher['status']==1){
                    $result = $conn->query($sql);
                    if($result->num_rows >0){
                      $no = 0;
                      while ($hasil = $result->fetch_assoc()) {
                          $no = $no + 1;
                          $nik = $vigenere->decifratura($hasil['nik']);
                          $name_up = $vigenere->decifratura($hasil['nama_karyawan']);
                          $divisi_up = $vigenere->decifratura($hasil['divisi']);
                          $model_up = $vigenere->decifratura($hasil['model']);
                          $serial_number = $vigenere->decifratura($hasil['serialnumber']);
                          $hostname_up = $vigenere->decifratura($hasil['hostname']);
                          $kategori = $hasil['nama_kategori_aset'];
                          $nama_karyawan = strtolower($name_up);
                          $divisi = strtolower($divisi_up);
                          $model = strtolower($model_up);
                          $hostname = strtolower($hostname_up);
                          $status = $hasil['nama_status'];
                      ?>
                        <tr>
                          <td><?= $no; ?></td>
                          <td><?= $nik ?></td>
                          <td><?= ucwords($nama_karyawan) ?></td>
                          <td><?= ucwords($divisi) ?></td>
                          <td><?= ucwords($model) ?></td>
                          <td><?= $serial_number ?></td> 
                          <td><?= ucwords($hostname) ?></td>
                          <td><?= $kategori ?></td>
                          <td><?= $status ?></td>
                        </tr>
                      <?php
                      }
                        }
                      }
                 }elseif($_POST['data'] == 'nik'){
                  $result = $conn->query($sql);
                  if($result->num_rows >0){
                    $no = 0;
                    while ($hasil = $result->fetch_assoc()) {
                  $no = 0;
                    $no = $no + 1;
                    $nik = $vigenere->decifratura($hasil['nik']);
                    $name_up = $vigenere->decifratura($hasil['nama_karyawan']);
                    $divisi_up = $vigenere->decifratura($hasil['divisi']);
                    $model_up = $vigenere->decifratura($hasil['model']);
                    $serial_number = $vigenere->decifratura($hasil['serialnumber']);
                    $hostname_up = $vigenere->decifratura($hasil['hostname']);
                    $kategori = $hasil['nama_kategori_aset'];
                    $nama_karyawan = strtolower($name_up);
                    $divisi = strtolower($divisi_up);
                    $model = strtolower($model_up);
                    $hostname = strtolower($hostname_up);
                    $status = $hasil['nama_status'];
                ?>
                      <tr>
                          <td><?= $no; ?></td>
                          <td><?= $nik ?></td>
                          <td><?= ucwords($nama_karyawan) ?></td>
                          <td><?= ucwords($divisi) ?></td>
                          <td><?= ucwords($model) ?></td>
                          <td><?= $serial_number ?></td> 
                          <td><?= ucwords($hostname) ?></td>
                          <td><?= $kategori ?></td>
                          <td><?= $status ?></td>
                        </tr>
                  <?php
                      }
                    }
                  }
                }    
                  
                ?>
                
            </table>
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