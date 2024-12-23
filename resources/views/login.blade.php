@extends('layout.templateuser')
@section('content')
    <script src="./dist/js/demo-theme.min.js?1684106062"></script>
    <div class="page page-center">
        <div class="container container-normal py-4">
            <div class="row align-items-center g-4">
                <div class="col-lg">
                    <div class="container-tight">
                        <div class="text-center mb-4">
                            <a href="." class="navbar-brand navbar-brand-autodark"><img src="./static/logo.svg"
                                    height="36" alt=""></a>
                        </div>
                        @if (session('error_login'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>{!! session('error_login') !!}</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        @if (session('success_registrasi'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>{!! session('success_registrasi') !!}</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        <div class="card card-md">
                            <div class="card-body">
                                <h2 class="h2 text-center mb-4">Login to your account</h2>
                                <form action="/proseslogin" method="post" autocomplete="off" novalidate>
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">Username</label>
                                        <input type="text" name="username" id="username"
                                            class="form-control @error('username') is-invalid @enderror"
                                            placeholder="Enter Username" autocomplete="on">
                                        @error('username')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">
                                            Password
                                        </label>
                                        <input type="password" name="password" id="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            placeholder="Enter Password" autocomplete="off">
                                        @error('password')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-footer">
                                        <button type="submit" class="btn btn-primary w-100">Sign in</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="text-center text-muted mt-3">
                            Don't have account yet? <a href="/register_app_simaster" tabindex="-1">Sign up</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg d-none d-lg-block">
                    <img src="/assets_template/static/illustrations/undraw_secure_login_pdn4.svg" height="300"
                        class="d-block mx-auto" alt="">
                </div>
            </div>
        </div>
    </div>
@endsection
