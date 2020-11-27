<?php

  include("header.php");

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      User
      <button class="btn btn-primary" style="float: right;" id="openAddModal">Tambah User</button>
    </h1>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <!-- /.box-header -->
          <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th style="width: 10px">#</th>
                  <th>Username</th>
                  <th>Nama</th>
                  <th>Role</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                  $sql = "SELECT * FROM user";
                  $result = $conn->query($sql);
                  $no = 0;
                  while ($hasil = $result->fetch_assoc()) {
                    $no = $no + 1;
                ?>
                  <tr>
                    <td><?php echo $no; ?></td>
                    <td><?php echo $hasil['username'] ?></td>
                    <td><?php echo $hasil['nama'] ?></td>
                    <td><?php if($hasil['role'] == 1) {
                      echo "Manager"; }
                      else{
                        echo "Operator"; }?></td>
                    <td><?php if($hasil['status'] == 1) {
                      echo "Aktif"; }
                      else{
                        echo "Tidak Aktif"; }?></td>
                    <td>
                      <button class="btn btn-primary" onclick="getData(<?php echo $hasil['id_user']; ?>)"><i class="fa fa-pencil"></i></button>
                      <?php

                if($role != 0){
        ?><button class="btn btn-danger" onclick="hapus(<?php echo $hasil['id_user']; ?>)"><i class="fa fa-close"></i></button><?php 
      }
      else{
      }
    ?> 
                    </td>
                  </tr>
                <?php
                  }
                ?>
              </tbody>
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
<?php

          if($role != 0){
        ?>
<!-- Add Form -->
<div class="modal fade" id="modal-default">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Tambah User</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label>Username</label>
          <input type="text" id="username" name="username" class="form-control">
        </div>
        <div class="form-group">
          <label>Password</label>
          <input type="password" id="password" name="password" class="form-control">
        </div>
        <div class="form-group">
          <label>Nama</label>
          <input type="text" id="nama" name="nama" class="form-control">
        </div>
        <div class="form-group">
          <label>Role</label>
          <select id="role" name="role" class="form-control select2" style="width: 100%;">
            <option value="1"><?php echo "Manager"; ?></option>
            <option value="0"><?php echo "Operator"; ?></option>
          </select>        
        </div>
      <div class="form-group">
          <label>Status</label>
          <select id="status" name="status" class="form-control select2" style="width: 100%;">
            <option value="1"><?php echo "Aktif"; ?></option>
            <option value="0"><?php echo "Tidak Aktif"; ?></option>
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

<!-- Edit Form -->
<div class="modal fade" id="modal-default-edit">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Edit User</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label>Nama</label>
          <input type="text" id="nama_edit" name="nama" class="form-control">
          <input type="hidden" id="id_user_edit" name="id_user" class="form-control">
        </div>
        <div class="form-group">
          <label>Username</label>
          <input type="text" id="username_edit" name="username_edit" class="form-control">
        </div>
        <div class="form-group">
          <label>Password</label>
          <input type="password" id="password_edit" name="password_edit" class="form-control">
        </div>
        <div class="form-group">
          <label>Role</label>
          <select id="role_edit" name="role_edit" class="form-control select2" style="width: 100%;">
            <option value="1"><?php echo "Manager"; ?></option>
            <option value="0"><?php echo "Operator"; ?></option>
          </select>          </div>
        <div class="form-group">
          <label>Status</label>
          <select id="status_edit" name="status_edit" class="form-control select2" style="width: 100%;">
            <option value="1"><?php echo "Aktif"; ?></option>
            <option value="0"><?php echo "Tidak Aktif"; ?></option>
          </select>  
        </div>
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
<?php include("footer.php"); ?>

<script>
  $(document).ready(function(){
    $("#openAddModal").click(function(){
      $("#modal-default").modal();
    });
  });

  function getData(id) {
    $.ajax({
      method: "GET",
      url: "data.php?data=user",
      data: {
        id_user: id
      },
      success: function(res) {
        var obj = JSON.parse(res);
        $("#id_user_edit").val(obj.id_user);
        $("#nama_edit").val(obj.nama);
        $("#username_edit").val(obj.username);
        $("#password_edit").val(obj.password);
        $("#role_edit").val(obj.role);
        $("#status_edit").val(obj.status);
        $("#modal-default-edit").modal();
      }
    })
  }

  function tambah() {
    $.ajax({
      method: "POST",
      url: "process.php?action=tambah_user",
      data: {
        username: $("#username").val(),
        password: $("#password").val(),
        nama: $("#nama").val(),
        role: $("#role").val(),
        status: $("#status").val()
      },
      success: function(res) {
        if(res == 'success'){
          $.ajax({
            method: "POST",
            url: "process.php?action=tambah_status_user",
            data: {
              status_cipher: 0,
            },
            success: function(res) {
              if (res == "success") {
                Swal.fire({
                  position: 'center',
                  icon: 'success',
                  title: 'Berhasil menambahkan data user.',
                  showConfirmButton: false,
                  timer: 1500
                }).then((result) => {
                  if (result.dismiss === Swal.DismissReason.timer) {
                    location.reload();
                  }
                });
              }
              else{
                Swal.fire(
                  'Error!',
                  'Gagal menambahkan data user.',
                  'error'
                )
              }
            }
          });
        }else{

        }
      }
    })
  }

  function edit() {
    Swal.fire({
      title: 'Edit User?',
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
          url: "process.php?action=edit_user",
          data: {
            id_user: $("#id_user_edit").val(),
            username: $("#username_edit").val(),
            password: $("#password_edit").val(),
            nama: $("#nama_edit").val(),
            role: $("#role_edit").val(),
            status: $("#status_edit").val()
          },
          success: function(res) {
            if (res == "success") {
              Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Berhasil merubah data user.',
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
                'Gagal merubah data user.',
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
      title: 'Hapus User?',
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
          url: "process.php?action=hapus_user",
          data: {
            id_user: id
          },
          success: function(res) {
            if (res == "success") {
              Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Berhasil menghapus data user.',
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
                'Gagal menghapus data user.',
                'error'
              )
            }
          }
        })
        
      }
    })
  }
</script>