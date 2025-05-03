<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Include SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card p-4">
                <h4 class="text-center mb-4">Reset Password</h4>

                <form id="reset-password-form" method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="password">New Password</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="password-confirm">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password-confirm" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Reset Password</button>
                </form>
            </div>
        </div>
    </div>
</div>


{{-- SweetAlert2 CDN --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
        });
    });
</script>
@endif

{{-- Error Validation Message --}}
@if ($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            html: `{!! implode('<br>', $errors->all()) !!}`,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Tutup'
        });
    });
</script>
@endif


</body>
</html>
