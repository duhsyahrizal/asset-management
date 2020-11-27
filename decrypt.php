<?php

  require_once('vigenere.php');
  include("header.php");

  $vigenere = new Vigenere($chiave);
  // create condition for encrypt/decrypt
  // $id_user = $_SESSION['id_user'];
  // $query_status_cipher = "SELECT `status` from status_cipher WHERE `user_id` = $id_user";
  // $response = $conn->query($query_status_cipher);
  // $status_cipher = $response->fetch_assoc();

  // if($status_cipher['status'] == 1){
  //   $truncateAset = "TRUNCATE TABLE aset";
  //   $conn->query($truncateAset);
  // }
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Decrypt Vigenere Chiper
    </h1>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-4">
        <div class="box box-primary">
          <!-- /.box-header -->
          <div class="box-body">
            <div class="form-group">
              <label>Decrypt Key</label>
              <input type="text" id="key" name="key" class="form-control">
            </div>
            <div class="form-group" style="float: right;">
              <button type="button" id="button-decrypt" class="btn btn-danger" onclick="check()">Decrypt</button>
            </div>
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

<script>
  $(document).ready(function(){
    $("#openAddModal").click(function(){
      $("#modal-default").modal();
    });
  });
  $("#key").on('keyup', function (e) {
    if (e.key === 'Enter' || e.keyCode === 13) {
      $("#button-decrypt").click();   
    }
  });

  function check() {
    $.ajax({
      method: "POST",
      url: "data.php?data=vigenere",
      data: {
        vigenere_key: $("#key").val()
      },
      success: function(res){
        if (res == "success") {
          Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'Berhasil decrypt semua data.',
            showConfirmButton: false,
            timer: 1500
          }).then((result) => {
            if (result.dismiss === Swal.DismissReason.timer) {
              window.location.href = "home.php";
            }
          })
        }else{
          Swal.fire(
            'Error!',
            'Gagal decrypt data.',
            'error'
          )
        }
      }
    });
  }
</script>