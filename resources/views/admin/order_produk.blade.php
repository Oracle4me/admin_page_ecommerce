@extends('admin.layouts.partials.app')
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-flex align-items-center justify-content-between">
                            <h4 class="mb-0 font-size-18">Daftar Pesanan</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
                                    <li class="breadcrumb-item active">Pesanan</li>
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
                                    <table id="orderTable" class="table table-striped w-100">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Order ID</th>
                                                <th>Customer</th>
                                                <th>Total</th>
                                                <th>Status</th>
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

            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
        @include('admin.layouts.partials.footer')
    </div>

    <!-- Modal Detail Order -->
    <div class="modal fade" id="orderDetailModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Pesanan</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <table class="table table-borderless table-sm mb-2">
                        <tr>
                            <th style="width:150px;">Order ID</th>
                            <td>: <span id="modal-order-id"></span></td>
                        </tr>
                        <tr>
                            <th>Customer</th>
                            <td>: <span id="modal-customer"></span></td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>: <span id="modal-status"></span></td>
                        </tr>
                        <tr>
                            <th>Total</th>
                            <td>: <span id="modal-total"></span></td>
                        </tr>
                    </table>

                    <hr>

                    <h6>Items</h6>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Qty</th>
                                <th>Harga</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody id="modal-items"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('admin/js/base_ajax.js') }}"></script>
    <script src="{{ asset('admin/js/datatable/base-datatables.js') }}"></script>
    <script>
        $(document).ready(function() {
            var table = initDataTable('#orderTable', {
                ajax: {
                    url: "{{ route('order.view') }}",
                    dataSrc: function(json) {
                        return json.data;
                    }
                },
                columns: [{
                        data: null,
                        width: '5%',
                        render: function(data, type, row, meta) {
                            return meta.row + 1;
                        },
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'order_id'
                    },
                    {
                        data: 'customer_name'
                    },
                    {
                        data: 'total',
                        render: function(data) {
                            return 'Rp ' + new Intl.NumberFormat().format(data);
                        }
                    },
                    {
                        data: 'status',
                        render: function(data, type, row) {
                            return `
                            <select class="form-control status-select" data-id="${row.id}">
                                <option value="pending" ${data=='pending'?'selected':''}>Pending</option>
                                <option value="paid" ${data=='paid'?'selected':''}>Paid</option>
                                <option value="failed" ${data=='failed'?'selected':''}>Failed</option>
                                <option value="shipped" ${data=='shipped'?'selected':''}>Shipped</option>
                                <option value="cancelled" ${data=='cancelled'?'selected':''}>Cancelled</option>
                            </select>
                        `;
                        }
                    },
                    {
                        data: null,
                        width: '10%',
                        render: function(data, type, row) {
                            return `<button class="btn btn-info btn-sm btn-detail" data-id="${row.id}">Detail</button>`;
                        },
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            // Update status
            $('#orderTable').on('change', '.status-select', function() {
                let orderId = $(this).data('id');
                let status = $(this).val();
                const url = "{{ route('order.update.status', ':id') }}".replace(':id', orderId);

                ajaxRequest(
                    url,
                    'POST', {
                        status,
                        _token: '{{ csrf_token() }}'
                    }, {
                        reload: '#orderTable',
                        successMessage: 'Status order berhasil diperbarui!',
                    }
                );
            });

            // Klik tombol detail
            $('#orderTable').on('click', '.btn-detail', function() {
                let id = $(this).data('id');
                let url = "{{ route('order.show', ':id') }}".replace(':id', id);

                $.get(url, function(res) {
                    const order = res.order;

                    $('#modal-order-id').text(order.order_id);
                    $('#modal-customer').text(order.customer_name);
                    $('#modal-status').text(order.status);
                    $('#modal-total').text('Rp ' + new Intl.NumberFormat().format(order.total));

                    let itemsHtml = '';
                    order.items.forEach(item => {
                        itemsHtml += `
                <tr>
                    <td>${item.produk?.nama ?? '-'}</td>
                    <td>${item.qty}</td>
                    <td>Rp ${new Intl.NumberFormat().format(item.harga)}</td>
                    <td>Rp ${new Intl.NumberFormat().format(item.qty * item.harga)}</td>
                </tr>
            `;
                    });

                    $('#modal-items').html(itemsHtml);

                    $('#orderDetailModal').modal('show');
                });
            });

        });
    </script>
@endpush
