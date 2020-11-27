<?php

  include("header.php");

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Kategori Aset
      <button class="btn btn-primary" style="float: right;" id="openAddModal">Tambah Kategori Aset</button>
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
                  <th>Nama Kategori Aset</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                  $sql = "SELECT * FROM kategori_aset";
                  $result = $conn->query($sql);
                  $no = 0;
                  while ($hasil = $result->fetch_assoc()) {
                    $no = $no + 1;
                ?>
                  <tr>
                    <td><?php echo $no; ?></td>
                    <td><?php echo $hasil['nama_kategori_aset'] ?></td>
                    <td>
                      <button class="btn btn-primary" onclick="getData(<?php echo $hasil['id_kategori_aset']; ?>)"><i class="fa fa-pencil"></i></button>
                      <button class="btn btn-danger" onclick="hapus(<?php echo $hasil['id_kategori_aset']; ?>)"><i class="fa fa-close"></i></button>
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

<!-- Add Form -->
<div class="modal fade" id="modal-default">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Tambah Kategori Aset</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label>Nama Kategori Aset</label>
          <input type="text" id="nama_kategori_aset" name="nama_kategori_aset" class="form-control">
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
        <h4 class="modal-title">Edit Kategori Aset</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label>Nama Kategori Aset</label>
          <input type="text" id="nama_kategori_aset_edit" name="nama_kategori_aset" class="form-control">
          <input type="hidden" id="id_kategori_aset_edit" name="id_kategori_aset" class="form-control">
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
      url: "data.php?data=kategori_aset",
      data: {
        id_kategori_aset: id
      },
      success: function(res) {
        var obj = JSON.parse(res);
        $("#nama_kategori_aset_edit").val(obj.nama_kategori_aset);
        $("#id_kategori_aset_edit").val(obj.id_kategori_aset);
        $("#modal-default-edit").modal();
      }
    })
  }

  function tambah() {
    $.ajax({
      method: "POST",
      url: "process.php?action=tambah_kategori_aset",
      data: {
        nama_kategori_aset: $("#nama_kategori_aset").val()
      },
      success: function(res) {
        if (res == "success") {
          Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'Berhasil menambahkan data kategori aset.',
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
            'Gagal menambahkan data kategori aset.',
            'error'
          )
        }
      }
    })
  }

  function edit() {
    Swal.fire({
      title: 'Edit Kategori Aset?',
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
          url: "process.php?action=edit_kategori_aset",
          data: {
            id_kategori_aset: $("#id_kategori_aset_edit").val(),
            nama_kategori_aset: $("#nama_kategori_aset_edit").val()
          },
          success: function(res) {
            if (res == "success") {
              Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Berhasil merubah data kategori aset.',
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
                'Gagal merubah data kategori aset.',
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
      title: 'Hapus Kategori Aset?',
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
          url: "process.php?action=hapus_kategori_aset",
          data: {
            id_kategori_aset: id
          },
          success: function(res) {
            if (res == "success") {
              Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Berhasil menghapus data kategori aset.',
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
                'Gagal menghapus data kategori aset.',
                'error'
              )
            }
          }
        })
        
      }
    })
  }
</script>