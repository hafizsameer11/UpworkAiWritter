<!DOCTYPE html>
<html lang="en">
@include('admin.components.head')

<body class="dark-sidenav">
    <!-- Left Sidenav -->
    @include('admin.components.sidebar')
    <!-- end left-sidenav-->


    <div class="page-wrapper">
        @include('admin.components.topbar')

        <!-- Page Content-->
        <div class="page-content">
            <div class="container py-4">
                @yield('adminMain')
            </div><!-- container -->

            @include('admin.components.footer')
        </div>
        <!-- end page content -->
    </div>
    <!-- end page-wrapper -->




    <!-- jQuery  -->
    @include('admin.components.script')
    @yield('adminScript')
</body>

</html>