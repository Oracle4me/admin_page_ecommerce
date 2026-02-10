@extends('admin.layouts.partials.app')

@section('content')
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-flex align-items-center justify-content-between">
                            <h4 class="mb-0 font-size-18">Tambah Produk</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
                                    <li class="breadcrumb-item active">Tambah Produk</li>
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
                                <form id="produkForm" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-6 mb-4">
                                            <h4 class="card-title">Upload Gambar Produk</h4>
                                            <p class="card-subtitle mb-4">Data max file upload <code>1MB</code> </p>
                                            <div class="form-group" style="margin-top: 20px">
                                                <label for="simpleinput">Gambar Produk</label>
                                                <input type="file" name="imageUrl" class="dropify" data-height="300"
                                                    data-max-file-size="1M" />
                                            </div>
                                            <div class="form-group">
                                                <label for="simpleinput">Nama Produk</label>
                                                <input name="nama" type="text" id="simpleinput" class="form-control"
                                                    placeholder="Enter your text" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleFormControlTextarea1">Deskripsi Produk</label>
                                                <textarea name="deskripsi" class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder=""></textarea>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 mb-4">
                                            <h4 class="card-title">Informasi Produk</h4>
                                            <p class="card-subtitle mb-4">Isi detail informasi produk dengan
                                                lengkap.</p>
                                            <div class="form-group">
                                                <label for="sku">SKU</label>
                                                <input name="sku" type="text" id="sku" class="form-control"
                                                    placeholder="Enter your text" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1">Brand</label>
                                                <select name="id_brand" class="form-control" required>
                                                    @foreach ($brands as $brand)
                                                        <option value="{{ $brand->id }}">{{ $brand->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1">Kategori</label>
                                                <select name="id_kategori" class="form-control" required>
                                                    @foreach ($kategoris as $kategori)
                                                        <option value="{{ $kategori->id }}">{{ $kategori->nama }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Tags</label>
                                                <input id="tags-input" type="text" class="form-control"
                                                    placeholder="Ketik lalu spasi untuk membuat tag...">
                                                <input name="tags" type="hidden" id="tags-hidden">
                                                <div id="tags-container" class="mb-2"></div>
                                            </div>
                                            <div class="form-group">
                                                <label for="harga">Harga</label>
                                                <input name="harga" type="text" id="harga" class="form-control"
                                                    required>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button>
                                </form>
                            </div>
                        </div> <!-- end card body-->
                    </div> <!-- end card -->
                </div><!-- end col-->
            </div>
            <!-- end row-->
        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
    @include('admin.layouts.partials.footer')

    </div>
@endsection
@push('scripts')
    <script src="{{ asset('admin/js/base_ajax.js') }}"></script>
    <script src="{{ asset('admin/js/badge_action.js') }}"></script>
    <script>
        $(document).ready(function() {
            badgeAction('#tags-input', '#tags-container', '#tags-hidden');
            $('#harga').on('input', function() {
                let value = $(this).val().replace(/[^0-9]/g, "");
                $(this).val(new Intl.NumberFormat("id-ID").format(value));
            });


            $('#produkForm').on('submit', function(e) {
                e.preventDefault()
                const url = "{{ url('admin/produk') }}";
                const data = new FormData(this);
                console.log([...data.entries()]);
                ajaxRequest(
                    url,
                    'POST',
                    data, {
                        onSuccess: function(res) {
                            Swal.fire('Berhasil', 'Produk berhasil ditambahkan', 'success');
                            $('#produkForm')[0].reset();
                            $('.dropify').dropify().clearElement();
                            $('#tags-container').empty();
                            $('#tags-hidden').val('');
                        }
                    }
                )
            })
        })
    </script>
@endpush
