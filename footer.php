  <footer class="main-footer">
    <!-- <div class="pull-right hidden-xs">
      <b>Version</b> 2.4.0
    </div>
    <strong>Copyright &copy; 2014-2016 <a href="https://adminlte.io">Almsaeed Studio</a>.</strong> All rights
    reserved. -->
  </footer>
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="addon/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="addon/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="addon/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="addon/bower_components/Buttons-1.6.4/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="addon/bower_components/Buttons-1.6.4/js/buttons.bootstrap.min.js"></script>
<script type="text/javascript" src="addon/bower_components/Buttons-1.6.4/js/buttons.bootstrap4.min.js"></script>
<script type="text/javascript" src="addon/bower_components/Buttons-1.6.4/js/buttons.print.min.js"></script>
<script type="text/javascript" src="addon/bower_components/Buttons-1.6.4/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="addon/bower_components/Buttons-1.6.4/js/buttons.colVis.min.js"></script>
<script type="text/javascript" src="addon/bower_components/Buttons-1.6.4/js/buttons.html5.min.js"></script>
<script src="addon/bower_components/Buttons-1.6.4/js/pdfmake.min.js"></script>
<script src="addon/bower_components/Buttons-1.6.4/js/vfs_fonts.js"></script>

<script src="addon/dist/sweetalert/dist/sweetalert2.min.js"></script>

  <!-- Donut Chart -->
  <script src="addon/bower_components/chart.js/Chart.min.js."></script>

<script src="addon/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- Select2 -->
<script src="addon/bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- InputMask -->
<script src="addon/plugins/input-mask/jquery.inputmask.js"></script>
<script src="addon/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="addon/plugins/input-mask/jquery.inputmask.extensions.js"></script>
<!-- date-range-picker -->
<script src="addon/bower_components/moment/min/moment.min.js"></script>
<script src="addon/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- bootstrap datepicker -->
<script src="addon/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- bootstrap color picker -->
<script src="addon/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
<!-- bootstrap time picker -->
<script src="addon/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<!-- SlimScroll -->
<script src="addon/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- iCheck 1.0.1 -->
<script src="addon/plugins/iCheck/icheck.min.js"></script>
<!-- FastClick -->
<script src="addon/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="addon/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="addon/dist/js/demo.js"></script>
<!-- Page script -->

<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({ timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A' })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )
    /** add active class and stay opened when selected */
    var url = window.location;

    // for sidebar menu entirely but not cover treeview
    $('ul.sidebar-menu a').filter(function() {
        return this.href == url;
    }).parent().siblings().removeClass('active').end().addClass('active');

    // for treeview
    $('ul.treeview-menu a').filter(function() {
        return this.href == url;
    }).parentsUntil(".sidebar-menu > .treeview-menu").siblings().removeClass('active').end().addClass('active');

    //Date picker
    $('.datepicker').datepicker({
      autoclose: true,
      format: 'yyyy-mm-dd'
    })

    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass   : 'iradio_minimal-blue'
    })
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass   : 'iradio_minimal-red'
    })
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass   : 'iradio_flat-green'
    })

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    //Timepicker
    $('.timepicker').timepicker({
      showInputs: false
    })
  })

  $(function () {
    var status_cipher = $('#status_cipher').val();
    $('#table-aset').DataTable({
      buttons: {
        buttons: [
            { extend: 'pdf', className: 'btn btn-danger', enabled: (status_cipher == 0) ? false : true },
            { extend: 'print', className: 'btn btn-warning', enabled: (status_cipher == 0) ? false : true }
        ]
      }
    });
    $('#table-lisensi').DataTable({
      buttons: {
        buttons: [
            { extend: 'pdf', className: 'btn btn-danger', enabled: (status_cipher == 0) ? false : true},
            { extend: 'print', className: 'btn btn-warning', enabled: (status_cipher == 0) ? false : true }
        ]
      }
    });
     //-------------
      //- ASSETS PIE CHART -
      //-------------
 
    $('#table-user').DataTable({
        buttons: [
        ]
    })
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
  
  
</script>
<!-- Inisialisation Donut Chart -->
<script>
var PieData = [
	  			{
	  			  value: <?= $cLaptop->num_rows ?>,
	  			  color: "#daea11",
	  			  label: "Laptop"
	  			},
	  			  			{
	  			  value: <?= $cPc->num_rows ?>,
	  			  color: "#058e29",
	  			  label: "PC"
	  			},
	  			{
	  			  value: <?= $cAio->num_rows ?>,
	  			  color: "#ff0000",
	  			  label: "All in One",
	  			},
	  			{
	  			  value: <?= $cPrinter->num_rows ?>,
	  			  color: "#0000ff",
	  			  label: "Printer",
	  			},
	  			{
	  			  value: <?= $cRouter->num_rows ?>,
	  			  color: "#252758",
	  			  label: "Router",
	  			},
	  			{
	  			  value: <?= $cAp->num_rows ?>,
	  			  color: "#9083ca",
	  			  label: "Access Point",
	  			},
	  			{
	  			  value: <?= $cLain->num_rows ?>,
	  			  color: "#20fead",
	  			  label: "Lainnya",
	  			}
        ];
      
      var pieOptions = {
	        segmentShowStroke: true,
	        segmentStrokeColor: "#fff",
	        segmentStrokeWidth: 1,
	        percentageInnerCutout: 50,
	        animationSteps: 100,
	        animationEasing: "easeOutBounce",
	        animateRotate: true,
	        animateScale: true,
	        responsive: true,
			    maintainAspectRatio: false
	  };

	  var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
	  var pieChart = new Chart(pieChartCanvas).Doughnut(PieData, pieOptions);
</script>
</body>
</html>