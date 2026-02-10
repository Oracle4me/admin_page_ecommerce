@extends('admin.layouts.partials.app')
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-flex align-items-center justify-content-between">
                            <h4 class="mb-0 font-size-18">Dashboard</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
                                    <li class="breadcrumb-item active">Dashboard</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->
                <div class="row">

                    <!-- Total Produk -->
                    <div class="col-md-6 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-4">
                                    <span class="badge badge-soft-primary float-right">Product</span>
                                    <h5 class="card-title mb-0">Total Produk</h5>
                                </div>

                                <div class="row d-flex align-items-center mb-4">
                                    <div class="col-8">
                                        <h2 class="d-flex align-items-center mb-0" id="totalProduk">
                                            0
                                        </h2>
                                    </div>
                                    <div class="col-4 text-right">
                                        <span class="text-muted" id="produkGrowth">0%
                                            <i class="mdi mdi-arrow-up text-success"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="progress shadow-sm" style="height: 5px;">
                                    <div id="produkProgress" class="progress-bar bg-success" role="progressbar"
                                        style="width: 50%;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Kategori -->
                    <div class="col-md-6 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-4">
                                    <span class="badge badge-soft-primary float-right">Category</span>
                                    <h5 class="card-title mb-0">Total Kategori</h5>
                                </div>

                                <div class="row d-flex align-items-center mb-4">
                                    <div class="col-8">
                                        <h2 class="d-flex align-items-center mb-0" id="totalKategori">
                                            0
                                        </h2>
                                    </div>
                                    <div class="col-4 text-right">
                                        <span class="text-muted" id="kategoriGrowth">0%
                                            <i class="mdi mdi-arrow-up text-success"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="progress shadow-sm" style="height: 5px;">
                                    <div id="kategoriProgress" class="progress-bar bg-info" role="progressbar"
                                        style="width: 40%;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Brand -->
                    <div class="col-md-6 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-4">
                                    <span class="badge badge-soft-primary float-right">Brand</span>
                                    <h5 class="card-title mb-0">Total Brand</h5>
                                </div>

                                <div class="row d-flex align-items-center mb-4">
                                    <div class="col-8">
                                        <h2 class="d-flex align-items-center mb-0" id="totalBrand">
                                            0
                                        </h2>
                                    </div>
                                    <div class="col-4 text-right">
                                        <span class="text-muted" id="brandGrowth">
                                            0% <i class="mdi mdi-arrow-up text-success"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="progress shadow-sm" style="height: 5px;">
                                    <div id="brandProgress" class="progress-bar bg-warning" role="progressbar"
                                        style="width: 60%;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Voucher -->
                    <div class="col-md-6 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-4">
                                    <span class="badge badge-soft-warning float-right">Voucher</span>
                                    <h5 class="card-title mb-0">Total Voucher</h5>
                                </div>

                                <div class="row d-flex align-items-center mb-4">
                                    <div class="col-8">
                                        <h2 class="d-flex align-items-center mb-0" id="totalVoucher">
                                            0
                                        </h2>
                                    </div>
                                    <div class="col-4 text-right">
                                        <span class="text-muted" id="voucherGrowth">
                                            0% <i class="mdi mdi-arrow-up text-success"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="progress shadow-sm" style="height: 5px;">
                                    <div id="voucherProgress" class="progress-bar bg-warning" role="progressbar"
                                        style="width: 0%;"></div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <!-- end row-->


                <div class="row">
                    <div class="col-lg-12">

                        <div class="card">
                            <div class="card-body">

                                <div class="row">
                                    <!-- Sales Analytics -->
                                    <div class="col-lg-8">
                                        <h4 class="card-title">Analisis Penjualan</h4>
                                        <p class="card-subtitle mb-4">Total penjualan per hari</p>
                                        <div id="salesChart" class="morris-chart" style="height: 250px;"></div>
                                    </div>

                                    <!-- Stock / Inventory -->
                                    <div class="col-lg-4">
                                        <h4 class="card-title">Analisis Stok</h4>
                                        <p class="card-subtitle mb-4">Stok saat ini</p>
                                        <div class="text-center">
                                            <div class="stock-count" style="font-size:48px;font-weight:bold;">0</div>
                                            <h5 class="text-muted mt-2">Produk dalam stok</h5>
                                            <div class="row mt-3">
                                                <div class="col-6">
                                                    <p class="text-muted font-15 mb-1 text-truncate">Stok Rendah</p>
                                                    <h4 class="text-danger" id="lowStock">0</h4>
                                                </div>
                                                <div class="col-6">
                                                    <p class="text-muted font-15 mb-1 text-truncate">Total Produk</p>
                                                    <h4 class="text-primary" id="totalStock">0</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!--end card body-->
                        </div> <!-- end card-->
                    </div> <!-- end col -->


                </div>
                <!--end row-->

                <div class="row">
                    <div class="col-lg-12">

                        <div class="card">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h4 class="card-title">Transaksi Akun</h4>
                                        <p class="card-subtitle mb-4">Periode transaksi dari 30 hari terakhir</p>
                                        <h3 id="transactionTotal">0 <span id="transactionChange"
                                                class="badge badge-soft-success float-right">+0%</span></h3>
                                    </div>
                                </div> <!-- end row -->

                                <div id="sparkline1" class="mt-3"></div>
                            </div>
                        </div>
                        <!--end card-->

                    </div><!-- end col -->

                </div>


                <div class="row">
                    {{-- <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="dropdown float-right position-relative">
                                    <a href="#" class="dropdown-toggle h4 text-muted" data-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="mdi mdi-dots-vertical"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li><a href="#" class="dropdown-item">Action</a></li>
                                        <li><a href="#" class="dropdown-item">Another action</a></li>
                                        <li><a href="#" class="dropdown-item">Something else here</a></li>
                                        <li class="dropdown-divider"></li>
                                        <li><a href="#" class="dropdown-item">Separated link</a></li>
                                    </ul>
                                </div>
                                <h4 class="card-title d-inline-block">Total Revenue</h4>

                                <div id="morris-line-example" class="morris-chart" style="height: 290px;"></div>

                                <div class="row text-center mt-4">
                                    <div class="col-6">
                                        <h4>$7841.12</h4>
                                        <p class="text-muted mb-0">Total Revenue</p>
                                    </div>
                                    <div class="col-6">
                                        <h4>17</h4>
                                        <p class="text-muted mb-0">Open Compaign</p>
                                    </div>
                                </div>

                            </div>
                            <!--end card body-->

                        </div>
                        <!--end card-->
                    </div> --}}
                    <!--end col-->
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">

                                <h4 class="card-title">Top 5 Customers</h4>
                                <p class="card-subtitle mb-4 font-size-13">Transaction period from last 30 days</p>

                                <div class="table-responsive">
                                    <table class="table table-centered table-striped table-nowrap mb-0">
                                        <thead>
                                            <tr>
                                                <th>Customer</th>
                                                <th>Phone</th>
                                                <th>Email</th>
                                                <th>Location</th>
                                                <th>Create Date</th>
                                            </tr>
                                        </thead>
                                        <tbody id="topCustomersTableBody">
                                            {{-- Data akan diisi via JS --}}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!--end card body-->
                        </div>
                        <!--end card-->
                    </div>

                    <!--end col-->
                </div>
                <!--end row-->
            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->

        @include('admin.layouts.partials.footer')
    </div>
    {{-- @include('admin.layouts.script') --}}
@endsection
@push('scripts')
    <script src="{{ asset('admin/js/base_ajax.js') }}"></script>
    <script>
        $(document).ready(function() {
            const url = "{{ route('dashboard.stats') }}";
            ajaxRequest(
                url,
                'GET', {}, {
                    silent: true,
                    onSuccess: function(res) {
                        console.log("Dashboard data:", res)
                        $("#totalProduk").text(res.total_produk);

                        $("#produkGrowth").html(
                            res.growth_produk + "% " +
                            (res.growth_icon === 'up' ?
                                "<i class='mdi mdi-arrow-up text-success'></i>" :
                                "<i class='mdi mdi-arrow-down text-danger'></i>")
                        );

                        $("#produkProgress")
                            .css('width', res.progress_produk + '%')
                            .removeClass('bg-success bg-danger')
                            .addClass(res.growth_icon === 'up' ? 'bg-success' : 'bg-danger');

                        $("#totalKategori").text(res.total_kategori);

                        $("#kategoriGrowth").html(
                            res.growth_kategori + "% " +
                            (res.kategori_icon === 'up' ?
                                "<i class='mdi mdi-arrow-up text-success'></i>" :
                                "<i class='mdi mdi-arrow-down text-danger'></i>")
                        );

                        $("#kategoriProgress")
                            .css('width', res.kategori_progress + '%')
                            .removeClass('bg-info bg-danger')
                            .addClass(res.kategori_color === 'success' ? 'bg-info' : 'bg-danger');

                        $("#totalBrand").text(res.total_brand);

                        $("#brandGrowth").html(
                            res.growth_brand + "% " +
                            (res.brand_icon === 'up' ?
                                "<i class='mdi mdi-arrow-up text-success'></i>" :
                                "<i class='mdi mdi-arrow-down text-danger'></i>")
                        );
                        $("#brandProgress")
                            .css('width', res.brand_progress + '%')
                            .removeClass('bg-warningg bg-danger')
                            .addClass(res.brand_color === 'success' ? 'bg-warning' : 'bg-danger');

                        $("#totalVoucher").text(res.total_voucher);

                        $("#voucherGrowth").html(
                            res.voucher_growth + "% " +
                            (res.voucher_icon === 'up' ?
                                "<i class='mdi mdi-arrow-up text-success'></i>" :
                                "<i class='mdi mdi-arrow-down text-danger'></i>")
                        );

                        $("#voucherProgress")
                            .css('width', res.voucher_progress + '%')
                            .removeClass('bg-success bg-danger')
                            .addClass(res.voucher_color === 'success' ? 'bg-warning' : 'bg-danger');

                    }
                }
            )

            // Sales Chart dengan target otomatis
            $.ajax({
                url: '/admin/dashboard/sales-chart',
                method: 'GET',
                success: function(res) {
                    if (res.length > 0) {

                        var previousTotal = 0;
                        var chartData = res.map(function(item, index) {
                            var target = index === 0 ? item.total :
                                previousTotal; // target = total hari sebelumnya
                            previousTotal = item.total;
                            return {
                                y: item.date,
                                actual: item.total,
                                target: target
                            };
                        });

                        Morris.Bar({
                            element: 'salesChart',
                            data: chartData,
                            xkey: 'y',
                            ykeys: ['actual', 'target'],
                            labels: ['Actual', 'Target'],
                            barColors: ['#2e7ce4', '#c2c2c2'],
                            gridTextColor: '#999',
                            gridLineColor: '#eee',
                            hideHover: 'auto',
                            resize: true
                        });
                    }
                }
            });


            $("input[data-plugin='knob']").knob({
                'readOnly': true,
                'width': 165,
                'height': 165,
                'fgColor': '#7a08c2',
                'thickness': .15,
                'angleOffset': 180
            });


            // Stock Stats
            $.ajax({
                url: '/admin/dashboard/stock-chart',
                method: 'GET',
                success: function(res) {
                    const totalProducts = res.length;
                    const lowStock = res.filter(r => r.status === 'Low').length;

                    $('#totalStock').text(totalProducts);
                    $('#lowStock').text(lowStock);
                    $('.stock-count').text(totalProducts);
                }
            });

            $.ajax({
                url: '/admin/dashboard/transaction-summary',
                method: 'GET',
                success: function(res) {
                    var totalIDR = res.total.toLocaleString('id-ID', {
                        style: 'currency',
                        currency: 'IDR'
                    });

                    $('#transactionTotal').html(
                        `${totalIDR} <span id="transactionChange" class="badge badge-soft-${res.change >= 0 ? 'success' : 'danger'} float-right">
                        ${res.change >= 0 ? '+' : ''}${res.change}%</span>`
                    );

                    var trendNumbers = res.trend.map(Number); // pastikan semua elemen number

                    // Render sparkline
                    $('#sparkline1').sparkline(trendNumbers, {
                        type: 'line',
                        width: '100%',
                        height: '297',
                        chartRangeMax: 35,
                        lineColor: '#1991eb',
                        fillColor: 'rgba(25,118,210,0.18)',
                        highlightLineColor: 'rgba(0,0,0,.1)',
                        highlightSpotColor: 'rgba(0,0,0,.2)',
                        spotColor: '#2e7ce4',
                        minSpotColor: '#f46a6a',
                        maxSpotColor: '#28a745',
                        spotRadius: 2,
                        lineWidth: 1
                    });
                }
            });

            $.ajax({
                url: '/admin/dashboard/top-customers',
                method: 'GET',
                success: function(res) {
                    var tbody = '';
                    res.forEach(function(cust) {
                        tbody += `
                <tr>
                    <td>${cust.customer_name}</td>
                    <td>${cust.customer_phone}</td>
                    <td>${cust.customer_email}</td>
                    <td>${cust.customer_address}</td>
                    <td>${new Date(cust.first_order).toLocaleDateString('id-ID')}</td>
                </tr>
            `;
                    });
                    $('table tbody').html(tbody);
                }
            });

        });
    </script>
@endpush
