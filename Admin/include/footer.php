</div>
<!-- Javascript -->
<script src="../admin-assets/bundles/libscripts.bundle.js"></script>    
<script src="../admin-assets/bundles/vendorscripts.bundle.js"></script>

<script src="../admin-assets/bundles/chartist.bundle.js"></script>
<script src="../admin-assets/bundles/datatablescripts.bundle.js"></script>
<script src="../admin-assets/bundles/knob.bundle.js"></script> <!-- Jquery Knob-->
<script src="../admin-assets/vendor/toastr/toastr.js"></script>

<script src="../admin-assets/vendor/multi-select/js/jquery.multi-select.js"></script> <!-- Multi Select Plugin Js -->
<script src="../admin-assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js"></script>
<script src="../admin-assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="../admin-assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.js"></script> <!-- Bootstrap Tags Input -->

<script src="../admin-assets/vendor/jquery-datatable/buttons/dataTables.buttons.min.js"></script>
<script src="../admin-assets/vendor/jquery-datatable/buttons/buttons.bootstrap4.min.js"></script>
<script src="../admin-assets/vendor/jquery-datatable/buttons/buttons.colVis.min.js"></script>
<script src="../admin-assets/vendor/jquery-datatable/buttons/buttons.html5.min.js"></script>
<script src="../admin-assets/vendor/jquery-datatable/buttons/buttons.print.min.js"></script>

<script src="../admin-assets/bundles/mainscripts.bundle.js"></script>
<script src="../admin-assets/js/pages/tables/jquery-datatable.js"></script>
<script src="../admin-assets/js/index.js"></script>
<script src="adminCustom.js"></script>
<script src="../admin-assets/js/pages/forms/advanced-form-elements.js"></script>
<!--<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>-->

<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
<script>
  $(document).ready(function () {

    $('#memberTable').DataTable({

        dom: 'Bfrtip',

        pageLength: 25,

        buttons: [

            {
                extend: 'copy',
                text: 'Copy'
            },

            {
                extend: 'csv',
                text: 'CSV'
            },

            {
                extend: 'excel',
                text: 'Excel'
            },

            {
                extend: 'pdf',
                text: 'PDF',
                orientation: 'landscape',
                pageSize: 'A4'
            },

            {
                extend: 'print',
                text: 'Print'
            }

        ]

    });

});
</script>