<!DOCTYPE html>
<html lang="en">
@include('admin.layouts.partials.head')

<?php
$title = 'Login Admin';
$description = 'Halaman login untuk admin';
?>

<body>
    <div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex align-items-center min-vh-100">
                        <div class="w-100 d-block bg-white shadow-lg rounded my-5">
                            <div class="row">
                                <div class="col-lg-5 d-none d-lg-block bg-login rounded-left"></div>
                                <div class="col-lg-7">
                                    <div class="p-5">
                                        <div class="text-center mb-5">
                                            <a href="index.html" class="text-dark font-size-22 font-family-secondary">
                                                <b>Admin Ecommerce</b>
                                            </a>
                                        </div>
                                        <p class="text-muted mb-4">Masukan nama dan password untuk mengakses panel
                                            admin.
                                        </p>
                                        <form class="user" id="formLogin">
                                            @csrf
                                            <div class="form-group">
                                                <input type="email" name="email"
                                                    class="form-control form-control-user" id="email"
                                                    placeholder="Email">
                                                <div class="invalid-feedback" id="loginError"></div>

                                            </div>
                                            <div class="form-group">
                                                <input type="password" name="password"
                                                    class="form-control form-control-user" id="password"
                                                    placeholder="Password" required>
                                                <div class="invalid-feedback" id="passwordError"></div>

                                            </div>
                                            <button type="submit" id="btn-login"
                                                class="btn btn-dark btn-block waves-effect waves-light">
                                                Log In
                                            </button>

                                        </form>

                                        <div class="row mt-4">
                                            <div class="col-12 text-center">
                                                <p class="text-muted mb-0">
                                                    © {{ date('Y') }}
                                                    Nur Muhammad Kevin — All rights reserved.
                                                </p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

@include('admin.layouts.partials.script');
<script src="{{ asset('admin/js/base_ajax.js') }}"></script>
<script>
    $('#formLogin').submit(function(e) {
        e.preventDefault();
        let url = "{{ route('admin.login.post') }}";
        let btn = $('#btn-login');
        const data = $(this).serialize();
        btn.prop('disabled', true).text('Loading...');

        ajaxRequest(url, 'POST', data, {
            onSuccess: function(res) {
                Swal.fire({
                    type: 'success',
                    title: 'Berhasil',
                    text: res.success || 'Login berhasil!',
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = res.redirect_to;
                });
            },
            onError: function(xhr) {
                Swal.fire({
                    type: 'error',
                    title: 'Gagal',
                    text: xhr.responseJSON?.message || 'Login gagal'
                });
                btn.prop('disabled', false).text('Log In');
            }
        });
    });

    @if (session('success'))
        Swal.fire({
            type: 'success',
            title: 'Berhasil',
            text: "{{ session('success') }}",
            timer: 1500,
            showConfirmButton: false
        });
    @endif
</script>
