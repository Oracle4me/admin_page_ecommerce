@extends('admin.layouts.partials.app')
@section('content')
    <div class="main-content">


        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-flex align-items-center justify-content-between">
                            <h4 class="mb-0 font-size-18">Daftar Stok Produk</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
                                    <li class="breadcrumb-item active">Daftar Stok Produk


                                    </li>
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
                                        Tambah Stok
                                    </button>
                                </div>

                                <!-- Modal Tambah dan Edit -->
                                <div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="addModal"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalTitle">Tambah</h5>
                                                <button type="button" class="close waves-effect waves-light"
                                                    data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row g-3">
                                                    <div class="col-md-4 text-center">
                                                        <img id="editPreviewImage" class="img-fluid mb-3" src=""
                                                            style="width: 100%; height: 250px; object-fit: cover;"
                                                            alt="produk_sample.jpg">
                                                    </div>
                                                    <div class="col-md-8">
                                                        <input type="hidden" id="stok_id">
                                                        <div class="mb-3">
                                                            <label>Produk</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" id="produk_nama"
                                                                    readonly>
                                                                <input type="hidden" id="id_produk">
                                                                <div class="input-group-append">
                                                                    <button class="btn btn-secondary" id="btnPilihProduk">
                                                                        Pilih
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label>SKU</label>
                                                            <input name="sku" type="text" class="form-control"
                                                                id="sku" readonly></input>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label>Qty</label>
                                                            <input name="qty" type="number" class="form-control"
                                                                id="qty"></input>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Batal</button>
                                                <button type="button" class="btn btn-primary"
                                                    id="saveBtn">Simpan</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Modal Pilih Produk --}}
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


                                <div class="table-responsive">
                                    <table id="dataTable" class="table table-striped w-100">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Produk</th>
                                                <th>SKU</th>
                                                <th class="text-center">Qty</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('admin.layouts.partials.footer')
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('admin/js/base_ajax.js') }}"></script>
    <script src="{{ asset('admin/js/badge_action.js') }}"></script>
    <script src="{{ asset('admin/js/datatable/base-datatables.js') }}"></script>
    <script>
        let produkTable;
        $(document).ready(function() {
            var table = initDataTable('#dataTable', {
                ajax: {
                    url: "{{ route('stok-inventory.view') }}",
                    dataSrc: function(json) {
                        return json.data;
                    }
                },
                columns: [{
                        data: null,
                        width: '20px',
                        render: function(data, type, row, meta) {
                            return meta.row + 1;
                        },
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: null,
                        width: '30%',
                        orderable: false,
                        searchable: false,
                        render: function(row) {
                            const img = row.produks.imageUrl ?
                                `<img src="${row.produks.imageUrl}" width="80" height="80" style="object-fit:cover;border-radius:5px;margin-right:10px;">` :
                                `<div style="width:50px;height:50px;background:#eee;border-radius:5px;margin-right:10px;"></div>`;
                            return `
                                    <div class="d-flex">
                                        ${img}
                                        <div>
                                            <div class="font-weight-bold">${row.produks.nama}</div>
                                            <div class="text-muted" style="font-size:14px;">${row.produks.brand}</div>
                                        </div>
                                    </div>
                                `;
                        }
                    },
                    {
                        width: '15%',
                        data: null,
                        render: function(data) {
                            return data.produks.sku;
                        }
                    },
                    {
                        width: '15%',
                        data: 'qty',
                        class: "text-center"
                    },
                    {
                        width: '10%',
                        data: null,
                        class: "text-center",
                        render: function(data) {

                            let badgeClass = "poinhover";
                            let tooltip = "";

                            if (data.status === "Low") {
                                badgeClass = "badge badge-danger";
                                tooltip = "Stok hampir habis, segera lakukan restock!";
                            } else if (data.status === "Medium") {
                                badgeClass = "badge badge-warning";
                                tooltip = "Stok berada di level menengah.";
                            } else if (data.status === "High") {
                                badgeClass = "badge badge-success";
                                tooltip = "Stok aman dan masih mencukupi.";
                            }

                            return `
                                <span class="${badgeClass}" 
                                    data-toggle="tooltip" 
                                    data-placement="top" 
                                    title="${tooltip}">
                                    ${data.status}
                                </span>
                            `;
                        }
                    },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        class: "text-center",
                        render: function(data, type, row) {
                            return `
                                <button class="btn btn-sm btn-primary btn-edit" data-id="${data.id}">Edit</button>
                                <button class="btn btn-sm btn-danger btn-delete">Hapus</button>
                            `;
                        },
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
                            }, {
                                data: 'sku'
                            },
                            {
                                data: null,
                                render: function(data, type, row) {
                                    return `<button 
                                    class="btn btn-success btn-sm pilihProduk"
                                    data-id="${row.id}"
                                    data-nama="${row.nama}"
                                    data-sku="${row.sku}"
                                    data-gambar="${row.imageUrl}">
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
                const sku = $(this).data("sku");
                const nama = $(this).data("nama");
                const gambar = $(this).data("gambar");

                $("#id_produk").val(id);
                $("#sku").val(sku);
                $("#produk_nama").val(nama);
                $("#editPreviewImage").attr("src", `${gambar}`);

                $("#modalPilihProduk").modal("hide");
            });

            // Tambah Btn
            $('#saveBtn').on("click", function() {
                $("#saveBtn").prop("disabled", true).text("Menyimpan...");

                const stokId = $("#stok_id").val();
                const id_produk = $('#id_produk').val();
                const qty = $('#qty').val();

                let endpoint = "{{ route('stok-inventory.store') }}"
                let method = "POST";

                if (stokId) {
                    endpoint = `{{ route('stok-inventory.update', ['id' => ':id']) }}`.replace(':id',
                        stokId);
                    method = "PUT";
                }
                ajaxRequest(
                    endpoint,
                    method, {
                        id_produk,
                        qty
                    }, {
                        reload: "#dataTable",
                        successMessage: stokId ? "Stok berhasil diperbarui!" :
                            "Stok berhasil ditambahkan!",
                        onSuccess: function(res) {
                            $("#modalTambah").modal("hide");
                            resetForm();
                            if (typeof stokTable !== "undefined") {
                                stokTable.ajax.reload();
                            }

                        },
                        complete: function() {
                            $("#saveBtn").prop("disabled", false).text("Simpan");
                        }
                    }
                )
            })

            function resetForm() {
                $("#stok_id").val("");
                $("#id_produk").val("");
                $("#produk_nama").val("");
                $("#qty").val("");

                $("#saveBtn").text("Simpan").removeClass("btn-warning").addClass("btn-primary");
                $("#modalTitle").text("Tambah Stok");
            }

            // Edit Btn
            $(document).on('click', ".btn-edit", function() {
                let row = table.row($(this).closest('tr')).data();
                $("#stok_id").val(row.id);
                $("#id_produk").val(row.produks.id);
                $("#produk_nama").val(row.produks.nama);
                $("#sku").val(row.produks.sku);
                $("#qty").val(row.qty);

                if (row.produks && row.produks.imageUrl) {
                    $("#editPreviewImage").attr('src', `${row.produks.imageUrl}`);
                }
                // Ubah judul modal
                $("#modalTitle").text("Edit Stok");
                $("#saveBtn").text("Update").removeClass("btn-primary").addClass("btn-warning");

                $("#modalTambah").modal("show");
            });

            $(document).on('click', ".btn-delete", function() {
                let row = table.row($(this).closest('tr')).data();
                Swal.fire({
                    title: 'Apakah yakin?',
                    text: 'Anda tidak dapat mengembalikannya!',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus!',
                    cancalButtontext: 'Batal'
                }).then((result) => {
                    let url = `{{ route('stok-inventory.destroy', ['id' => ':id']) }}`.replace(
                        ':id', row.id);
                    ajaxRequest(
                        url,
                        'DELETE', {}, {
                            reload: "#dataTable",
                            successMessage: "Stok berhasil dihapus."
                        }
                    )
                });
            })

        });
    </script>
@endpush
