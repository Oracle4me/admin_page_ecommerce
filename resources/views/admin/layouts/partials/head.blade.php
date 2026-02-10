<head>
    <meta charset="utf-8" />
    <title>{{ $title ?? 'Admin Page' }} </title>

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="{{ $description ?? 'Halaman Admin' }}" name="description" />
    <meta content="MyraStudio" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />


    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('admin/images/favicon.ico') }}">

    <!-- Dropify css -->
    <link href="{{ asset('admin/plugins/dropify/dropify.min.css') }}" rel="stylesheet" type="text/css" />

    {{-- Datatables css --}}
    <link href="{{ asset('admin/plugins/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/plugins/datatables/responsive.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/plugins/datatables/buttons.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/plugins/datatables/select.bootstrap4.css') }}" rel="stylesheet" type="text/css" />

    <!-- Sweet Alerts css -->
    <link href="{{ asset('admin/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- App css -->
    <link href="{{ asset('admin/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/css/theme.min.css') }}" rel="stylesheet" type="text/css" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
