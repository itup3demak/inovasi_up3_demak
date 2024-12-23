@extends('layout.templateuser')
@section('content')
    <script src="./dist/js/demo-theme.min.js?1684106062"></script>
    <div class="page page-center">
        <div class="container container-tight py-4">
            <div class="text-center mb-4">
                <a href="." class="navbar-brand navbar-brand-autodark"><img src="./static/logo.svg" height="36"
                        alt=""></a>
            </div>
            <form class="card card-md" action="/store" method="post" autocomplete="on" novalidate>
                @csrf
                <div class="card-body">
                    <h2 class="card-title text-center mb-4">Create new account</h2>
                    <input type="hidden" name="role" id="role" value="user" class="form-control">
                    <div class="mb-3">
                        <label class="form-label required">Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                            class="form-control @error('name') is-invalid @enderror" placeholder="Enter Name"
                            autocomplete="name" autofocus>
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">Username</label>
                        <input type="text" name="username" id="username" value="{{ old('username') }}"
                            class="form-control @error('username') is-invalid @enderror" placeholder="Enter Username"
                            autocomplete="username">
                        @error('username')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">Email Address</label>
                        <input type="email" inputmode="email" name="email" id="email" value="{{ old('email') }}"
                            class="form-control @error('email') is-invalid @enderror" placeholder="Enter Email">
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">Password</label>
                        <input type="password" name="password" id="password"
                            class="form-control @error('password') is-invalid @enderror" placeholder="Password"
                            autocomplete="off">
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="form-control @error('password') is-invalid @enderror" placeholder="Password"
                            autocomplete="off">
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label required">Role</label>
                        <select name="role" id="role_select" class="form-control @error('role') is-invalid @enderror">
                            <option value="" disabled {{ old('role') == '' ? 'selected' : '' }}>--- Pilih Role ---</option>
                            <option value="administrator" {{ old('role') == 'administrator' ? 'selected' : '' }}>Administrator</option>
                            <option value="koordinator" {{ old('role') == 'koordinator' ? 'selected' : '' }}>Koordinator</option>
                            <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                            <option value="mitra" {{ old('role') == 'mitra' ? 'selected' : '' }}>Mitra</option>
                        </select>
                        @error('role')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3" id="unit_ulp_container" style="display:none;">
                        <label for="unit_ulp" class="form-label required">Unit ULP</label>
                        <select name="unit_ulp" id="unit_ulp" class="form-control @error('unit_ulp') is-invalid @enderror">
                            <option selected disabled>--- Pilih Unit ULP ---</option>
                            <option value="ulp demak">ULP Demak</option>
                            <option value="ulp tegowanu">ULP Tegowanu</option>
                            <option value="ulp purwodadi">ULP Purwodadi</option>
                            <option value="ulp wirosari">ULP Wirosari</option>
                        </select>
                        @error('unit_ulp')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary w-100">Create new account</button>
                    </div>
                </div>
            </form>
            <div class="text-center text-muted mt-3">
                Already have account? <a href="/" tabindex="-1">Sign in</a>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('role_select').addEventListener('change', function() {
            var ulpContainer = document.getElementById('unit_ulp_container');
            var roleValue = this.value;
    
            if (roleValue === 'user') {
                ulpContainer.style.display = 'block';
            } else {
                ulpContainer.style.display = 'none';
                document.getElementById('unit_ulp').value = '';
            }
        });
    </script>
@endsection
