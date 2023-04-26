<!DOCTYPE html>
<html lang="en">

@include('layouts.dash-components.head')

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        {{-- @include('layouts.dash-components.navbar') --}}

        <!-- Main Sidebar Container -->
        @role('admin')
            @include('layouts.nagivations.admin')
        @endrole
        @role('pharmacy')
            @include('layouts.nagivations.pharmacy')
        @endrole
        @role('doctor')
            @include('layouts.nagivations.doctor')
        @endrole
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            {{-- @include('layouts.dash-components.content-header') --}}
            @yield('content')

        </div>
        <!-- /.content-wrapper -->

        {{-- @include('layouts.dash-components.footer') --}}
    </div>

    <!-- REQUIRED SCRIPTS -->
    @include('layouts.dash-components.sourcejs')
    @yield('scripts')
</body>

</html>
