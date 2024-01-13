</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- footer -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- End footer -->
<!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Page wrapper  -->
<!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Wrapper -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- All Jquery -->
<!-- ============================================================== -->
<script src="/assets/libs/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
<script src="/assets/extra-libs/sparkline/sparkline.js"></script>
<!--Wave Effects -->
<script src="/dist/js/waves.js"></script>
<!--Menu sidebar -->
<script src="/dist/js/sidebarmenu.js"></script>
<!--Custom JavaScript -->
<script src="/dist/js/custom.min.js"></script>
<!--This page JavaScript -->
<!-- <script src="/dist/js/pages/dashboards/dashboard1.js"></script> -->
<!-- Charts js Files -->
<script src="/assets/libs/flot/excanvas.js"></script>
<script src="/assets/libs/flot/jquery.flot.js"></script>
<script src="/assets/libs/flot/jquery.flot.pie.js"></script>
<script src="/assets/libs/flot/jquery.flot.time.js"></script>
<script src="/assets/libs/flot/jquery.flot.stack.js"></script>
<script src="/assets/libs/flot/jquery.flot.crosshair.js"></script>
<script src="/assets/libs/flot.tooltip/js/jquery.flot.tooltip.min.js"></script>
<script src="/dist/js/pages/chart/chart-page-init.js"></script>


<script src="/assets/extra-libs/multicheck/datatable-checkbox-init.js"></script>
<script src="/assets/extra-libs/multicheck/jquery.multicheck.js"></script>
<script src="/assets/extra-libs/DataTables/datatables.min.js"></script>
<script src="/assets/libs/toastr/build/toastr.min.js"></script>

<script>
    /****************************************
     *       Basic Table                   *
     ****************************************/
    $.extend(true, $.fn.dataTable.defaults, {
        "language": {
            "sProcessing": "กำลังดำเนินการ...",
            "sLengthMenu": "แสดง_MENU_ แถว",
            "sZeroRecords": "ไม่พบข้อมูล",
            "sInfo": "แสดง _START_ ถึง _END_ จาก _TOTAL_ แถว",
            "sInfoEmpty": "แสดง 0 ถึง 0 จาก 0 แถว",
            "sInfoFiltered": "(กรองข้อมูล _MAX_ ทุกแถว)",
            "sInfoPostFix": "",
            "sSearch": "ค้นหา:",
            "sUrl": "",
            "oPaginate": {
                "sFirst": "เริ่มต้น",
                "sPrevious": "ก่อนหน้า",
                "sNext": "ถัดไป",
                "sLast": "สุดท้าย"
            }
        }
    });
    $("#zero_config").DataTable();
</script>
<!-- this page js -->

<script>
    @if (Session::has('message'))
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        Toast.fire({
            icon: 'success',
            title: "{{ session('message') }}"
        })
    @endif

    @if (Session::has('error'))
        toastr.options = {
            "closeButton": true,
            "progressBar": true
        }
        toastr.error("{{ session('error') }}");
    @endif

    @if (Session::has('info'))
        toastr.options = {
            "closeButton": true,
            "progressBar": true
        }
        toastr.info("{{ session('info') }}");
    @endif

    @if (Session::has('warning'))
        toastr.options = {
            "closeButton": true,
            "progressBar": true
        }
        toastr.warning("{{ session('warning') }}");
    @endif
</script>
</body>

</html>
