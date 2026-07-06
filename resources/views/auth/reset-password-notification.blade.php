<!DOCTYPE html>
<html lang="id" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Reset Kata Sandi - {{ config('app.name') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            background-color: #fff;
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, sans-serif;
            -webkit-font-smoothing: antialiased;
            color: #333;
        }

        .wrapper { width: 100%; padding: 40px 16px; }

        .card {
            max-width: 520px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 30px;
            overflow: hidden;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
        }

        /* ── Header ── */
        .header {
            background-color: #CFECF3;
            padding: 32px 40px 28px;
            text-align: center;
        }

        .logo-img {
            max-width: 64px;
            margin-bottom: 8px;
        }

        .app-name {
            font-size: 1rem;
            font-weight: 600;
            color: #2d3748;
            margin: 0;
        }

        .app-sub {
            font-size: 0.75rem;
            font-weight: 400;
            color: #4a6a7a;
            margin-top: 2px;
        }

        /* ── Icon kunci mengambang ── */
        .icon-wrap {
            width: 58px;
            height: 58px;
            background: #ffffff;
            border-radius: 50%;
            margin: -29px auto 0;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
            position: relative;
            z-index: 2;
            border: 1px solid #e2f4f8;
        }

        /* ── Body ── */
        .body { padding: 32px 40px 28px; }

        .section-divider {
            border: none;
            border-top: 1px solid #e2f4f8;
            margin: 0 0 1.5rem;
        }

        .heading {
            font-size: 1rem;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 8px;
        }

        .text {
            font-size: 0.82rem;
            font-weight: 400;
            color: #4a6a7a;
            line-height: 1.8;
            margin-bottom: 24px;
        }

        /* ── Tombol ── */
        .btn-wrap { text-align: center; margin: 24px 0; }

        .btn {
            display: inline-block;
            background: #E87F24;
            color: #ffffff !important;
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
            padding: 11px 36px;
            border-radius: 20px;
            letter-spacing: 0.02em;
            transition: background-color 0.3s;
        }

        /* ── Warning box ── */
        .warning-box {
            background: #fff8f0;
            border: 1px solid #fcd9a8;
            border-radius: 14px;
            padding: 13px 16px;
            margin-bottom: 24px;
            display: flex;
            gap: 10px;
            align-items: flex-start;
        }

        .warning-icon { flex-shrink: 0; margin-top: 2px; }

        .warning-text {
            font-size: 0.78rem;
            color: #7c4a0e;
            line-height: 1.65;
        }

        .divider {
            border: none;
            border-top: 1px solid #e2f4f8;
            margin: 20px 0;
        }

        .ignore-note {
            font-size: 0.75rem;
            font-weight: 300;
            color: #718096;
            line-height: 1.75;
            margin-bottom: 16px;
        }

        .fallback-label {
            font-size: 0.72rem;
            color: #a0aec0;
            margin-bottom: 6px;
        }

        .fallback-link {
            font-size: 0.7rem;
            color: #73A5CA;
            word-break: break-all;
            text-decoration: none;
        }

        /* ── Footer ── */
        .footer {
            background-color: #CFECF3;
            border-top: 1px solid rgba(255,255,255,0.6);
            padding: 18px 40px;
            text-align: center;
        }

        .footer-text {
            font-size: 0.7rem;
            font-weight: 300;
            color: #4a6a7a;
            line-height: 1.8;
        }

        @media only screen and (max-width: 560px) {
            .body   { padding: 24px 20px; }
            .header { padding: 24px 20px 20px; }
            .footer { padding: 16px 20px; }
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="card">

            {{-- HEADER --}}
            <div class="header">
                <img src="{{ asset('frontend/assets/images/logo/logo1.png') }}" alt="Logo" class="logo-img">
                <p class="app-name">{{ config('app.name') }}</p>
                <p class="app-sub">Aplikasi Belajar Membaca</p>
            </div>

            {{-- Icon kunci mengambang --}}
            <div class="icon-wrap">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                     stroke="#E87F24" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                </svg>
            </div>

            {{-- BODY --}}
            <div class="body">

                <hr class="section-divider" style="margin-top: 1.5rem;">

                <p class="heading">Reset Kata Sandi</p>

                <p class="text">
                    Halo{!! isset($notifiable->nama) ? ', <strong>' . $notifiable->nama . '</strong>' : '' !!}!
                    Kami menerima permintaan untuk mereset kata sandi akun yang terhubung
                    dengan alamat email ini. Klik tombol di bawah untuk melanjutkan.
                </p>

                {{-- CTA --}}
                <div class="btn-wrap">
                    <a href="{{ $url }}" class="btn">
                        Atur Ulang Kata Sandi &rarr;
                    </a>
                </div>

                {{-- Warning --}}
                <div class="warning-box">
                    <div class="warning-icon">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none"
                             stroke="#E87F24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                            <line x1="12" y1="9" x2="12" y2="13"/>
                            <line x1="12" y1="17" x2="12.01" y2="17"/>
                        </svg>
                    </div>
                    <span class="warning-text">
                        Link ini hanya berlaku selama <strong>{{ $count }} menit</strong>.
                        Jika sudah kedaluwarsa, ajukan permintaan reset ulang dari halaman login.
                    </span>
                </div>

                <hr class="divider">

                <p class="ignore-note">
                    Jika kamu tidak merasa meminta reset kata sandi, abaikan saja email ini —
                    tidak ada perubahan yang akan terjadi pada akunmu.
                </p>

                <p class="fallback-label">Tombol tidak berfungsi? Salin link ini ke browser kamu:</p>
                <a href="{{ $url }}" class="fallback-link">{{ $url }}</a>

            </div>

            {{-- FOOTER --}}
            <div class="footer">
                <p class="footer-text">
                    Email ini dikirim otomatis oleh <strong>{{ config('app.name') }}</strong>.<br>
                    Mohon jangan membalas email ini. &nbsp;&bull;&nbsp;
                    &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                </p>
            </div>

        </div>
    </div>
</body>
</html>