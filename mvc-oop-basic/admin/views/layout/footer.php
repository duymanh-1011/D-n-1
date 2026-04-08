<footer class="main-footer">
  <div class="float-right d-none d-sm-block">
    By <b>ORVANI</b>
  </div>
  <strong>Website bán quần áo ORVANI</strong>
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="./assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="./assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="./assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="./assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="./assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="./assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="./assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="./assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="./assets/plugins/jszip/jszip.min.js"></script>
<script src="./assets/plugins/pdfmake/pdfmake.min.js"></script>
<script src="./assets/plugins/pdfmake/vfs_fonts.js"></script>
<script src="./assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="./assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="./assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- ChartJS -->
<script src="./assets/plugins/chart.js/Chart.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="./assets/dist/js/adminlte.min.js"></script>
<?php if (isset($pageScript) && $pageScript === 'dashboard3') : ?>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    var visitorsCtx = document.getElementById('visitors-chart');
    if (visitorsCtx) {
      new Chart(visitorsCtx.getContext('2d'), {
        type: 'line',
        data: {
          labels: ['18th', '20th', '22nd', '24th', '26th', '28th', '30th'],
          datasets: [{
            label: 'This Week',
            backgroundColor: 'rgba(60,141,188,0.2)',
            borderColor: 'rgba(60,141,188,1)',
            pointRadius: 3,
            pointBackgroundColor: 'rgba(60,141,188,1)',
            fill: true,
            data: [100, 150, 160, 155, 170, 180, 170]
          }, {
            label: 'Last Week',
            backgroundColor: 'rgba(210,214,222,0.5)',
            borderColor: 'rgba(210,214,222,1)',
            pointRadius: 3,
            pointBackgroundColor: 'rgba(210,214,222,1)',
            fill: true,
            data: [90, 125, 140, 130, 145, 155, 160]
          }]
        },
        options: {
          maintainAspectRatio: false,
          responsive: true,
          legend: { display: false },
          scales: {
            xAxes: [{ gridLines: { display: false } }],
            yAxes: [{ gridLines: { display: false } }]
          }
        }
      });
    }

    var salesCtx = document.getElementById('sales-chart');
    if (salesCtx) {
      new Chart(salesCtx.getContext('2d'), {
        type: 'line',
        data: {
          labels: ['Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
          datasets: [{
            label: 'Sales',
            backgroundColor: 'rgba(60,141,188,0.2)',
            borderColor: 'rgba(60,141,188,1)',
            pointRadius: 3,
            pointBackgroundColor: 'rgba(60,141,188,1)',
            fill: true,
            data: [600, 1200, 1900, 1650, 1850, 1750, 2200]
          }]
        },
        options: {
          maintainAspectRatio: false,
          responsive: true,
          legend: { display: false },
          scales: {
            xAxes: [{ gridLines: { display: false } }],
            yAxes: [{ gridLines: { display: false } }]
          }
        }
      });
    }
  });
</script>
<?php endif; ?>
<!-- (Removed demo script to suppress demo alert message) -->
<!-- script src="./assets/dist/js/demo.js"></script -->