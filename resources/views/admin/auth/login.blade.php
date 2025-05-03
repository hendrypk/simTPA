<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <!-- Bootstrap 4 CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for Eye Icon -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f7f7f7;
        }
        .login-container {
            margin-top: 100px;
        }
        .card {
            border-radius: 1rem;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .btn-primary {
            border-radius: 20px;
        }
        .min-vh-100 {
            min-height: 100vh;
        }
        .input-group-append .eye-icon {
            cursor: pointer;
        }
    </style>
</head>
<body>

<!-- Center content using flexbox -->
<div class="container d-flex min-vh-100 justify-content-center align-items-center">
    <div class="row justify-content-center w-100">
        <div class="col-md-6">
            <!-- Title Header Outside the Card -->
            <div class="text-center mb-4">
                <h3 class="font-weight-bold">Welcome to simTPA</h3>
            </div>

            <!-- Login Card -->
            <div class="card p-4">
                <h4 class="text-center mb-4">Login</h4>

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('login.auth') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               required autofocus>
                        @error('email')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mt-3">
                        <label for="password">Password</label>
                        <div class="input-group">
                            <input type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   id="password" 
                                   name="password" 
                                   required>
                            <div class="input-group-append">
                                <span class="input-group-text eye-icon" id="togglePassword">
                                    <i class="fas fa-eye"></i>
                                </span>
                            </div>
                        </div>
                        @error('password')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Remember Me Checkbox -->
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember">Ingat Saya</label>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block mt-4">Login</button>
                </form>

                <div class="text-center mt-3">
                    <small><a href="{{ route('password.request') }}">Forgot Password?</a></small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap 4 JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- JavaScript to Toggle Password Visibility -->
<script>
    document.getElementById('togglePassword').addEventListener('click', function () {
        var passwordField = document.getElementById('password');
        var icon = this.querySelector('i');
        
        if (passwordField.type === 'password') {
            passwordField.type = 'text'; // Show password
            icon.classList.remove('fa-eye');  // Change icon to open eye
            icon.classList.add('fa-eye-slash'); // Change icon to closed eye
        } else {
            passwordField.type = 'password'; // Hide password
            icon.classList.remove('fa-eye-slash'); // Change icon to closed eye
            icon.classList.add('fa-eye'); // Change icon to open eye
        }
    });
</script>

</body>
</html>
