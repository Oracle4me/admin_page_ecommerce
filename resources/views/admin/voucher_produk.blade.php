@extends('admin.layouts.partials.app')
@section('content')
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-flex align-items-center justify-content-between">
                            <h4 class="mb-0 font-size-18">Voucher Produk</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
                                    <li class="breadcrumb-item active">Voucher Produk</li>
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
                                        data-toggle="modal" data-target="#voucherForm">
                                        Tambah Voucher
                                    </button>
                                </div>

                                <!-- Modal Tambah dan Edit -->
                                <div class="modal fade" id="voucherForm" tabindex="-1" aria-labelledby="addModal"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">

                                            <div class="modal-header">
                                                <h5 class="modal-title" id="voucherModalTitle">Tambah Voucher</h5>
                                                <button type="button" class="close" data-dismiss="modal">
                                                    <span>&times;</span>
                                                </button>
                                            </div>

                                            <div class="modal-body">
                                                <input type="hidden" id="voucher_id">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Kode Voucher</label>
                                                            <input type="text" class="form-control" id="code"
                                                                placeholder="Contoh: HEMAT50">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label>Jenis Voucher</label>
                                                        <select class="form-control" id="type">
                                                            <option value="">-- Pilih --</option>
                                                            <option value="percent">Persentase (%)</option>
                                                            <option value="nominal">Nominal (Rp)</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label>Nilai</label>
                                                        <input type="number" id="value" class="form-control"
                                                            placeholder="Contoh: 10 atau 5000">
                                                        <small id="valueInfo" class="text-muted"></small>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label>Minimal Harga Belanja</label>
                                                        <input type="number" id="min_amount" class="form-control"
                                                            placeholder="Contoh: 20000">
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label>Maksimal Penggunaan</label>
                                                        <input type="number" id="max_use" class="form-control"
                                                            placeholder="Contoh: 5">
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label>Mulai Berlaku</label>
                                                        <input type="date" id="starts_at" class="form-control">
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label>Berakhir Pada</label>
                                                        <input type="date" id="expires_at" class="form-control">
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label>Status</label>
                                                        <select id="status" class="form-control">
                                                            <option value="active">Aktif</option>
                                                            <option value="expired">Nonaktif</option>
                                                        </select>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" data-dismiss="modal"
                                                    id="closeBtn">Batal</button>
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
                                                <th>Code</th>
                                                <th>Type</th>
                                                <th>Value</th>
                                                <th>Minimal Belanja</th>
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
        $(document).ready(function() {
            var table = initDataTable('#dataTable', {
                ajax: {
                    url: "{{ route('voucher.view') }}",
                    dataSrc: function(json) {
                        console.log(json);
                        return json.data;
                    }
                },
                columns: [{
                        data: null,
                        width: '30px',
                        render: function(data, type, row, meta) {
                            return meta.row + 1;
                        },
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'code',
                        width: '200px',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'type',
                        searchable: false,
                        render: t => t === 'percent' ?
                            `<span class="badge badge-primary">Persen</span>` :
                            `<span class="badge badge-info">Nominal</span>`
                    },
                    {
                        data: null,
                        orderable: false,
                        width: '100px',
                        render: r =>
                            r.type === 'percent' ?
                            `${r.value}%` : `Rp ${Number(r.value).toLocaleString()}`
                    },
                    {
                        data: null,
                        orderable: false,
                        render: a =>
                            a.min_amount ? `Rp ${Number(a.min_amount).toLocaleString()}` : ""
                    },
                    {
                        data: 'status',
                        class: 'text-center',
                        render: s =>
                            s === 'active' ?
                            `<span class="badge badge-soft-success">Aktif</span>` :
                            `<span class="badge badge-soft-danger">Expired</span>`
                    },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        class: "text-center",
                        render: r => `
                            <button class="btn btn-sm btn-info btn-detail" data-id="${r.id}">
                                Detail
                            </button>
                            <button class="btn btn-sm btn-warning btn-edit" data-id="${r.id}">
                                Edit
                            </button>
                            <button class="btn btn-sm btn-danger btn-delete" data-id="${r.id}">
                                Hapus
                            </button>
                        `
                    }
                ]
            });

            // Biar select langsung aktif saat modal dibuka
            $('#voucherForm').on('shown.modal', function() {
                $("#type").trigger("change");
            });

            // Handle input nominal and percent
            $('#type').on("change", function() {
                console.log("DADASDADASDASDASD")
                let type = $(this).val();
                let input = $("#value");
                let info = $('#valueInfo');

                input.val("");

                if (type === "percent") {
                    input.attr("max", 100);
                    input.attr("min", 1);
                    info.text("Masukkan angka 1 - 100 (dalam persen)");
                } else if (type === "nominal") {
                    input.removeAttr("max");
                    input.attr("min", 1);
                    info.text("Masukkan nominal dalam Rupiah (tanpa titik)");
                } else {
                    // Jika user pilih "-- Pilih --"
                    input.removeAttr("max");
                    info.text("");
                }
            });

            // Validasi ketika mengetik value
            $("#value").on("input", function() {
                let type = $("#type").val();
                let val = parseInt($(this).val());

                if (type === "percent") {
                    if (val > 100) $(this).val(100);
                    if (val < 1) $(this).val(1);
                }
            });

            // Tambah
            $('#saveBtn').on("click", function() {
                const voucherId = $('#voucher_id').val();
                let data = {
                    code: $('#code').val(),
                    type: $('#type').val(),
                    value: $('#value').val(),
                    min_amount: $('#min_amount').val(),
                    max_use: $('#max_use').val(),
                    starts_at: $('#starts_at').val(),
                    expires_at: $('#expires_at').val(),
                    status: $('#status').val()
                }

                let endpoint = voucherId ?
                    "{{ route('voucher.update', ':id') }}".replace(':id', voucherId) :
                    "{{ route('voucher.store') }}";

                let method = voucherId ? "PUT" : "POST"

                ajaxRequest(
                    endpoint,
                    method,
                    data, {
                        reload: "#dataTable",
                        onSuccess: function(res) {
                            $("#voucherForm").modal("hide");
                            $("#saveBtn").prop("disabled", false).text("Simpan");

                            // Reset input
                            $("#voucher_id").val("");
                            $("#voucherForm input").val("");
                            $("#voucherForm select").val("");
                        },
                        complete: function() {
                            $("#saveBtn").prop("disabled", false).text("Simpan");
                        },
                        successMessage: voucherId ? "Voucher berhasil diperbarui!" :
                            "Voucher berhasil ditambah!"
                    }
                )
            })

            $(document).on('click', ".btn-edit, .btn-detail", function() {
                let row = table.row($(this).closest('tr')).data();
                let isDetail = $(this).hasClass("btn-detail");

                $('#voucher_id').val(row.id)
                $('#code').val(row.code);
                $('#type').val(row.type);
                $('#value').val(row.value);
                $('#min_amount').val(row.min_amount);
                $('#max_use').val(row.max_use);
                $('#starts_at').val(row.starts_at);
                $('#expires_at').val(row.expires_at);
                $('#status').val(row.status);

                if (isDetail) {
                    $("#modalTitle").text("Detail Voucher");
                    $("#saveBtn").hide();
                    $("#closeBtn").hide();
                    $("#voucherForm input, #voucherForm textarea").prop("readonly", true);
                    $("#voucherForm select").prop('disabled', true);
                } else {
                    $("#modalTitle").text("Edit Voucher");
                    $("#saveBtn").show().text("Update")
                        .removeClass("btn-primary").addClass("btn-warning");
                    $("#voucherForm input, #voucherForm textarea").prop("readonly", false);
                    $("#voucherForm select").prop('disabled', false);
                }

                $("#voucherForm").modal("show");
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
                    if (result.value) {
                        let url = "{{ route('voucher.destroy', ':id') }}".replace(':id', row
                            .id);
                        ajaxRequest(
                            url,
                            'DELETE', {}, {
                                reload: "#dataTable",
                                successMessage: "Voucher berhasil dihapus."
                            }
                        )
                    }
                });
            })

        });
    </script>
@endpush
