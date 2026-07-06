<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Sistem Validasi</title>

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

        .forgot-wrapper {
            width: 100%;
            max-width: 400px;
        }

        .card-forgot {
            background-color: #CFECF3;
            border-radius: 30px;
            padding: 2rem 1.75rem;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
        }

        /* ── Logo di dalam card ── */
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
            margin: 0 0 0.5rem;
        }

        .desc-text {
            font-size: 0.78rem;
            color: #4a6a7a;
            line-height: 1.7;
            margin-bottom: 1rem;
        }

        /* ── Alert sukses ── */
        .alert-success {
            font-size: 0.78rem;
            border-radius: 12px;
            background-color: #f0fff4;
            border: 1px solid #9ae6b4;
            color: #276749;
            padding: 10px 14px;
            margin-bottom: 1rem;
        }

        /* ── Form group ── */
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

        .btn-forgot {
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

        .btn-forgot:hover { background-color: #fff; color: #E87F24; }

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
            .card-forgot { padding: 1.5rem 1.25rem; }
        }
    </style>
</head>

<body>
    <div class="forgot-wrapper">
        <div class="card-forgot">

            {{-- Logo di dalam card --}}
            <div class="logo-area">
                <img src="{{ asset('frontend/assets/images/logo/logo1.png') }}" alt="Logo Aplikasi">
            </div>

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <p class="section-label">Lupa Password</p>
                <p class="desc-text">
                    Masukkan email kamu, kami akan kirim link untuk reset password.
                </p>

                {{-- Status sukses --}}
                @if (session('status'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle mr-1"></i>
                        {{ session('status') }}
                    </div>
                @endif

                {{-- Email --}}
                <div class="form-group">
                    <label for="email">Alamat email</label>
                    <div class="input-wrap">
                        <i class="fas fa-envelope input-icon"></i>
                        <input id="email" type="email" name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            placeholder="Masukkan email"
                            value="{{ old('email') }}"
                            required autofocus>
                    </div>
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn-forgot">
                    Kirim Link Reset
                </button>

                <p class="footer-text">
                    Sudah ingat password? <a href="{{ route('login') }}">Login di sini</a>
                </p>

            </form>
        </div>
    </div>
</body>

</html>