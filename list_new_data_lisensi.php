<?php

  require_once('vigenere.php');
  include("header.php");
  $menu = "dataLisensi";
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Lisensi
      <button class="btn btn-primary" style="float: right;" id="openAddModal">Tambah Lisensi</button>
    </h1>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <!-- /.box-header -->
          <div class="box-body">
            <table id="table-lisensi" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th style="width: 10px">No</th>
                  <th>Nama Lisensi</th>
                  <th>Kategori Lisensi</th>
                  <th>Serial Number</th>
                  <th>Banyak Lisensi</th>
                  <th>Status</th>
                  <th>Action</th>
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
                          lisensi.id_lisensi,
                          lisensi.nama_lisensi,
                          lisensi.serialnumber,
                          lisensi.kategori_lisensi,
                          lisensi.status,
                          lisensi.banyak_lisensi,
                          lisensi.lisensi_input_date,
                          kategori_lisensi.nama_kategori_lisensi,
                          stat.nama_status
                          FROM
                          lisensi
                          INNER JOIN kategori_lisensi ON lisensi.kategori_lisensi = kategori_lisensi.id_kategori_lisensi
                          INNER JOIN stat ON lisensi.status = stat.id_status";
                  $no = 0;
                  if(!$result = $conn->query($sql)){
                    die ( 'Error ON QUERY ! ['.$conn->error.']');
                  }
                  if($status_cipher['status'] == 0){
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
                      $no = $no + 1;
                      $nama_lisensi = ucwords(strtolower($vigenere->decifratura($hasil['nama_lisensi'])));
                      $nama_kategori_lisensi = $hasil['nama_kategori_lisensi'];
                      $serialnumber = $vigenere->decifratura($hasil['serialnumber']);
                      $banyak_lisensi = $hasil['banyak_lisensi'];
                      $nama_status = $hasil['nama_status'];
                ?>
                  <tr>
                    <td><?php echo $no; ?></td>
                    <td><?php echo $nama_lisensi ?></td>
                    <td><?php echo $nama_kategori_lisensi ?></td>
                    <td><?php echo $serialnumber ?></td>
                    <td><?php echo $banyak_lisensi ?></td>
                    <td><?php echo $nama_status ?></td>
                    <td>
                      <input type="hidden" value="<?=$hasil['id_lisensi'] ?>" class="data_id">
                      <button class="btn btn-light btn-summary" onclick="passData(<?= $hasil['id_lisensi'] ?>)"><i class="fa fa-eye"></i></button>
                      <button class="btn btn-primary" onclick="getData(<?php echo $hasil['id_lisensi']; ?>)"><i class="fa fa-pencil"></i></button>
                      <?php 
          if($role != 1){
          ?><button class="btn btn-danger" onclick="hapus(<?php echo $hasil['id_lisensi']; ?>)"><i class="fa fa-close"></i></button><?php }
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
<!-- /.Add Form -->
<div class="modal fade" id="modal-default">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Tambah Lisensi</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label>Nama Lisensi</label>
          <input type="text" id="nama_lisensi" name="nama_lisensi" class="form-control">
        </div>
        <div class="form-group">
          <label>Serial Number</label>
          <input type="text" id="serialnumber" name="serialnumber" class="form-control">
        </div>
        <div class="form-group">
          <label>Banyak Lisensi</label>
          <input type="text" id="banyak_lisensi" name="banyak_lisensi" class="form-control">
        </div>
        <div class="form-group">
          <label>Kategori Lisensi</label>
          <select id="kategori_lisensi" name="kategori_lisensi" class="form-control select2" style="width: 100%;">
            <?php 
              $sql = "SELECT * FROM kategori_lisensi";
              $result = $conn->query($sql);
              while ($hasil = $result->fetch_assoc()) {
            ?>
            <option value="<?php echo $hasil['id_kategori_lisensi'] ?>"><?php echo $hasil['nama_kategori_lisensi']; ?></option>
            <?php } ?>
          </select>
        </div>
        <div class="form-group">
              <label>Status</label>
              <select id="status" class="form-control select2" style="width: 100%">
                <?php 
                  $sql = "SELECT * FROM stat";
                  $result = $conn->query($sql);
                  $no = 0;
                  while ($hasil = $result->fetch_assoc()) {
                    ?>
                    <option value="<?php echo $hasil['id_status']; ?>"><?php echo $hasil['nama_status']; ?></option>
                    <?php
                  }
                 ?>
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
<div class="modal fade" id="modal-default-edit">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Edit Lisensi</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label>Nama Lisensi</label>
          <input type="hidden" id="id_lisensi_edit" name="id_lisensi_edit" class="form-control">
          <input type="text" id="nama_lisensi_edit" name="nama_lisensi_edit" class="form-control">
        </div>
        <div class="form-group">
          <label>Serial Number</label>
          <input type="text" id="serialnumber_edit" name="serialnumber_edit" class="form-control">
        </div>
        <div class="form-group">
          <label>Banyak Lisensi</label>
          <input type="text" id="banyak_lisensi_edit" name="banyak_lisensi_edit" class="form-control">
        </div>
        <div class="form-group">
          <label>Kategori Lisensi</label>
          <select id="kategori_lisensi_edit" name="kategori_lisensi_edit" class="form-control select2" style="width: 100%;">
            <?php 
              $sql = "SELECT * FROM kategori_lisensi";
              $result = $conn->query($sql);
              while ($hasil = $result->fetch_assoc()) {
            ?>
            <option value="<?php echo $hasil['id_kategori_lisensi'] ?>"><?php echo $hasil['nama_kategori_lisensi']; ?></option>
            <?php } ?>
          </select>
        </div>
        <div class="form-group">
              <label>Status</label>
              <select id="status_edit" class="form-control select2" style="width: 100%">
                <?php 
                  $sql = "SELECT * FROM stat";
                  $result = $conn->query($sql);
                  $no = 0;
                  while ($hasil = $result->fetch_assoc()) {
                    ?>
                    <option value="<?php echo $hasil['id_status']; ?>"><?php echo $hasil['nama_status']; ?></option>
                    <?php
                  }
                 ?>
              </select>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" onclick="edit()">Simpan</button>
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
<?php include("footer.php"); ?>

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
    window.location = "summary.php?data=lisensi&id="+id;
  }

  function getData(id) {
    console.log(id);
    $.ajax({
      method: "GET",
      url: "data.php?data=lisensi",
      data: {
        id_lisensi: id
      },
      success: function(res) {
        var obj = JSON.parse(res);
        obj = obj['0'];
        console.log(obj);
        $("#id_lisensi_edit").val(obj.id_lisensi);
        $("#nama_lisensi_edit").val(obj.nama_lisensi);
        $("#kategori_lisensi_edit").val(obj.kategori_lisensi);
        $("#status_edit").val(obj.status);
        $("#serialnumber_edit").val(obj.serialnumber);
        $("#banyak_lisensi_edit").val(obj.banyak_lisensi);
        $("#modal-default-edit").modal();
      }
    })
  }

  function tambah() {
    $.ajax({
      method: "POST",
      url: "process.php?action=tambah_lisensi",
      data: {
       nama_lisensi :$("#nama_lisensi").val(),
       kategori_lisensi: $("#kategori_lisensi").val(),
       serialnumber :$("#serialnumber").val(),
       banyak_lisensi :$("#banyak_lisensi").val(),
       status :$("#status").val()
      },
      success: function(res) {
        if (res == "success") {
          Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'Berhasil menambahkan data lisensi.',
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

  function edit() {
    Swal.fire({
      title: 'Edit Lisensi?',
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
          url: "process.php?action=edit_lisensi",
          data: {
            id_lisensi: $("#id_lisensi_edit").val(),
            nama_lisensi: $("#nama_lisensi_edit").val(),
            kategori_lisensi: $("#kategori_lisensi_edit").val(),
            status: $("#status_edit").val(),
            serialnumber: $("#serialnumber_edit").val(),
            banyak_lisensi: $("#banyak_lisensi_edit").val()
          },
          success: function(res) {
            if (res == "success") {
              Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Berhasil merubah data lisensi.',
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
                'Gagal merubah data lisensi.',
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
      title: 'Hapus Lisensi?',
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
          url: "process.php?action=hapus_lisensi",
          data: {
            id_lisensi: id
          },
          success: function(res) {
            if (res == "success") {
              Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Berhasil menghapus data lisensi.',
                showConfirmButton: false,
                timer: 1500
              }).then((result) => {
                if (result.dismiss === Swal.DismissReason.timer) {
                  //console.log('I was closed by the timer')
                  location.reload();
                }
              })
            }else{
              Swal.fire(
                'Error!',
                'Gagal menghapus data lisensi.',
                'error'
              )
            }
          }
        })
        
      }
    })
  }
</script>