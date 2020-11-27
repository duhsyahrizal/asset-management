<?php

  require_once('vigenere.php');
  include("header.php");

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Aset
      <button class="btn btn-primary" style="float: right;" id="openAddModal">Tambah Aset</button>
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
                  <th>Divisi</th>
                  <th>Model</th>
                  <th>Serial Number</th>
                  <th>Hostname</th>
                  <th>Kategori Perangkat</th>
                  <th>Status</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                  // create condition for encrypt/decrypt
                  $id_user = $_SESSION['id_user'];
                  $query_status_cipher = "SELECT `status` from status_cipher WHERE `user_id` = $id_user";
                  $response = $conn->query($query_status_cipher);
                  $status_cipher = $response->fetch_assoc();
                  $vigenere = new Vigenere($chiave);
                  
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
                          FROM
                          aset
                          INNER JOIN kategori_aset ON aset.aset_kategori = kategori_aset.id_kategori_aset
                          INNER JOIN stat ON aset.status = stat.id_status";
                  $result = $conn->query($sql);
                  $no = 0;
                  if($status_cipher['status'] == 0){
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
                        <td>
                          <button class="btn btn-light btn-edit"><i class="fa fa-eye"></i></button>
                          <button class="btn btn-primary btn-edit"><i class="fa fa-pencil"></i></button>
                          <button class="btn btn-danger btn-delete"><i class="fa fa-close"></i></button>
                        </td>
                      </tr>
                  <?php
                    }
                  }
                  else if($status_cipher['status'] == 1){
                    while ($hasil = $result->fetch_assoc()) {
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
                      $no = $no + 1;
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
                        <td>
                          <button class="btn btn-light btn-summary" onclick="passData(<?= $hasil['aset_id'] ?>)"><i class="fa fa-eye"></i></button>
                          <button class="btn btn-primary" onclick="getData(<?= $hasil['aset_id']?>)" data-toggle="modal" data-target="#modal-default-edit" data-id="<?php echo $hasil['aset_id']; ?>"><i class="fa fa-pencil"></i></button>
                          <?php 
          if($role != 1){ ?><button class="btn btn-danger" onclick="hapus(<?php echo $hasil['aset_id']; ?>)"><i class="fa fa-close"></i></button><?php }
          else {
          }?>
                        </td>
                      </tr>
                  <?php
                    }
                  }
                  ?>
              </tbody>
            </table>
            <input type="hidden" value="<?=$status_cipher['status']?>" id="status_cipher">
          </div>
          <!-- /.box-body -->
        </div>
      </div>
    </div>
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php

          if($role != 1){
        ?>
<!-- Add Form -->
<div class="modal fade" id="modal-default">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Tambah Aset</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label>NIK</label>
          <input type="text" id="nik" name="nik" class="form-control">
        </div>
        <div class="form-group">
          <label>Nama Karyawan</label>
          <input type="text" id="nama_karyawan" name="nama_karyawan" class="form-control">
        </div>
        <div class="form-group">
          <label>Model</label>
          <input type="text" id="model" name="model" class="form-control">
        </div>
        <div class="form-group">
          <label>Serial Number</label>
          <input type="text" id="serialnumber" name="serialnumber" class="form-control">
        </div>
        <div class="form-group">
          <label>Divisi</label>
          <input type="text" id="divisi" name="divisi" class="form-control">
        </div>
        <div class="form-group">
          <label>Hostname</label>
          <input type="text" id="hostname" name="hostname" class="form-control">
        </div>
        <div class="form-group">
          <label>Kategori Aset</label>
          <select id="aset_kategori" name="aset_kategori" class="form-control select2" style="width: 100%;">
            <?php 
              $sql = "SELECT * FROM kategori_aset";
              $result = $conn->query($sql);
              while ($hasil = $result->fetch_assoc()) {
            ?>
            <option value="<?php echo $hasil['id_kategori_aset'] ?>"><?php echo $hasil['nama_kategori_aset']; ?></option>
            <?php } ?>
          </select>
        </div>
        <div class="form-group">
          <label>Status</label>
          <select id="status" name="status" class="form-control select2" style="width: 100%;">
            <?php 
              $sql = "SELECT * FROM stat";
              $result = $conn->query($sql);
              while ($hasil = $result->fetch_assoc()) {
            ?>
            <option value="<?php echo $hasil['id_status'] ?>"><?php echo $hasil['nama_status']; ?></option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" onclick="tambah()">Simpan</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<?php 
          }
          else{
          }
        ?>
<?php

          if($role != 1){
        ?>
<!-- Edit Form -->
<div class="modal fade" id="modal-default-edit">
  <div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Edit Aset</h4>
      </div>
      <div class="modal-body">
        <form method="post">
          <div class="form-group">
            <label>NIK</label>
            <input type="hidden" id="aset_id_edit" name="aset_id_edit" class="form-control">
            <input type="text" id="nik_edit" name="nik_edit" class="form-control">
          </div>
          <div class="form-group">
            <label>Nama Karyawan</label>
            <input type="text" id="nama_karyawan_edit" name="nama_karyawan_edit" class="form-control">
          </div>
          <div class="form-group">
            <label>Divisi</label>
            <input type="text" id="divisi_edit" name="divisi_edit" class="form-control">
          </div>
          <div class="form-group">
          <label>Model</label>
          <input type="text" id="model_edit" name="model_edit" class="form-control">
        </div>
          <div class="form-group">
            <label>Serial Number</label>
            <input type="text" id="serialnumber_edit" name="serialnumber_edit" class="form-control">
          </div>
          <div class="form-group">
            <label>Hostname</label>
            <input type="text" id="hostname_edit" name="aset_hostname_edit" class="form-control">
          </div>
          <div class="form-group">
            <label>Kategori Aset</label>
            <select id="kategori_edit" name="kategori_edit" class="form-control select2" style="width: 100%;">
              <?php 
                $sql = "SELECT * FROM kategori_aset";
                $result = $conn->query($sql);
                while ($hasil = $result->fetch_assoc()) {
              ?>
              <option value="<?php echo $hasil['id_kategori_aset'] ?>"><?php echo $hasil['nama_kategori_aset']; ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group">
          <label>Status</label>
          <select id="status_edit" name="status_edit" class="form-control select2" style="width: 100%;">
            <?php 
              $sql = "SELECT * FROM stat";
              $result = $conn->query($sql);
              while ($hasil = $result->fetch_assoc()) {
            ?>
            <option value="<?php echo $hasil['id_status'] ?>"><?php echo $hasil['nama_status']; ?></option>
            <?php } ?>
          </select>
        </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" onclick="edit()">Ubah</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<?php 
          }
          else{
          }
        ?> 
<?php 
  include("footer.php"); 
?>

<script>
  $(document).ready(function(){
    $("#openAddModal").click(function(){
      $("#modal-default").modal();
    });
  });

  // initalization status cipher for user
  var status_cipher = $('#status_cipher').val();
  if(status_cipher == 0){
    // disabled button for user encrypted
    $('#openAddModal').attr('disabled', true);
    $('.btn-edit').attr('disabled', true);
    $('.btn-delete').attr('disabled', true);
  }
  else{
    // enabled button for user decrypted
    $('#openAddModal').attr('disabled', false);
    $('.btn-edit').attr('disabled', false);
    $('.btn-delete').attr('disabled', false);
  }

  function passData(id){
    window.location = "summary.php?data=aset&id="+id;
  }

  function getData(id) {
    $.ajax({
      url: "data.php?data=aset",
      data: {
        aset_id: id
      },
      success: function(res) {
        var obj = JSON.parse(res);
        obj = obj['0'];
        console.log(obj);
        
        // // console.log(obj);
        $("#aset_id_edit").val(obj.aset_id);
        $("#nik_edit").val(obj.nik);
        $("#nama_karyawan_edit").val(obj.nama_karyawan);
        $("#divisi_edit").val(obj.divisi);
        $("#model_edit").val(obj.model);
        $("#serialnumber_edit").val(obj.serialnumber);
        $("#hostname_edit").val(obj.hostname);
        $("#status_edit").val(obj.status);
        $("#kategori_edit").val(obj.aset_kategori);
        $("#modal-default-edit").modal();
      }
    })
  }
    // $('.openModal').on('click', function(){
    //   var aset_id = $(this).attr('data-id');
    //   $.ajax({
    //   url: "modal_list_new_aset.php?id="+aset_id,
    //   cache:false,
    //   success: function(res) {
    //     $(".modal-content").html(res);
    //   }
    // })
    // })

  function tambah() {
    $.ajax({
      method: "POST",
      url: "process.php?action=tambah_aset",
      data: {
        nik: $("#nik").val(),
        nama_karyawan: $("#nama_karyawan").val(),
        model: $("#model").val(),
        divisi: $("#divisi").val(),
        serialnumber: $("#serialnumber").val(),
        hostname: $("#hostname").val(),
        status: $("#status").val(),
        aset_kategori: $("#aset_kategori").val()
      },
      success: function(res) {
        if (res == "success") {
          Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'Berhasil menambahkan data aset.',
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
            'Gagal menambahkan data aset.',
            'error'
          )
        }
      },
        error: function(XMLHttpRequest, textStatus, errorThrown){
        console.log(errorThrown);
        }
    })
  }

  function edit() {
    Swal.fire({
      title: 'Edit Aset?',
      text: "Apakah Anda yakin ingin merubah data ini?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, do it!'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          method: "POST",
          url: "process.php?action=edit_aset",
          data: {
            aset_id: $("#aset_id_edit").val(),
            nik: $("#nik_edit").val(),
            nama_karyawan: $("#nama_karyawan_edit").val(),
            model: $("#model_edit").val(),
            serialnumber: $("#serialnumber_edit").val(),
            divisi: $("#divisi_edit").val(),
            hostname: $("#hostname_edit").val(),
            status: $("#status_edit").val(),
            aset_kategori: $("#kategori_edit").val()
          },
          success: function(res) {
            if (res == "success") {
              Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Berhasil merubah data aset.',
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
                'Gagal merubah data aset.',
                'error'
              )
            }
          }
        })
        
      }
    })
  }

  function hapus(id) {
    Swal.fire({
      title: 'Hapus Aset?',
      text: "Apakah Anda yakin ingin menghapus data ini?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          method: "GET",
          url: "process.php?action=hapus_aset",
          data: {
            aset_id: id
          },
          success: function(res) {
            if (res == "success") {
              Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Berhasil menghapus data aset.',
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