<div class="sidenav-overlay"></div>
<div class="drag-target"></div>

<!-- BEGIN: Footer-->
<footer class="footer footer-static footer-light">
    <p class="clearfix mb-0"><span class="float-md-start d-block d-md-inline-block mt-25">COPYRIGHT &copy; <?php echo date('Y'); ?><a class="ms-25" href="<?php echo base_url('about') ?>" target="_blank">DIDI RASIDI</a><span class="d-none d-sm-inline-block">, All rights Reserved</span></span><span class="float-md-end d-none d-md-block">Hand-crafted & Made with<i data-feather="heart"></i></span></p>
</footer>
<button class="btn btn-primary btn-icon scroll-top" type="button"><i data-feather="arrow-up"></i></button>
<!-- END: Footer-->

<!-- BEGIN: Vendor JS-->
<script src="<?php echo base_url(); ?>app-assets/vendors/js/vendors.min.js"></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Page Vendor JS-->
<!-- <script src="<?php echo base_url(); ?>app-assets/vendors/js/charts/apexcharts.min.js"></script> -->
<script src="<?php echo base_url(); ?>app-assets/vendors/js/extensions/toastr.min.js"></script>
<script src="<?php echo base_url(); ?>app-assets/vendors/js/extensions/moment.min.js"></script>
<script src="<?php echo base_url(); ?>app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>app-assets/vendors/js/tables/datatable/datatables.buttons.min.js"></script>
<script src="<?php echo base_url(); ?>app-assets/vendors/js/tables/datatable/dataTables.bootstrap5.min.js"></script>
<script src="<?php echo base_url(); ?>app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url(); ?>app-assets/vendors/js/tables/datatable/responsive.bootstrap5.js"></script>
<script src="<?php echo base_url(); ?>app-assets/vendors/js/maps/leaflet.min.js"></script>
<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="<?php echo base_url(); ?>app-assets/js/core/app-menu.js"></script>
<script src="<?php echo base_url(); ?>app-assets/js/core/app.js"></script>
<!-- END: Theme JS-->

<!-- BEGIN: Page JS-->
<!-- <script src="<?php echo base_url(); ?>app-assets/js/scripts/pages/dashboard-analytics.js"></script> -->
<script src="<?php echo base_url(); ?>app-assets/js/scripts/pages/app-invoice-list.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
<script src="<?php echo base_url(); ?>fontawesome/js/all.min.js"></script>
<script src="<?php echo base_url(); ?>app-assets/js/scripts/maps/map-leaflet.js"></script>
<!-- END: Page JS-->

<script>
    $(window).on('load', function() {
        if (feather) {
            feather.replace({
                width: 14,
                height: 14
            });
        }
    })
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#table').DataTable({
            responsive: true,
        });
        $('#dataTable').DataTable({
            responsive: true,
            dom: 'Bfrtip',
            buttons: [{
                extend: 'excel',
                className: 'btn-success'
            }]
        });
    })
</script>
<script>
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
</body>
<!-- END: Body-->

</html>