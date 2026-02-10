<!-- jQuery  -->
<script src="{{ asset('admin/js/jquery.min.js') }}"></script>
<script src="{{ asset('admin/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('admin/js/metismenu.min.js') }}"></script>
<script src="{{ asset('admin/js/waves.js') }}"></script>
<script src="{{ asset('admin/js/simplebar.min.js') }}"></script>
<!-- Sparkline Js-->
<script src="{{ asset('admin/plugins/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
<!-- Chart Js-->
<script src="{{ asset('admin/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<!-- Chart Custom Js-->
<script src="{{ asset('admin/pages/knob-chart-demo.js') }}"></script>
<!-- Morris Js-->
<script src="{{ asset('admin/plugins/morris-js/morris.min.js') }}"></script>
<!-- Raphael Js-->
<script src="{{ asset('admin/plugins/raphael/raphael.min.js') }}"></script>
<!-- Custom Js -->
<script src="{{ asset('admin/pages/dashboard-demo.js') }}"></script>

{{-- Data Tables --}}
<script src="{{ asset('admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>

<script src="{{ asset('admin/plugins/datatables/dataTables.bootstrap4.js') }}"></script>

<script src="{{ asset('admin/plugins/datatables/dataTables.responsive.min.js') }}"></script>

<script src="{{ asset('admin/plugins/datatables/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('admin/plugins/datatables/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('admin/plugins/datatables/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('admin/plugins/datatables/buttons.html5.min.js') }}"></script>
<script src="{{ asset('admin/plugins/datatables/buttons.flash.min.js') }}"></script>
<script src="{{ asset('admin/plugins/datatables/buttons.print.min.js') }}"></script>
<script src="{{ asset('admin/plugins/datatables/dataTables.keyTable.min.js') }}"></script>
<script src="{{ asset('admin/plugins/datatables/dataTables.select.min.js') }}"></script>
<script src="{{ asset('admin/plugins/datatables/pdfmake.min.js') }}"></script>
<script src="{{ asset('admin/plugins/datatables/vfs_fonts.js') }}"></script>
{{-- <script src="{{ asset('admin/pages/datatables-demo.js') }}"></script> --}}

<!--dropify-->
<script src="{{ asset('admin/plugins/dropify/dropify.min.js') }}"></script>

<!-- Init js-->
<script src="{{ asset('admin/pages/fileuploads-demo.js') }}"></script>

<!-- Sweet Alerts Js-->
<script src="{{ asset('admin/plugins/sweetalert2/sweetalert2.min.js') }}"></script>

<!-- Sweet Alerts Js-->
<script src="{{ asset('admin/pages/sweet-alert-demo.js') }}"></script>


<!-- App js -->
<script src="{{ asset('admin/js/theme.js') }}"></script>

<script>
    function logout() {
        const token = localStorage.getItem("token");

        let url = "{{ route('admin.logout') }}";
        ajaxRequest(url, 'POST', {}, {
            silent: true,
            headers: {
                'Authorization': 'Bearer ' + token
            }
        }, {
            onSuccess: function(res) {
                Swal.fire({
                    type: 'success',
                    title: 'Berhasil',
                    text: res.success || 'Logout berhasil!',
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = res.redirect_to || '/login';
                });
            },
            onError: function(xhr) {
                Swal.fire({
                    type: 'error',
                    title: 'Gagal',
                    text: xhr.responseJSON?.message || 'Login gagal'
                });
                btn.prop('disabled', false).text('Log In');
            }
        });
    }
</script>
