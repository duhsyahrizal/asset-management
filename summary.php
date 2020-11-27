<?php

	require_once('vigenere.php');
	include("header.php");
	$sql = "SELECT * FROM user WHERE username = '".$_SESSION['username']."'";
	$result = $conn->query($sql);

	while($row = $result->fetch_assoc()){
		$role = $row['role'];
	}

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Summary
      <!-- <button class="btn btn-primary" style="float: right;" id="openAddModal">Tambah Aset</button> -->
    </h1>
  </section>

  <!-- Main content -->
  <section class="content">
				<div class="row">
		<div class="col-md-12">

		  <?php
		    $vigenere = new Vigenere($chiave);
        if($_GET['data'] == 'aset'){
			  $sql = "SELECT 
			  aset.aset_id,
			  aset.nik,
			  aset.nama_karyawan,
			  aset.model,
			  aset.serialnumber,
			  aset.aset_kategori,
			  aset.status,
			  aset.aset_input_date,
			  aset.created_by,
			  kategori_aset.nama_kategori_aset,
			  stat.nama_status
			  FROM 
			  aset 
			  INNER JOIN kategori_aset ON aset.aset_kategori = kategori_aset.id_kategori_aset
			  INNER JOIN stat ON aset.status = stat.id_status WHERE aset_id = '".$_GET['id']."'";
                  $result = $conn->query($sql);
                  while ($hasil = $result->fetch_assoc()) {
										$nik = $vigenere->decifratura($hasil['nik']);
                    $name_up = $vigenere->decifratura($hasil['nama_karyawan']);
                    $model_up = $vigenere->decifratura($hasil['model']);
					  				$serial_number = $vigenere->decifratura($hasil['serialnumber']);
					  				$kategori = $hasil['nama_kategori_aset'];
					  				$status = $hasil['nama_status'];
										$tanggal = $hasil['aset_input_date'];
										$dibuat = $hasil['created_by'];
										}
			?>
			            <!-- Custom Tabs (Pulled to the right) -->
						<div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active" ><a href="#">Summary</a></li>
              <div class="btn-group pull-right" style="padding:6px;">
					<div class="btn-group">
						<ul class="dropdown-menu pull-right">
						</ul>
					</div>

                </div>

            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab-summary">
				  <div class="row">
		  	  		<div class="col-xs-4">
						<div class="box box-primary">
		                    <div class="box-body">
								<table id="clientTable" class="table table-striped table-hover">
									<tbody>
										<tr>
											<td><b>Status</b></td>
											<td><span class='badge' style='background-color:#3479da'><?= $status ?></span></td>
										</tr>
										<tr>
											<td><b>NIK</b></td>
											<td><?= ucwords($nik) ?></td>
										</tr>
										<tr>
											<td><b>Nama Karyawan</b></td>
											<td><?= ucwords($name_up) ?></td>
										</tr>
										<tr>
											<td><b>Kategori Aset</b></td>
											<td><span class='label' style='background-color:#FFF;color:#1e3fda;border:1px solid #1e3fda'><?= $kategori ?></span></td>
										</tr>
										<tr>
											<td><b>Model</b></td>
											<td><?= ucwords($model_up) ?></td>
										</tr>
										<tr>
											<td><b>Serial Number</b></td>
											<td><?= $serial_number ?></td>
										</tr>
										<tr>
											<td><b>Created By</b></td>
											<td><?= $dibuat?></td>
										</tr>
										<tr>
											<td><b>Terpasang pada Tanggal</b></td>
											<td><?= $tanggal ?></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="col-xs-8">		
						<div class="box box-primary">
		                    <div class="box-header">
								<h3 class="box-title">Assigned Licenses</h3>
								<div class="pull-right box-tools">
									<button type="button" class="btn btn-default btn-sm btn-flat" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
				                </div>
							</div>
							
		                    <div class="box-body">
								<div class="table-responsive">
			                        <table class="table table-striped table-hover table-bordered">
			                            <thead>
										<tr>
			                                    <th>No</th>
												<th>Nama Lisensi</th>
												<th>Kategori Lisensi</th>
			                                </tr>
										<?php
										$sqlaset = "SELECT 
										banyak_lisensi.id_banyak_lisensi,
										banyak_lisensi.id_lisensi, 
										banyak_lisensi.aset_id,
										lisensi.nama_lisensi,
										lisensi.kategori_lisensi,
										kategori_lisensi.nama_kategori_lisensi
										FROM 
										banyak_lisensi 
										INNER JOIN lisensi ON banyak_lisensi.id_lisensi = lisensi.id_lisensi
										INNER JOIN kategori_lisensi ON lisensi.kategori_lisensi = kategori_lisensi.id_kategori_lisensi
										WHERE banyak_lisensi.aset_id = '".$_GET['id']."'";
										$no = 0;
										$result = $conn->query($sqlaset);
										while ($hasil = $result->fetch_assoc()){
											$no = $no + 1;
											$nama_lisensi = ucwords(strtolower($vigenere->decifratura($hasil['nama_lisensi'])));
											$nama_kategori_lisensi = $hasil['nama_kategori_lisensi'];
										?>
			                                
			                            </thead>
			                            <tbody>
											<tr><td><?= $no ?></td>
											<td><?= $nama_lisensi ?></td>
											<td><?= $nama_kategori_lisensi ?></td><td><div class='pull-right'><button class="btn btn-danger" onclick="hapusAssignOnAset(<?php echo $hasil['aset_id']; ?>)"><i class='fa fa-trash-o'></i></button></div></td></tr>
											</tbody>
											<?php } ?>
										
									</table>
								</div>
															</div>
						</div>

						<div class="box box-primary">
							<div class="box-header">
								<h3 class="box-title">Catatan</h3>
								<div class="pull-right box-tools">
									<button type="button" class="btn btn-default btn-sm btn-flat" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
								</div>
							</div>
							<div class="box-body">
															</div>
						</div>

					</div>
				</div>
			  </div>									
			<?php 
		}
			
            else if($_GET['data'] == 'lisensi'){ 
							$sql = "SELECT
                          lisensi.id_lisensi,
                          lisensi.nama_lisensi,
                          lisensi.serialnumber,
                          lisensi.kategori_lisensi,
                          lisensi.status,
                          lisensi.banyak_lisensi,
                          lisensi.lisensi_input_date,
													lisensi.created_by,
                          kategori_lisensi.nama_kategori_lisensi,
                          stat.nama_status
                          FROM
                          lisensi
                          INNER JOIN kategori_lisensi ON lisensi.kategori_lisensi = kategori_lisensi.id_kategori_lisensi
													INNER JOIN stat ON lisensi.status = stat.id_status WHERE id_lisensi = '".$_GET['id']."'";
							$sqlCount = "SELECT id_lisensi FROM banyak_lisensi WHERE id_lisensi = '".$_GET['id']."'";
							$res = $conn->query($sqlCount);
							$countLisensi = $res->num_rows; 
							$result = $conn->query($sql);
							
						  while ($hasil = $result->fetch_assoc()) {
							$namalisensi = $vigenere->decifratura($hasil['nama_lisensi']);
							$serialnumber = $vigenere->decifratura($hasil['serialnumber']);
							$banyak_lisensi = $hasil['banyak_lisensi'];
							$kategori = $hasil['nama_kategori_lisensi'];
							$kategori_lisensi = $hasil['kategori_lisensi'];
							$created_by = $hasil['created_by'];
							$status = $hasil['nama_status'];
							$tanggal = $hasil['lisensi_input_date'];
							}
							$countLisensi = ($countLisensi > $banyak_lisensi)?5:$countLisensi;
							$test = '';
							?>
		<div class="row">
		<div class="col-md-12">
          <!-- Custom Tabs (Pulled to the right) -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab-summary" data-toggle="tab">Summary</a></li>
			  <div class="btn-group pull-right" style="padding:6px;">
			  <?php 
          if($role != 1){
        ?>
				<button id="assign_aset" class="btn btn-primary btn-sm btn-flat" onclick="openAssign()"><i class="fa fa-thumb-tack fa-fw"></i> Assign Aset</button>
				<?php 
          }
          else{
          }
        ?>  
			</div>

            </ul>

            <div class="tab-content">
              <div class="tab-pane active" id="tab-summary">
				  <div class="row">
		  	  		<div class="col-xs-4">
						<div class="box box-primary">
		                    <div class="box-body">
								<table id="clientTable" class="table table-striped table-hover">
									<tbody>
										<tr>
											<td><b>Status</b></td>
											<td><span class='badge' style='background-color:#1ecbbd'><?= $status ?></span></td>
										</tr>
										<tr>
											<td><b>Kategori Lisensi</b></td>
											<td><span class='label' style="background-color:#FFF;color:#355ea7;border:1px solid #355ea7;"><?= $kategori ?></span></td>
										</tr>
										<tr>
											<td><b>Nama Lisensi</b></td>
											<td><?= ucwords ($namalisensi) ?></td>
										</tr>
										<tr>
											<td><b>Dibuat Oleh</b></td>
											<td><?= ucwords($created_by) ?></td>
										</tr>

										<tr>
											<td><b>Banyak Lisensi</b></td>
											<td>
									<span class='label' style="background-color:#FFF;color:#029ca1;border:1px solid #029ca1;"><span id="count_lisensi"><?= $countLisensi ?></span> / <span id="banyak_lisensi"><?= $banyak_lisensi ?></span></span>
																							</td>
										</tr>

										<tr>
											<td><b>Serial Number</b></td>
											<td><?= ucwords ($serialnumber) ?></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>

					</div>

					<div class="col-xs-8">
						<div class="box box-primary">
		                    <div class="box-header">
								<h3 class="box-title">Assigned Assets</h3>
								<div class="pull-right box-tools">
									<button type="button" class="btn btn-default btn-sm btn-flat" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
				                </div>
							</div>
		                    <div class="box-body">
								<div class="table-responsive">
			                        <table class="table table-striped table-hover table-bordered">
			                            <thead>
			                                <tr>
			                                    <th>No</th>
			                                    <th>NIK</th>
												<th>Kategori Aset</th>
			                                    <th>Model</th>
												<th>Nama Karyawan</th>
											</tr>
											<?php
										$sqllisensi = "SELECT 
										`banyak_lisensi`.`id_banyak_lisensi`, 
										`banyak_lisensi`.`aset_id`, 
										`banyak_lisensi`.`id_lisensi`, 
										`aset`.`nik`, 
										`aset`.`aset_kategori`, 
										`aset`.`model`, 
										`aset`.`nama_karyawan`, 
										`kategori_aset`.`nama_kategori_aset` 
										FROM `banyak_lisensi` 
										INNER JOIN `aset` ON `banyak_lisensi`.`aset_id` = `aset`.`aset_id` 
										INNER JOIN `kategori_aset` ON `aset`.`aset_kategori` = `kategori_aset`.`id_kategori_aset` 
										WHERE `banyak_lisensi`.`id_lisensi` = '".$_GET['id']."'";
										$no = 0;
										$result = $conn->query($sqllisensi);
										while ($hasil = $result->fetch_assoc()){
											$no = $no + 1;
											$nik = $vigenere->decifratura($hasil['nik']);
											$nama_kategori_aset = $hasil['nama_kategori_aset'];
											$model = ucwords(strtolower($vigenere->decifratura($hasil['model'])));
											$namakaryawan = ucwords(strtolower($vigenere->decifratura($hasil['nama_karyawan'])));
											
										?>
			                            </thead>
			                            <tbody>
										<tr><td><?= $no ?></td>
											<td><?= $nik ?></td>
											<td><?= $nama_kategori_aset ?></td>
											<td><?= $model ?></td>
											<td><?= $namakaryawan ?></td>
											<td><button onclick="hapusAssignOnLicense(<?=$hasil['aset_id']?>)" class='pull-right btn btn-danger'><i class='fa fa-trash-o'></i></button></td></tr>
										</tbody>
										<?php } ?>
									</table>
								</div>
							</div>
						</div>

						<div class="box box-primary">
							<div class="box-header">
								<h3 class="box-title">Catatan</h3>
								<div class="pull-right box-tools">
									<input type="hidden" id="id_lisensi" value="<?=$_GET['id']?>">
									<button type="button" class="btn btn-default btn-sm btn-flat" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
								</div>
							</div>
							<div class="box-body">
															</div>
						</div>


					</div>
				</div>
              </div>
           <?php }
          ?>
          </div>
          <!-- /.box-body -->
        </div>
      </div>
    </div>
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- /.Assign Aset -->
<div class="modal fade" id="modal-assign">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Assign Lisensi to Aset</h4>
      </div>
      <div class="modal-body">
				<?php 
				
					if($kategori_lisensi != 4){
						$sql = "SELECT aset_id, model FROM aset WHERE aset_kategori BETWEEN 1 AND 3";
						$result = $conn->query($sql);
						?>
						<label>Model Laptop/PC</label>
						<input type="hidden" value="<?=$_GET['id']?>">
						<select id="aset_id" class="form-control select2" style="width: 100%;">
						<?php 
							if($result->num_rows > 0){
								while($hasil = $result->fetch_assoc()){
						?>
						<option value="<?=$hasil['aset_id']?>"><?=$vigenere->decifratura($hasil['model'])?></option>
						<?php
								}
							}
						?>
				</select> 
				<?php 
					}else{
				?>
				<label>Perangkat Print dan Jaringan</label>
						<select id="aset_id" class="form-control select2" style="width: 100%;">
						<?php 
							$sql = "SELECT aset_id, model FROM aset WHERE aset_kategori BETWEEN 4 AND 7";
							$result = $conn->query($sql);
							if($result->num_rows > 0){
								while($hasil = $result->fetch_assoc()){
						?>
						<option value="<?=$hasil['aset_id']?>"><?=$vigenere->decifratura($hasil['model'])?></option>
						<?php
								}
							}
						?>
						</select> 
				<?php
					}
				?>
			</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" onclick="assign()">Assign to Aset</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<?php include("footer.php"); ?> 

<script>
	function openAssign(){
		$("#modal-assign").modal();
	}

	var count_lisensi = parseInt($("#count_lisensi").text());
	var banyak_lisensi = parseInt($("#banyak_lisensi").text());
	if(count_lisensi >= banyak_lisensi){
		$("#assign_aset").attr("disabled", true);
	}
	function assign() {
    $.ajax({
      method: "POST",
      url: "process.php?action=assign_lisensi",
      data: {
       id_lisensi :$("#id_lisensi").val(),
       aset_id :$("#aset_id").val()
      },
      success: function(res) {
        if (res == "success") {
          Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'Berhasil assign Lisensi to Aset.',
            showConfirmButton: false,
            timer: 1500
          }).then((result) => {
            if (result.dismiss === Swal.DismissReason.timer) {
              location.reload();
            }
          })
        }else{
          Swal.fire(
            'Error!',
            'Gagal menambahkan data lisensi.',
            'error'
          )
        }
      }
    })
  }
  function hapusAssignOnLicense(id) {
    Swal.fire({
      title: 'Hapus Aset?',
      text: "Apakah Anda yakin ingin menghapus aset dari lisensi ini?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          method: "POST",
          url: "process.php?action=hapus_assign_lisensi",
          data: {
            aset_id: id
          },
          success: function(res) {
            if (res == "success") {
              Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Berhasil menghapus data aset dari lisensi.',
                showConfirmButton: false,
                timer: 1000
              }).then((result) => {
                if (result.dismiss === Swal.DismissReason.timer) {
                  //console.log('I was closed by the timer')
                  location.reload();
                }
              })
            }else{
              Swal.fire(
                'Error!',
                'Gagal menghapus data aset.',
                'error'
              )
            }
          }
        })
        
      }
    })
	}
	
	function hapusAssignOnAset(id) {
    Swal.fire({
      title: 'Hapus Lisensi?',
      text: "Apakah Anda yakin ingin menghapus lisensi dari aset ini?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          method: "POST",
          url: "process.php?action=hapus_assign_aset",
          data: {
            aset_id: id
          },
          success: function(res) {
            if (res == "success") {
              Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Berhasil menghapus lisensi dari aset.',
                showConfirmButton: false,
                timer: 1000
              }).then((result) => {
                if (result.dismiss === Swal.DismissReason.timer) {
                  //console.log('I was closed by the timer')
                  location.reload();
                }
              })
            }else{
              Swal.fire(
                'Error!',
                'Gagal menghapus data aset.',
                'error'
              )
            }
          }
        })
      }
    })
  }

</script>