@extends($layout)

@section('content')
    <div class="container-fluid mt-4">
        <div class="card shadow-lg border-0 rounded">
            <div class="card-header bg-info text-white text-center rounded-top">
                <h3 class="mb-0">Edit User Simpeltas</h3>
            </div>
            <div class="card-body p-4">
                <form action="{{ url('/proses_edit_user_simpeltas/' . $user->id) }}" method="post">
                    @csrf
                    <div class="mb-4">
                        <label class="form-label">Nama</label>
                        <input class="form-control @error('name') is-invalid @enderror" name="name" id="name"
                            type="text" value="{{ old('name', $user->name) }}">
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Username</label>
                        <input class="form-control @error('username') is-invalid @enderror" name="username" id="username"
                            type="text" value="{{ old('username', $user->username) }}">
                        @error('username')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Email</label>
                        <input class="form-control @error('email') is-invalid @enderror" name="email" id="email"
                            type="text" value="{{ old('email', $user->email) }}">
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Password Lama</label>
                        <input class="form-control @error('password_lama') is-invalid @enderror" name="password_lama" id="password_lama"
                            type="password">
                        @error('password_lama')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Password Baru</label>
                        <input class="form-control @error('password') is-invalid @enderror" name="password" id="password"
                            type="password">
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Confirm Password Baru</label>
                        <input class="form-control @error('password_confirmation') is-invalid @enderror"
                            name="password_confirmation" id="password_confirmation" type="password">
                        @error('password_confirmation')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
