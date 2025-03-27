 <!-- Main Footer -->
 
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->

  <!-- jQuery (must load first) -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<!-- Bootstrap -->
<script src="../../vendor/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="../../vendor/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="../../vendor/dist/js/adminlte.js"></script>

<!-- OPTIONAL SCRIPTS -->
<!-- <script src="dist/js/demo.js"></script> -->

<!-- PAGE PLUGINS -->
<script src="../../vendor/plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="../../vendor/plugins/raphael/raphael.min.js"></script>
<script src="../../vendor/plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="../../vendor/plugins/jquery-mapael/maps/usa_states.min.js"></script>
<!-- ChartJS -->
<script src="../../vendor/plugins/chart.js/Chart.min.js"></script>
<!-- datepicker js  -->
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script>
          // preloader
    
    function onReady(callback) {
    var intervalID = window.setInterval(checkReady, 1000);
    function checkReady() {
        if (document.getElementsByTagName('body')[0] !== undefined) {
            window.clearInterval(intervalID);
            callback.call(this);
        }
    }
}

function show(id, value) {
    document.getElementById(id).style.display = value ? 'block' : 'none';
}

onReady(function () {
    show('page', true);
    show('loading', false);
});

      </script>
<!-- select 2 js  -->
<script src="../../vendor/plugins/select2/js/select2.min.js"></script>
<!-- PAGE SCRIPTS -->
<!-- <script src="../vendor/dist/js/pages/dashboard2.js"></script> -->
<!-- <script src="../vendor/assets/js/custom.js"></script>
<script src="../vendor/assets/js/ajax_req.js"></script>
<script src="../vendor/assets/js/buy_product.js"></script> -->



<script>
  $(document).ready(function(){
    $('.dropdown-submenu a.test').on("click", function(e){
      $(this).next('ul').toggle();
      e.stopPropagation();
      e.preventDefault();
    });
  });
</script>
<script>
   $(document).ready(function($) {
     $('.select2').select2();
   });
</script>

<!-- datepicker -->
<script>
 $('.datepicker').datepicker();
</script>
<script>
  $(document).ready(function () {
    $('#data').DataTable({
      "paging": true,
      "searching": true,
      "ordering": true,
      "info": true
    });
  });
</script>


</body>
</html>
