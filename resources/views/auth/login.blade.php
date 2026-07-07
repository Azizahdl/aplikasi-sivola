<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIVOLA</title>

    <link rel="shortcut icon" type="image/png" href="{{ asset('layout/src/assets/images/logos/favicon.png') }}" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        * { box-sizing: border-box; }

        body {
            font-family: 'Poppins', Arial, sans-serif;
            background-color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            padding: 2rem 1rem;
        }

        .login-wrapper {
            width: 100%;
            max-width: 400px;
        }

        .card-login {
            background-color: #CFECF3;
            border-radius: 30px;
            padding: 2rem 1.75rem;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
        }

        /* ── Logo (di dalam card) ── */
        .logo-area {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .logo-area img {
            max-width: 72px;
            margin-bottom: 6px;
        }

        .logo-area .app-name {
            font-size: 1rem;
            font-weight: 600;
            color: #2d3748;
            margin: 0;
        }

        .logo-area .app-sub {
            font-size: 0.78rem;
            color: #4a6a7a;
            margin: 2px 0 0;
        }

        .section-divider {
            border: none;
            border-top: 1px solid rgba(255, 255, 255, 0.6);
            margin: 0 0 1.25rem;
        }

        .section-label {
            font-size: 0.68rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #5a8fa8;
            margin: 0 0 0.75rem;
        }

        .alert-danger {
            font-size: 0.8rem;
            border-radius: 12px;
            background-color: #fff5f5;
            border: 1px solid #feb2b2;
            color: #c53030;
            padding: 10px 14px;
            margin-bottom: 1rem;
        }

        .form-group { margin-bottom: 0.875rem; }

        .form-group label {
            font-size: 0.78rem;
            font-weight: 500;
            color: #2d5a6e;
            display: block;
            margin-bottom: 5px;
        }

        .input-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-wrap .input-icon {
            position: absolute;
            left: 12px;
            color: #73A5CA;
            font-size: 13px;
            pointer-events: none;
            z-index: 2;
        }

        .input-wrap .form-control {
            padding: 9px 12px 9px 35px;
            font-size: 0.82rem;
            font-family: 'Poppins', Arial, sans-serif;
            background-color: #fff;
            border: 1px solid #73A5CA;
            border-radius: 20px;
            color: #2d3748;
            height: auto;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .input-wrap .form-control:focus {
            border-color: #fff;
            box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.5);
            outline: none;
        }

        .input-wrap .form-control.is-invalid { border-color: #e53e3e; }

        .text-danger { font-size: 0.74rem; margin-top: 4px; display: block; }

        .toggle-eye {
            position: absolute;
            right: 12px;
            cursor: pointer;
            color: #73A5CA;
            font-size: 13px;
            z-index: 2;
            transition: color 0.2s;
        }

        .toggle-eye:hover { color: #2d5a6e; }

        .forgot-row {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 0.25rem;
        }

        .forgot-link {
            font-size: 0.76rem;
            color: #2d5a6e;
            text-decoration: none;
            transition: color 0.2s;
        }

        .forgot-link:hover { color: #E87F24; text-decoration: none; }

        .btn-login {
            width: 100%;
            padding: 10px;
            font-size: 0.875rem;
            font-weight: 600;
            font-family: 'Poppins', Arial, sans-serif;
            background-color: #E87F24;
            color: #fff;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            margin-top: 0.5rem;
            transition: background-color 0.3s, color 0.3s;
        }

        .btn-login:hover { background-color: #fff; color: #E87F24; }

        .footer-text {
            text-align: center;
            font-size: 0.8rem;
            color: #4a6a7a;
            margin-top: 1rem;
            margin-bottom: 0;
        }

        .footer-text a { color: #2d5a6e; font-weight: 600; text-decoration: none; }
        .footer-text a:hover { color: #E87F24; }

        @media (max-width: 576px) {
            .card-login { padding: 1.5rem 1.25rem; }
        }
        @media (max-width: 400px) {
            body { padding: 1.5rem 0.75rem; }
            .card-login { padding: 1.25rem 1rem; border-radius: 24px; }
            .logo-area img { max-width: 60px; }
        }
    </style>
</head>

<body>
    <div class="login-wrapper">
        <div class="card-login">

            {{-- Logo di dalam card --}}
            <div class="logo-area">
                <img src="{{ asset('frontend/assets/images/logo/logo1.png') }}" alt="Logo Aplikasi">
                {{-- <p class="app-name">Sistem Validasi</p>
                <p class="app-sub">Masuk ke akun Anda</p> --}}
            </div>

            {{-- <hr class="section-divider"> --}}

            @if (session('error'))
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle mr-1"></i>
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- <p class="section-label">Informasi Akun</p> --}}

                {{-- Email --}}
                <div class="form-group">
                    <label for="email">Email</label>
                    <div class="input-wrap">
                        <i class="fas fa-user input-icon"></i>
                        <input id="email" type="text" name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            placeholder="Masukkan email"
                            value="{{ old('email') }}"
                            autofocus autocomplete="email">
                    </div>
                    @error('email')
                        <span class="text-danger">{!! $message !!}</span>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrap">
                        <i class="fas fa-lock input-icon"></i>
                        <input id="password" type="password" name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="Masukkan password"
                            autocomplete="current-password">
                        <span class="toggle-eye" id="togglePassword">
                            <i class="fas fa-eye" id="eyeIcon"></i>
                        </span>
                    </div>
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Lupa password --}}
                @if (Route::has('password.request'))
                    <div class="forgot-row">
                        <a href="{{ route('password.request') }}" class="forgot-link">Lupa password?</a>
                    </div>
                @endif

                <button type="submit" class="btn-login">Log in</button>

                <p class="footer-text">
                    Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a>
                </p>

            </form>
        </div>
    </div>

    <script>
        document.getElementById('togglePassword').addEventListener('click', function () {
            const input = document.getElementById('password');
            const icon = document.getElementById('eyeIcon');
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