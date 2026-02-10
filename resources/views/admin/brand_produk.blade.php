@extends('admin.layouts.partials.app')
@section('content')
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-flex align-items-center justify-content-between">
                            <h4 class="mb-0 font-size-18">Brand Produk</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Pages</a></li>
                                    <li class="breadcrumb-item active">Brand</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex mb-2">
                                    <button type="button" class="btn btn-primary waves-effect waves-light "
                                        data-toggle="modal" data-target="#modalTambah">
                                        Tambah Brand
                                    </button>
                                </div>

                                <!-- Modal -->
                                <div class="modal fade" id="modalTambah" tabindex="-1" role="dialog"
                                    aria-labelledby="modalTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalTitle">Brand
                                                </h5>
                                                <button type="button" class="close waves-effect waves-light"
                                                    data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form id="formTambah">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="nama">Nama</label>
                                                        <input name="nama" type="text" id="nama"
                                                            class="form-control" placeholder="example: 'Jordan'" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="logo">Logo</label>
                                                        <input name="logo" type="text" id="logo"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary waves-effect waves-light"
                                                        id="saveTambahBtn">Simpan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table id="dataTable" class="table table-striped w-100">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Logo</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>

                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div> <!-- end card body-->
                        </div> <!-- end card -->
                    </div><!-- end col-->
                </div>

                <!-- Edit Modal -->
                <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel">Edit Data</h5>
                                <button type="button" class="close waves-effect waves-light" data-dismiss="modal"
                                    aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label>Nama</label>
                                    <input type="text" class="form-control" id="editNama">
                                </div>
                                <div class="mb-3">
                                    <label>Logo</label>
                                    <input type="text" class="form-control" id="editLogo">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                <button type="button" class="btn btn-primary" id="saveEditBtn">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>


            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
        @include('admin.layouts.partials.footer')
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('admin/js/base_ajax.js') }}"></script>
    <script src="{{ asset('admin/js/badge_action.js') }}"></script>
    <script src="{{ asset('admin/js/datatable/base-datatables.js') }}"></script>
    <script>
        const urlEdit = "{{ url('/admin/brand/edit') }}";
        const urlDelete = "{{ url('/admin/brand/delete') }}";

        // View DataTable
        $(document).ready(function() {
            var table = initDataTable('#dataTable', {
                ajax: {
                    url: "{{ route('brand.view') }}",
                    dataSrc: function(json) {
                        console.log(json);
                        return json.data;
                    }
                },
                columns: [{
                        data: null,
                        width: '60px',
                        render: function(data, type, row, meta) {
                            return meta.row + 1;
                        },
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'nama'
                    },
                    {
                        data: 'logo'
                    },
                    {
                        data: null,
                        width: '120px',
                        render: function(data, type, row) {
                            return `
                        <button class="btn btn-sm btn-primary btn-edit">Edit</button>
                        <button class="btn btn-sm btn-danger btn-delete">Hapus</button>
                    `;
                        },
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            badgeAction('#tags-input', '#tags-container', '#tags-hidden');

            // Store Brand
            $('#saveTambahBtn').on('click', function() {
                let url = "{{ route('brand.store') }}";

                let nama = $('#nama').val();
                let logo = $('#logo').val();

                ajaxRequest(
                    url,
                    'POST', {
                        nama,
                        logo
                    }, {
                        reload: '#dataTable',
                        successMessage: "Brand berhasil ditambahkan!",
                    }
                );
                $('#modalTambah').modal('hide')
            });

            // Edit button
            $('#dataTable').on('click', '.btn-edit', function() {
                var rowData = table.row($(this).closest('tr')).data();
                $('#editNama').val(rowData.nama);
                $('#editLogo').val(rowData.logo);
                $('#saveEditBtn').off('click').on('click', function() {
                    let url = "{{ route('brand.update', ':id') }}".replace(':id', rowData.id);


                    let nama = $('#editNama').val();
                    let deskripsi = $('#editLogo').val();
                    ajaxRequest(
                        url,
                        'PUT', {
                            nama,
                            deskripsi,
                        }, {
                            reload: '#dataTable',
                            successMessage: "Brand berhasil diperbarui!"
                        }
                    )
                    $('#editModal').modal('hide')
                });

                $('#editModal').modal('show');
            });

            // Delete button
            $('#dataTable').on('click', '.btn-delete', function() {
                var rowData = table.row($(this).closest('tr')).data();
                Swal.fire({
                    title: 'Apakah yakin?',
                    text: 'Anda tidak dapat mengembalikannya!',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.value) {
                        let url = "{{ route('brand.destroy', ':id') }}".replace(':id', rowData
                            .id);
                        ajaxRequest(
                            url,
                            'DELETE', {}, {
                                reload: '#dataTable',
                                successMessage: "Brand berhasil dihapus!"
                            }
                        )
                    }
                });
            });
        });
    </script>
@endpush
