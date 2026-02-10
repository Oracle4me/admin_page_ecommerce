<!DOCTYPE html>
<html lang="en">
@include('admin.layouts.partials.head')

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">
        <div class="header-border"></div>
        {{-- Start Header --}}
        @include('admin.layouts.partials.header')
        {{-- End Header --}}
        {{-- Start Left Sidebar --}}
        @include('admin.layouts.partials.sidebar')
        {{-- End Left Sidebar --}}
        <!-- Start right Content here -->
        @yield('content')
        <!-- end main content-->
    </div>
    <!-- Overlay-->
    <div class="menu-overlay"></div>
    @include('admin.layouts.partials.script')
    @stack('scripts')
    <!-- Livewire Scripts -->
</body>

</html>
