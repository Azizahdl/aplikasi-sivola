<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - SIVOLA</title>

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

        .register-wrapper {
            width: 100%;
            max-width: 440px;
        }

        .card-register {
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

        .section-label.mt { margin-top: 1.25rem; }

        .form-group { margin-bottom: 0.875rem; }

        .form-group label {
            font-size: 0.78rem;
            font-weight: 500;
            color: #2d5a6e;
            display: block;
            margin-bottom: 5px;
        }

        .badge-opsional {
            font-size: 0.63rem;
            font-weight: 500;
            color: #5a8fa8;
            background: rgba(255,255,255,0.5);
            border: 1px solid rgba(115,165,202,0.4);
            border-radius: 4px;
            padding: 1px 6px;
            margin-left: 5px;
            vertical-align: middle;
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

        .input-wrap .form-control,
        .input-wrap select.form-control {
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

        .input-wrap .form-control:focus,
        .input-wrap select.form-control:focus {
            border-color: #fff;
            box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.5);
            outline: none;
        }

        .input-wrap .form-control.is-invalid,
        .input-wrap select.form-control.is-invalid { border-color: #e53e3e; }

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

        .row-2col {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.75rem;
        }

        @media (max-width: 400px) {
            .row-2col { grid-template-columns: 1fr; }
        }

        .btn-register {
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

        .btn-register:hover { background-color: #fff; color: #E87F24; }

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
            .card-register { padding: 1.5rem 1.25rem; }
        }
    </style>
</head>

<body>
    <div class="register-wrapper">
        <div class="card-register">

            {{-- Logo di dalam card --}}
            <div class="logo-area">
                <img src="{{ asset('frontend/assets/images/logo/logo1.png') }}" alt="Logo Aplikasi">
                {{-- <p class="app-name">Sistem Validasi</p>
                <p class="app-sub">Buat akun baru untuk melanjutkan</p> --}}
            </div>

            {{-- <hr class="section-divider"> --}}

            <form method="POST" action="{{ route('register') }}">
                @csrf
{{-- 
                <p class="section-label">Informasi Pribadi</p> --}}

                {{-- Nama --}}
                <div class="form-group">
                    <label for="nama">Nama lengkap</label>
                    <div class="input-wrap">
                        <i class="fas fa-user input-icon"></i>
                        <input id="nama" type="text" name="nama"
                            class="form-control @error('nama') is-invalid @enderror"
                            placeholder="Masukkan nama lengkap"
                            value="{{ old('nama') }}" required>
                    </div>
                    @error('nama')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="form-group">
                    <label for="email">Alamat email</label>
                    <div class="input-wrap">
                        <i class="fas fa-envelope input-icon"></i>
                        <input id="email" type="email" name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            placeholder="contoh@email.com"
                            value="{{ old('email') }}" required>
                    </div>
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                {{-- NIS & NISN --}}
                <div class="row-2col">
                    <div class="form-group">
                        <label for="nis">NIS</label>
                        <div class="input-wrap">
                            <i class="fas fa-id-card input-icon"></i>
                            <input id="nis" type="text" name="nis"
                                class="form-control @error('nis') is-invalid @enderror"
                                placeholder="Nomor Induk Siswa"
                                value="{{ old('nis') }}" required>
                        </div>
                        @error('nis')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="nisn">NISN <span class="badge-opsional">opsional</span></label>
                        <div class="input-wrap">
                            <i class="fas fa-id-card-alt input-icon"></i>
                            <input id="nisn" type="text" name="nisn"
                                class="form-control @error('nisn') is-invalid @enderror"
                                placeholder="NISN"
                                value="{{ old('nisn') }}">
                        </div>
                        @error('nisn')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- Tanggal Lahir & Jenis Kelamin --}}
                <div class="row-2col">
                    <div class="form-group">
                        <label for="tanggal_lahir">Tanggal lahir</label>
                        <div class="input-wrap">
                            <i class="fas fa-calendar-alt input-icon"></i>
                            <input id="tanggal_lahir" type="date" name="tanggal_lahir"
                                class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                value="{{ old('tanggal_lahir') }}" required>
                        </div>
                        @error('tanggal_lahir')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="jenis_kelamin">Jenis kelamin</label>
                        <div class="input-wrap">
                            <i class="fas fa-venus-mars input-icon"></i>
                            <select id="jenis_kelamin" name="jenis_kelamin"
                                class="form-control @error('jenis_kelamin') is-invalid @enderror" required>
                                <option value="" disabled selected>Pilih</option>
                                <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                        @error('jenis_kelamin')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <hr class="section-divider">

                <p class="section-label mt">Kata Sandi</p>

                {{-- Password --}}
                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrap">
                        <i class="fas fa-lock input-icon"></i>
                        <input id="password" type="password" name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="Buat password" required>
                        <span class="toggle-eye" id="togglePassword">
                            <i class="fas fa-eye" id="eyeIcon1"></i>
                        </span>
                    </div>
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Konfirmasi Password --}}
                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi password</label>
                    <div class="input-wrap">
                        <i class="fas fa-lock input-icon"></i>
                        <input id="password_confirmation" type="password" name="password_confirmation"
                            class="form-control"
                            placeholder="Ulangi password" required>
                        <span class="toggle-eye" id="togglePasswordConfirm">
                            <i class="fas fa-eye" id="eyeIcon2"></i>
                        </span>
                    </div>
                </div>

                <button type="submit" class="btn-register">Daftar Sekarang</button>

                <p class="footer-text">
                    Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a>
                </p>

            </form>
        </div>
    </div>

    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }

        document.getElementById('togglePassword').addEventListener('click', () => togglePassword('password', 'eyeIcon1'));
        document.getElementById('togglePasswordConfirm').addEventListener('click', () => togglePassword('password_confirmation', 'eyeIcon2'));
    </script>
</body>
</html>