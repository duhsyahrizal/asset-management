<?php

  include("header.php");
  require_once('vigenere.php');

  $vigenere = new Vigenere($chiave);

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Cetak Laporan Aset
    </h1>
  </section>

  <!-- Main content -->
  <section class="content">
      <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
              <div class="box-body">
                <div id="input-by-date-aset">
                  <form method="post" action="data_laporan.php">
                    <input type="hidden" name="data" value="tanggal">
                    <div class="form-group">
                      <label>Tanggal Awal</label>
                      <input type="text" name="tgl_awal" class="form-control datepicker" autocomplete="off">
                    </div>
                    <div class="form-group">
                      <label>Tanggal Akhir</label>
                      <input type="text" name="tgl_akhir" class="form-control datepicker" autocomplete="off">
                    </div>
                    <div class="form-group" style="float: right;">
                      <button type="submit" class="btn btn-primary"><i class="fa fa-print"></i> Cetak Laporan</button>
                    </div>
                  </form>
                  
                </div>
              </div>
              
            </div>
          </div>
          <div class="row">
        <div class="col-md-5">
            <div class="box box-primary">
              <div class="box-body">
                <div id="input-by-nik">
                <div class="form-group">
                <form method="post" action="data_laporan.php">
                <input type="hidden" name="data" value="nik">
                      <label for="nik">Filter By NIK </label>
                      <select id="nik" name="nik" class="form-control select2" style="width: 100%;">
                      <?php 
                        $sql = "SELECT * FROM aset";
                        $result = $conn->query($sql);
                        while ($hasil = $result->fetch_assoc()) {
                          $nik = $vigenere->decifratura($hasil['nik']);

                      ?>
                      <option value="<?php echo $hasil['nik'] ?>"><?= $nik ?></option>
                      <?php } ?>
                      </select>
                    </div>
                    <div class="form-group" style="float: right;">
                      <button type="submit" class="btn btn-primary"><i class="fa fa-print"></i> Cetak Laporan</button>
                    </div>
                  </form>
                </div>
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


  // function getDataReport() {
  //   $.ajax({
  //     method: "POST",
  //     url: "data.php?data=vigenere",
  //     data: {
  //       vigenere_password: $("#vigenere_password").val(),
  //       vigenere_key: $("#vigenere_key").val()
  //     },
  //     success: function(res) {
  //       console.log(res);
  //       $("#password").val(res);
  //     }
  //   })
  // }
</script>