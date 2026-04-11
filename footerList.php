
  <!-- /#wrapper -->
   <!-- Scroll to Top Button-->
  Imprimé à Bukavu, le <?php  echo date("d-m-Y H:i:s"); ?>
   
   <footer class="site-footer cacheMenu">
      <div class="text-center cacheMenu">
        <p>
          &copy; Copyrights <strong>L2 ISPF/2025 </strong>. All Rights Reserved
        </p>
         
        <a href="#" class="go-top">
          <i class="fa fa-angle-up"></i>
          </a>
      </div>
    </footer>
  </body>

  <script src="./lib/bootstrap/js/bootstrap.min.js"></script>
  <script class="include" type="text/javascript" src="./../lib/jquery.dcjqaccordion.2.7.js"></script>
  <script src="./lib/jquery.scrollTo.min.js"></script>
  <script src="./lib/jquery.nicescroll.js" type="text/javascript"></script>
  <!--common script for all pages-->
  <script src="./lib/common-scripts.js"></script>
  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Page level plugin JavaScript-->
  <script src="vendor/chart.js/Chart.min.js"></script>
  <script src="vendor/datatables/jquery.dataTables.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin.min.js"></script>

  <!-- Demo scripts for this page-->
  <script src="js/demo/datatables-demo.js"></script>
  <script src="js/demo/chart-area-demo.js"></script>

  <script src="https://cdn.jsdelivr.net/gh/linways/table-to-excel@v1.0.4/dist/tableToExcel.js"></script>

 <script type="text/javascript">
    $('.print').on('click',function(){
      $(".cache").hide();
      window.print();
      if(!window.print()){  
        $('.cache').show();
      }
    });

  </script>
  