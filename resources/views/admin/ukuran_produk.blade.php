@extends('admin.layouts.partials.app')
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-flex align-items-center justify-content-between">
                            <h4 class="mb-0 font-size-18">Ukuran Produk</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Pages</a></li>
                                    <li class="breadcrumb-item active">Ukuran</li>
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
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#modalTambah">
                                        Tambah Ukuran
                                    </button>
                                </div>

                                <!-- Modal -->
                                <div class="modal fade" id="modalTambah">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">

                                            <div class="modal-header">
                                                <h5 class="modal-title">Tambah Ukuran Produk</h5>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>

                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <input type="hidden" id="id_ukuran">
                                                        <label>Produk</label>
                                                        <div class="input-group">
                                                            <input type="text" id="produk_nama" class="form-control"
                                                                readonly>
                                                            <input type="hidden" id="id_produk" name="id_produk">
                                                            <div class="input-group-append">
                                                                <button class="btn btn-secondary" id="btnPilihProduk">
                                                                    Pilih
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <small class="text-muted">
                                                            Stok total: <span id="stok_total">0</span>
                                                        </small>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label>Nama Ukuran</label>
                                                        <input type="text" class="form-control" name="nama_ukuran"
                                                            id="nama_ukuran" placeholder="Contoh: S, M, XL" required>
                                                    </div>

                                                    <div class="col-md-6 mt-3">
                                                        <label>Qty Ukuran</label>
                                                        <input type="number" class="form-control" name="qty"
                                                            id="qty" min="0" required>
                                                        <small class="text-muted">
                                                            Sisa stok yang bisa dialokasikan:
                                                            <span id="sisa_stok">0</span>
                                                        </small>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                <button class="btn btn-primary" id="saveBtn">Simpan</button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table id="dataTable" class="table table-striped w-100">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Produk</th>
                                                <th>Nama Ukuran</th>
                                                <th>Qty</th>
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

                <div class="modal fade" id="modalPilihProduk">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Pilih Produk</h5>
                                <button type="button" class="close" data-dismiss="modal">
                                    <span>&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="table-responsive">
                                    <table id="produkTable" class="table table-striped w-100">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Produk</th>
                                                <th>Kategori</th>
                                                <th>SKU</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="listProduk"></tbody>
                                    </table>
                                </div>
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
    <script src="{{ asset('admin/js/datatable/base-datatables.js') }}"></script>
    <script>
        let produkTable
        const editKategoriUrl = "{{ url('/admin/kategori/edit') }}";
        const deleteKategoriUrl = "{{ url('/admin/kategori/delete') }}";

        $(document).ready(function() {
            var table = initDataTable('#dataTable', {
                ajax: {
                    url: "{{ route('ukuran.view') }}",
                    dataSrc: function(json) {
                        console.log('Data Ukuran:', json.data)
                        return json.data;
                    }
                },
                columns: [{
                        data: null,
                        width: '10%',
                        render: function(data, type, row, meta) {
                            return meta.row + 1;
                        },
                        orderable: false,
                        searchable: false
                    },
                    {
                        title: "Produk",
                        width: "30%",
                        data: null,
                        orderable: false,
                        render: function(row) {
                            const img = row.produk.imageUrl ?
                                `<img src="${row.produk.imageUrl}" width="50" height="50" style="object-fit:cover;border-radius:5px;margin-right:10px;">` :
                                `<div style="width:50px;height:50px;background:#eee;border-radius:5px;margin-right:10px;"></div>`;
                            return `
                                     <div class="d-flex align-items-center">
                                        ${img}
                                        <div>
                                            <div class="font-weight-bold">${row.produk.nama}</div>
                                            <div class="text-muted" style="font-size:12px;">${row.produk.brand}</div>
                                        </div>
                                    </div>
                                `;
                        }
                    },
                    {
                        width: '20%',
                        data: 'nama_ukuran'
                    },
                    {
                        data: 'qty',
                        class: "text-center"
                    },
                    {
                        width: '15%',
                        data: null,
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

            $("#btnPilihProduk").on("click", function() {
                $("#modalPilihProduk").modal("show");
                if (!$.fn.DataTable.isDataTable('#produkTable')) {
                    produkTable = $('#produkTable').DataTable({
                        ajax: {
                            url: "{{ route('produk.view') }}",
                            dataSrc: function(json) {
                                console.log(json.data);
                                return json.data;
                            },
                            data: function(d) {
                                d.search = $("#cariProduk").val();
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
                            }, {
                                title: "Produk",
                                width: "30%",
                                data: null,
                                orderable: false,
                                render: function(row) {
                                    const img = row.imageUrl ?
                                        `<img src="${row.imageUrl}" width="50" height="50" style="object-fit:cover;border-radius:5px;margin-right:10px;">` :
                                        `<div style="width:50px;height:50px;background:#eee;border-radius:5px;margin-right:10px;"></div>`;
                                    return `
                                         <div class="d-flex align-items-center">
                                            ${img}
                                            <div>
                                                <div class="font-weight-bold">${row.nama}</div>
                                                <div class="text-muted" style="font-size:12px;">${row.brand ? row.brand.nama : '-'}</div>
                                            </div>
                                        </div>
                                    `;
                                }
                            },
                            {
                                data: 'kategori.nama',
                                defaultContent: '-'
                            },
                            {
                                data: 'sku'
                            },
                            {
                                data: null,
                                render: function(data, type, row) {
                                    return `<button 
                                    class="btn btn-success btn-sm pilihProduk"
                                    data-id="${row.id}"
                                    data-nama="${row.nama}"
                                    data-stok="${row.stok.qty}"
                                    >
                                    Pilih
                                </button>`;
                                },
                                orderable: false
                            }
                        ]
                    });
                } else {
                    produkTable.ajax.reload();
                }
            });

            $(document).on("click", ".pilihProduk", function() {
                const id = $(this).data("id");
                const nama = $(this).data("nama");
                const stok = $(this).data("stok");

                $("#id_produk").val(id);
                $("#produk_nama").val(nama);
                $("#stok_total").text(stok);

                $("#modalPilihProduk").modal("hide");
            });

            $("#qty").on("input", function() {
                const stokTotal = parseInt($("#stok_total").text()) || 0;
                const qty = parseInt($(this).val()) || 0;

                const sisa = stokTotal - qty;
                $("#sisa_stok").text(sisa >= 0 ? sisa : 0);
            });

            // Tambah Btn
            $('#saveBtn').on("click", function() {
                $("#saveBtn").prop("disabled", true).text("Menyimpan...");

                const id_ukuran = $("#id_ukuran").val();
                const id_produk = $('#id_produk').val();
                const nama_ukuran = $('#nama_ukuran').val();
                const qty = $('#qty').val();

                let endpoint = "{{ route('ukuran.store') }}"
                let method = "POST";

                if (id_ukuran) {
                    endpoint = "{{ route('ukuran.update', ':id') }}".replace(':id', id_ukuran);
                    method = "PUT";
                }
                ajaxRequest(
                    endpoint,
                    method, {
                        id_produk,
                        nama_ukuran,
                        qty
                    }, {
                        reload: "#dataTable",
                        successMessage: id_ukuran ? "Stok berhasil diperbarui!" :
                            "Stok berhasil ditambahkan!",
                        onSuccess: function(res) {
                            $("#modalTambah").modal("hide");
                            resetForm();
                            if (typeof stokTable !== "undefined") {
                                stokTable.ajax.reload();
                            }

                        },
                        onError: function(xhr) {
                            if (xhr.status === 422) {
                                Swal.fire({
                                    type: "error",
                                    title: "Stok tidak cukup",
                                    text: xhr.responseJSON.message.qty[0],
                                });
                            }
                        },
                        complete: function() {
                            $("#saveBtn").prop("disabled", false).text("Simpan");
                        }
                    }
                )
            })

            function resetForm() {
                $("#id_ukuran").val("");
                $("#id_produk").val("");
                $("#produk_nama").val("");
                $("#nama_ukuran").val("");
                $("#qty").val("");
                $("#stok_total").text("0");
                $("#sisa_stok").text("0");

                $("#saveBtn").text("Simpan")
                    .removeClass("btn-warning")
                    .addClass("btn-primary");

                $("#modalTitle").text("Tambah Ukuran Produk");
            }


            // Edit Btn
            $(document).on('click', ".btn-edit", function() {
                let row = table.row($(this).closest('tr')).data();

                $("#id_ukuran").val(row.id);
                $("#id_produk").val(row.produk.id);
                $("#produk_nama").val(row.produk.nama);
                $("#nama_ukuran").val(row.nama_ukuran);
                $("#qty").val(row.qty);

                if (row.produks && row.produks.imageUrl) {
                    $("#editPreviewImage").attr('src', row.produks.imageUrl);
                }

                const stokTotal = row.stok_total;
                const sisaStok = row.sisa_stok;

                $("#stok_total").text(stokTotal);
                $("#sisa_stok").text(sisaStok);

                // Ubah judul modal
                $("#modalTitle").text("Edit Ukuran");
                $("#saveBtn").text("Update").removeClass("btn-primary").addClass("btn-warning");

                $("#modalTambah").modal("show");
            });

            // Delete button
            $('#dataTable').on('click', '.btn-delete', function() {
                let rowData = table.row($(this).closest('tr')).data();
                Swal.fire({
                    title: 'Apakah yakin?',
                    text: 'Anda tidak dapat mengembalikannya!',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.value) {
                        let url = "{{ route('ukuran.destroy', ':id') }}".replace(':id', rowData.id);
                        ajaxRequest(
                            url,
                            'DELETE', {}, {
                                reload: '#dataTable',
                                onSuccess: function(res) {
                                    Swal.fire('Terhapus',
                                        `Ukuran berhasil dihapus.`, 'success');

                                },
                            }
                        )
                    }
                });
            });
        });
    </script>
@endpush
