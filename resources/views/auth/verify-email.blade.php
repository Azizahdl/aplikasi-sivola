<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email</title>

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
            Terima kasih sudah mendaftar! Sebelum mulai, harap verifikasi email kamu dengan mengklik link yang sudah kami kirimkan ke email kamu.
        </p>

        <!-- STATUS -->
        @if (session('status') == 'verification-link-sent')
            <div class="alert alert-success" style="font-size: 13px;">
                Link verifikasi baru telah dikirim ke email kamu.
            </div>
        @endif

        <!-- TOMBOL KIRIM ULANG -->
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn btn-login mt-3">
                <i class="fas fa-paper-plane mr-1"></i> Kirim Ulang Email Verifikasi
            </button>
        </form>

        <!-- TOMBOL LOGOUT -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-outline-secondary btn-block mt-2" style="border-radius: 8px; font-size: 13px;">
                <i class="fas fa-sign-out-alt mr-1"></i> Logout
            </button>
        </form>

    </div>
</body>
</html>