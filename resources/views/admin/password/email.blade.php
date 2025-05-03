<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card p-4">
                <h4 class="text-center mb-4">Request Password Reset</h4>

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('password.reset.request') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" required>
                        @error('phone')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Send Reset Token</button>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>
