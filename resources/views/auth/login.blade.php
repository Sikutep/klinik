<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clinic Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            height: 100vh;
            background-color: #f8f9fa;
        }
        .login-container {
            height: 100%;
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #198754;
        }
        .btn-green {
            background-color: #016A5C;
            color: white;
        }
        .btn-green:hover {
            background-color: #014e43;
        }
    </style>
</head>
<body>
    <div class="container-fluid login-container d-flex align-items-center">
        <div class="row w-100">
            <!-- Left image section -->
            <div class="col-md-6 d-none d-md-flex align-items-center justify-content-center">
                <img src="{{ asset('images/clinic-illustration.png') }}" alt="Clinic Illustration" class="img-fluid" style="max-height: 450px;">
            </div>

            <!-- Right form section -->
            <div class="col-md-6 d-flex align-items-center justify-content-center bg-white p-5 shadow-sm">
                <div class="w-100" style="max-width: 400px;">
                    <h2 class="fw-bold">Welcome to <span class="text-success">Clinic!</span></h2>
                    <p class="text-muted mb-4">Your productivity dashboard begin here</p>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <form action="{{ route('login.post') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="no_induk_karyawan" class="form-label fw-semibold">Nomor Induk Karyawan</label>
                            <input type="text" name="no_induk_karyawan" id="no_induk_karyawan" class="form-control" placeholder="Nomor Induk Karyawan" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold">Password</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="************" required>
                        </div>

                        <div class="mb-3 text-end">
                            <a href="#" class="text-decoration-none text-muted small">Forgot password?</a>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-green">Sign in</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
