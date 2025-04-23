<script src="{{asset('admin/assets/js/jquery.min.js')}}"></script>
<script src="{{asset('admin/assets/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('admin/assets/js/metismenu.min.js')}}"></script>
<script src="{{asset('admin/assets/js/waves.js')}}"></script>
<script src="{{asset('admin/assets/js/feather.min.js')}}"></script>
<script src="{{asset('admin/assets/js/simplebar.min.js')}}"></script>
<script src="{{asset('admin/assets/js/jquery-ui.min.js')}}"></script>
<script src="{{asset('admin/assets/js/moment.js')}}"></script>
<script src="{{asset('admin/assets/plugins/daterangepicker/daterangepicker.js')}}"></script>

<script src="{{asset('admin/assets/plugins/apex-charts/apexcharts.min.js')}}"></script>
<script src="{{asset('admin/assets/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js')}}"></script>
<script src="{{asset('admin/assets/plugins/jvectormap/jquery-jvectormap-us-aea-en.js')}}"></script>
<script src="{{asset('admin/assets/pages/jquery.analytics_dashboard.init.js')}}"></script>


<!-- App js -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
 <!-- SweetAlert -->
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
<script src="{{asset('admin/assets/js/app.js')}}"></script>