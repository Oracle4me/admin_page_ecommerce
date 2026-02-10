<div class="vertical-menu">
    <div data-simplebar class="h-100">

        <div class="navbar-brand-box">
            <a href="index.html" class="logo">
                <span>
                    Admin Panel
                </span>
            </a>
        </div>
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Menu</li>

                <li>
                    <a href="{{ route('dashboard.index') }}" class="waves-effect"><i
                            class="mdi mdi-home-analytics"></i><span
                            class="badge badge-pill badge-primary float-right">7</span><span>Dashboard</span></a>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect"><i
                            class="mdi mdi-diamond-stone"></i><span>Manajemen Produk</span></a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('produk.index') }}">Daftar Produk</a></li>
                        <li><a href="{{ route('tambah_produk.index') }}">Tambah Produk</a></li>
                        <li><a href="javascript: void(0);" class="has-arrow">Atribut</a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li><a href="{{ route('kategori.index') }}">Kategori Produk</a>
                                <li><a href="{{ route('brand.index') }}">Brand Produk</a>
                                <li><a href="{{ route('stok-inventory.index') }}">Stok & Iventory</a></li>
                                <li><a href="{{ route('ukuran.index') }}">Ukuran Produk</a></li>
                                <li><a href="{{ route('warna.index') }}">Warna Produk</a></li>
                                <li><a href="{{ route('voucher.index') }}">Voucher Produk</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect"><i
                            class="mdi mdi-table-merge-cells"></i><span>Pesanan</span></a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('order.index') }}">Daftar Pesanan</a></li>
                    </ul>
                </li>


                {{-- <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect"><i
                            class="mdi mdi-share-variant"></i><span>Multi Level</span></a>
                    <ul class="sub-menu" aria-expanded="true">
                        <li><a href="javascript: void(0);">Level 1.1</a></li>
                        <li><a href="javascript: void(0);" class="has-arrow">Level 1.2</a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li><a href="javascript: void(0);">Level 2.1</a></li>
                                <li><a href="javascript: void(0);">Level 2.2</a></li>
                            </ul>
                        </li>
                    </ul>
                </li> --}}

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
