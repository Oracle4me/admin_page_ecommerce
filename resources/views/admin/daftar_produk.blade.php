@extends('admin.layouts.partials.app')
@section('content')
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-flex align-items-center justify-content-between">
                            <h4 class="mb-0 font-size-18">Daftar Produk</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
                                    <li class="breadcrumb-item active">Daftar Produk</li>
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
                                <div class="table-responsive">
                                    <table id="dataTable" class="table table-striped w-100">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No</th>
                                                <th>Produk</th>
                                                <th>Deskripsi</th>
                                                <th class="text-center">Kategori</th>
                                                <th class="text-center">Harga</th>
                                                <th class="text-center">Aksi</th>
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
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel">Edit Data</h5>
                                <button type="button" class="close waves-effect waves-light" data-dismiss="modal"
                                    aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row g-3">
                                    <div class="col-md-4 text-center">
                                        <img id="editPreviewImage" class="img-fluid mb-3" src=""
                                            style="width: 100%; height: 250px; object-fit: cover;" alt="produk_sample.jpg">
                                        <label id="imageLabel" class="form-label">Ganti Gambar</label>
                                        <input type="file" class="form-control" data-max-file-size="1M" id="editImage">
                                    </div>

                                    <div class="col-md-8">
                                        <div class="mb-3">
                                            <label>SKU</label>
                                            <input type="text" class="form-control" id="editSKU">
                                        </div>
                                        <div class="mb-3">
                                            <label>Nama</label>
                                            <input type="text" class="form-control" id="editNama">
                                        </div>
                                        <div class="mb-3">
                                            <label>Deskripsi</label>
                                            <textarea class="form-control" id="editDeskripsi"></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label>Kategori</label>
                                            <select class="form-control" id="editKategori"></select>
                                        </div>

                                        <div class="mb-3">
                                            <label>Brand</label>
                                            <select class="form-control" id="editBrand"></select>
                                        </div>
                                        <div class="mb-3">
                                            <label>Tags</label>
                                            <input id="tags-input" type="text" class="form-control"
                                                placeholder="ketik lalu spasi untuk membuat tag...">
                                            <input name="tags" type="hidden" id="tags-hidden">
                                            <div id="tags-container" class="mb-2"></div>
                                        </div>
                                        <div class="mb-3">
                                            <label>Harga</label>
                                            <input type="text" class="form-control" id="editHarga">
                                        </div>
                                    </div>
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
    <script src="{{ asset('admin/js/base_currency.js') }}"></script>
    <script src="{{ asset('admin/js/badge_action.js') }}"></script>
    <script src="{{ asset('admin/js/datatable/base-datatables.js') }}"></script>
    <script>
        const editProdukUrl = "{{ url('') }}";
        const deleteKategoriUrl = "{{ url('/admin/produk/delete') }}";
        $('#editHarga').on('input', function() {
            let value = $(this).val().replace(/[^0-9]/g, "");
            $(this).val(new Intl.NumberFormat("id-ID").format(value));
        });

        $(document).ready(function() {
            var table = initDataTable('#dataTable', {
                ajax: {
                    url: "{{ route('produk.view') }}",
                    dataSrc: function(json) {
                        console.log(json);
                        return json.data;
                    }
                },
                columns: [{
                        data: null,
                        width: '50px',
                        render: function(data, type, row, meta) {
                            return meta.row + 1;
                        },
                        orderable: false,
                        searchable: false
                    },
                    {
                        title: "Produk",
                        width: "20%",
                        data: null,
                        orderable: false,
                        render: function(row) {
                            console.log(row);
                            const img = row.imageUrl ?
                                `<img src="${row.imageUrl}" width="50" height="50" style="object-fit:cover;border-radius:5px;margin-right:10px;">` :
                                `<div style="width:50px;height:50px;background:#eee;border-radius:5px;margin-right:10px;"></div>`;
                            return `
                                         <div class="d-flex align-items-center">
                                            ${img}
                                            <div>
                                                <div class="font-weight-bold">${row.nama}</div>
                                                <div class="text-muted" style="font-size:12px;">${row.sku}</div>
                                                <div class="text-muted" style="font-size:12px;">${row.brand ? row.brand.nama : '-'}</div>
                                            </div>
                                        </div>
                                    `;
                        }
                    },
                    {
                        width: '25%',
                        data: 'deskripsi'
                    },
                    {
                        width: '15%',
                        data: 'kategori.nama'
                    },
                    {
                        width: '15%',
                        data: null,
                        render: function(data, type, row) {
                            return formatRupiah(row.harga);
                        }
                    },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return `
                                <button class="btn btn-sm btn-warning btn-detail">Detail</button>
                                <button class="btn btn-sm btn-primary btn-edit">Edit</button>
                                <button class="btn btn-sm btn-danger btn-delete">Hapus</button>
                            `;
                        },
                    }
                ]
            });

            $('#dataTable').on('click', '.btn-edit, .btn-detail', function() {
                const rowData = table.row($(this).closest('tr')).data();
                const isDetail = $(this).hasClass('btn-detail');
                let tags = rowData.tags ?? [];

                $('#editModalLabel').text('Detail Produk', isDetail)

                $('#editPreviewImage').attr('src', rowData.imageUrl ?? '/no-image.jpg');
                $('#imageLabel').prop('hidden', isDetail)
                $('#editImage').prop('hidden', isDetail)

                $('#editImage').off('change').on('change', function() {
                    const file = this.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = e => $('#editPreviewImage').attr('src', e.target.result);
                        reader.readAsDataURL(file);
                    }
                });

                $('#editSKU').val(rowData.sku).prop('readonly', isDetail);
                $('#editNama').val(rowData.nama).prop('readonly', isDetail);
                $('#editDeskripsi').val(rowData.deskripsi).prop('readonly', isDetail);
                $('#editKategori').html(`
                    <option value="${rowData.kategori?.id}">
                        ${rowData.kategori?.nama}
                    </option>
                `).prop('disabled', isDetail);
                $('#editBrand').html(`
                    <option value="${rowData.brand?.id}">
                        ${rowData.brand?.nama}
                    </option>
                `).prop('disabled', isDetail);
                $('#tags-hidden').val(tags.join(','));
                badgeAction('#tags-input', '#tags-container', '#tags-hidden');
                tags.forEach(t => {
                    $('#tags-input').val(t).trigger($.Event("keydown", {
                        key: " "
                    }));
                });
                $('#tags-input').val('').prop('disabled', isDetail).prop('hidden', isDetail);
                $('#editHarga').val(formatRupiahNumber(rowData.harga)).prop('readonly', isDetail);

                $('#saveEditBtn').toggle(!isDetail)
                if (!isDetail) {
                    $('#saveEditBtn').off('click').on('click', function() {
                        let url = "{{ route('produk.update', ['id' => '__ID__']) }}".replace(
                            '__ID__',
                            rowData.id);
                        const data = new FormData();
                        console.log(data);
                        data.append('sku', $('#editSKU').val());
                        data.append('harga', $('#editHarga').val());
                        data.append('nama', $('#editNama').val());
                        data.append('deskripsi', $('#editDeskripsi').val());
                        data.append('id_kategori', $('#editKategori').val());
                        data.append('id_brand', $('#editBrand').val());
                        data.append('tags', $('#tags-hidden').val());

                        const file = $('#editImage')[0].files[0];
                        if (file) data.append('imageUrl', file);

                        ajaxRequest(
                            url,
                            'PUT',
                            data, {
                                reload: '#dataTable',
                                successMessage: "Produk berhasil diperbarui!"
                            }
                        )
                        $('#editModal').modal('hide')
                    });
                }
                $('#editModal').modal('show');
            });

            // Hapus Ajax
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
                        let url = "{{ route('produk.destroy', ['id' => '__ID__']) }}".replace(
                            '__ID__', rowData.id);
                        ajaxRequest(
                            url,
                            'DELETE', {}, {
                                reload: '#dataTable',
                                onSuccess: function(res) {
                                    Swal.fire('Terhapus',
                                        `Produk berhasil dihapus.`, 'success');
                                },
                            }
                        )
                    }
                });
            });
        });
    </script>
@endpush
