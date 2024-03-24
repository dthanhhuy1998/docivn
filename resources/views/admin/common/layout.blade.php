<!DOCTYPE html>
<html>
    <head>
        @include('admin.common.head')
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            @include('admin.common.header')
            <!-- Left side column. contains the logo and sidebar -->
            @include('admin.common.sidebar')

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                @yield('content')
            </div>
            <!-- /.content-wrapper -->
            @include('admin.common.footer')

            <!-- Control Sidebar -->
            @include('admin.common.control-sidebar')
            <!-- /.control-sidebar -->
            <!-- Add the sidebar's background. This div must be placed
                immediately after the control sidebar -->
            <div class="control-sidebar-bg"></div>
        </div>
        <!-- ./wrapper -->
        @include('admin.common.foot')
        @yield('script')
    </body>
</html>