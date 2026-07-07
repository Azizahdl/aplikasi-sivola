<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profil Saya') }}
        </h2>
    </x-slot>

    {{-- Pakai CSS dashboard yang sama biar 1 gaya visual di seluruh web --}}
    <link href="{{ asset('frontend/assets/css/siswa/dashboard/dashboard.css') }}" rel="stylesheet">

    <style>
        .profile-wrapper {
            max-width: 780px;
            margin: 0 auto;
            padding: 1.5rem 1rem 3rem;
        }

        /* ── Header Profil ── */
        .profile-header-card {
            background: linear-gradient(120deg, var(--primary-dark) 0%, var(--primary) 55%, var(--secondary) 100%);
            border-radius: 20px;
            padding: 2rem 1.75rem;
            display: flex;
            align-items: center;
            gap: 18px;
            margin-bottom: 1.5rem;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 25px -8px rgba(232, 101, 10, 0.35);
        }

        .profile-header-card .bdeco {
            position: absolute;
            border-radius: 50%;
            border: 30px solid rgba(255,255,255,.10);
            pointer-events: none;
        }
        .profile-header-card .bdeco.d1 { width: 180px; height: 180px; right: -50px; top: -60px; }
        .profile-header-card .bdeco.d2 { width: 90px; height: 90px; right: 90px; bottom: -40px; border-width: 16px; }

        .profile-avatar {
            width: 68px;
            height: 68px;
            border-radius: 50%;
            background: rgba(255,255,255,0.25);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            font-weight: 800;
            flex-shrink: 0;
            text-transform: uppercase;
            border: 3px solid rgba(255,255,255,0.4);
            position: relative;
            z-index: 1;
        }

        .profile-header-text {
            position: relative;
            z-index: 1;
            min-width: 0; /* biar teks panjang bisa wrap/truncate, bukan dorong layout */
        }

        .profile-name {
            font-size: 19px;
            font-weight: 800;
            color: #fff;
            margin-bottom: 3px;
            word-break: break-word;
        }

        .profile-email {
            font-size: 13px;
            color: rgba(255,255,255,0.9);
            display: flex;
            align-items: center;
            gap: 6px;
            word-break: break-all; /* email panjang nggak nembus card */
        }

        .profile-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            margin-top: 8px;
            background: rgba(255,255,255,0.2);
            color: #fff;
            font-size: 11px;
            font-weight: 700;
            padding: 4px 12px;
            border-radius: 999px;
            position: relative;
            z-index: 1;
        }

        /* ── Section & Card ── */
        .profile-section { margin-bottom: 1.25rem; }

        .profile-section .main-card {
            transition: transform .2s, box-shadow .2s;
        }
        .profile-section .main-card:hover {
            box-shadow: 0 8px 20px -10px rgba(0,0,0,0.12);
        }

        .profile-section-head {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 18px;
            padding-bottom: 14px;
            border-bottom: 0.5px solid var(--border);
        }

        .profile-section-icon {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .profile-section.danger .main-card { border-color: #f6c9b8 !important; }
        .profile-section.danger .profile-section-head { border-bottom-color: #f6c9b8; }

        /* ── Rapikan form bawaan Breeze biar senada ── */
        .profile-section label {
            font-size: 13px;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 6px;
            display: inline-block;
        }

        .profile-section input[type="text"],
        .profile-section input[type="email"],
        .profile-section input[type="password"] {
            width: 100%;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 13.5px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--dark);
            background: #fbfaf8;
            transition: border-color .2s, box-shadow .2s;
            box-sizing: border-box; /* penting biar padding gak bikin overflow di layar kecil */
        }

        .profile-section input:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px var(--accent-light);
            background: #fff;
        }

        .profile-section button[type="submit"],
        .profile-section .main-card button {
            background: var(--primary-dark);
            color: #fff;
            font-size: 13px;
            font-weight: 700;
            padding: 10px 22px;
            border-radius: 10px;
            border: none;
            cursor: pointer;
            transition: opacity .2s, transform .2s;
        }
        .profile-section button[type="submit"]:hover,
        .profile-section .main-card button:hover {
            opacity: .9;
            transform: translateY(-1px);
        }

        .profile-section.danger button[type="submit"],
        .profile-section.danger button {
            background: var(--danger-custom);
        }

        /* Tombol Batal/Cancel di modal hapus akun jangan ikut oren/merah */
        .profile-section.danger .main-card button.text-gray-700,
        .profile-section.danger .main-card button[type="button"] {
            background: #fff;
            color: var(--dark);
            border: 1.5px solid var(--border);
        }

        /* ══════════ RESPONSIVE ══════════ */

        /* Tablet */
        @media (max-width: 768px) {
            .profile-wrapper {
                max-width: 100%;
                padding: 1.25rem 1rem 2.5rem;
            }

            .profile-section .main-card {
                padding: 18px;
            }
        }

        /* Mobile besar (HP standar) */
        @media (max-width: 576px) {
            .profile-wrapper { padding: 1rem 0.75rem 2rem; }

            .profile-header-card {
                padding: 1.5rem 1.25rem;
                gap: 12px;
                border-radius: 16px;
            }

            .profile-avatar {
                width: 54px;
                height: 54px;
                font-size: 18px;
                border-width: 2px;
            }

            .profile-name { font-size: 16px; }
            .profile-email { font-size: 11.5px; }
            .profile-badge {
                font-size: 10px;
                padding: 3px 10px;
            }

            .profile-section-head {
                gap: 10px;
                margin-bottom: 14px;
                padding-bottom: 12px;
            }

            .profile-section-icon {
                width: 34px;
                height: 34px;
                border-radius: 10px;
            }

            .profile-section .main-card { padding: 16px; }

            .card-title { font-size: 13px; }
            .card-sub { font-size: 11.5px; }

            .profile-section input[type="text"],
            .profile-section input[type="email"],
            .profile-section input[type="password"] {
                font-size: 13px;
                padding: 9px 12px;
            }

            .profile-section button[type="submit"],
            .profile-section .main-card button {
                font-size: 12.5px;
                padding: 9px 18px;
                width: 100%;
                justify-content: center;
            }
        }

        /* Mobile kecil */
        @media (max-width: 380px) {
            .profile-header-card {
                flex-direction: column;
                align-items: flex-start;
                text-align: left;
                padding: 1.25rem 1rem;
            }

            .profile-avatar {
                width: 48px;
                height: 48px;
                font-size: 16px;
            }

            .bdeco.d2 { display: none; }
        }
    </style>

    @php
        $initials = collect(explode(' ', auth()->user()->nama ?? 'Pengguna'))
            ->take(2)->map(fn($w) => strtoupper(substr($w, 0, 1)))->join('');
    @endphp

    <div class="profile-wrapper">

        {{-- HEADER PROFIL --}}
        <div class="profile-header-card">
            <div class="bdeco d1"></div>
            <div class="bdeco d2"></div>

            <div class="profile-avatar">{{ $initials }}</div>
            <div class="profile-header-text">
                <div class="profile-name">{{ auth()->user()->nama ?? 'Pengguna' }}</div>
                <div class="profile-email">
                    <i class="ti-email" style="font-size:12px;"></i>
                    {{ auth()->user()->email ?? '-' }}
                </div>
                <div class="profile-badge">
                    <i class="ti-user" style="font-size:11px;"></i>
                    Siswa Aktif
                </div>
            </div>
        </div>

        {{-- INFORMASI PROFIL --}}
        <div class="profile-section">
            <div class="main-card">
                <div class="profile-section-head">
                    <div class="profile-section-icon" style="background:var(--accent-light); color:var(--accent);">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24">
                            <circle cx="12" cy="8" r="4" stroke="currentColor" stroke-width="1.7"/>
                            <path d="M4 20c0-4 3.5-6.5 8-6.5s8 2.5 8 6.5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <div>
                        <div class="card-title" style="margin-bottom:1px;">Informasi Profil</div>
                        <div class="card-sub" style="margin-bottom:0;">Kelola nama dan email akunmu di sini</div>
                    </div>
                </div>
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        {{-- UBAH PASSWORD --}}
        <div class="profile-section">
            <div class="main-card">
                <div class="profile-section-head">
                    <div class="profile-section-icon" style="background:var(--success-light); color:var(--success);">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24">
                            <rect x="5" y="11" width="14" height="9" rx="2" stroke="currentColor" stroke-width="1.7"/>
                            <path d="M8 11V7a4 4 0 018 0v4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <div>
                        <div class="card-title" style="margin-bottom:1px;">Keamanan Akun</div>
                        <div class="card-sub" style="margin-bottom:0;">Perbarui password akunmu secara berkala ya!</div>
                    </div>
                </div>
                @include('profile.partials.update-password-form')
            </div>
        </div>

        {{-- HAPUS AKUN --}}
        <div class="profile-section danger">
            <div class="main-card">
                <div class="profile-section-head">
                    <div class="profile-section-icon" style="background:var(--danger-light); color:var(--danger-custom);">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24">
                            <path d="M4 7h16M9 7V5a2 2 0 012-2h2a2 2 0 012 2v2m-7 0v12a2 2 0 002 2h6a2 2 0 002-2V7" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div>
                        <div class="card-title" style="margin-bottom:1px;">Zona Berbahaya</div>
                        <div class="card-sub" style="margin-bottom:0;">Hapus akun secara permanen, hati-hati ya!</div>
                    </div>
                </div>
                @include('profile.partials.delete-user-form')
            </div>
        </div>

    </div>
</x-app-layout>