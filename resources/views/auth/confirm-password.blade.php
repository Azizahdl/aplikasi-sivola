<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Password</title>

    <link rel="shortcut icon" type="image/png" href="{{ asset('layout/src/assets/images/logos/favicon.png') }}" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/login.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>

<body>
    <div class="login-container">

        <!-- LOGO -->
        <div>
            <img src="{{ asset('frontend/assets/images/logo/logo1.png') }}" alt="Logo Aplikasi" style="width:120px;">
        </div>

        <!-- DESKRIPSI -->
        <p style="font-size: 13px; color: #666; margin-top: 10px;">
            Ini adalah area aman. Harap konfirmasi password kamu sebelum melanjutkan.
        </p>

        <!-- FORM -->
        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <!-- Password -->
            <div class="form-group mt-3">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fas fa-lock"></i>
                        </span>
                    </div>
                    <input id="password"
                           class="form-control @error('password') is-invalid @enderror"
                           type="password"
                           name="password"
                           placeholder="Password"
                           required autocomplete="current-password">
                    <span class="show-password" id="togglePassword">
                        <i class="fas fa-eye"></i>
                    </span>
                </div>
                @error('password')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <!-- BUTTON -->
            <button type="submit" class="btn btn-login">
                Konfirmasi
            </button>

            <!-- BACK TO LOGIN -->
            <p class="mt-3 text-center">
                <a href="{{ route('login') }}" style="font-weight: 600; color: #007bff;">
                    Kembali ke Login
                </a>
            </p>

        </form>
    </div>

    <script>
        document.getElementById('togglePassword').addEventListener('click', function () {
            const input = document.getElementById('password');
            const icon = this.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        });
    </script>

</body>
</html>