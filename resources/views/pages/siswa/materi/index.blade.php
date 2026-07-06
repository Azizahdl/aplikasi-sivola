@extends('layouts.siswa')

@push('styles')
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/siswa/materi/index.css') }}">
@endpush

@section('content')
<div class="container-fluid">

    {{-- HERO HEADER --}}
    <div class="hero-header">
        <div class="hero-inner">
            <div class="hero-icon">
                <svg width="28" height="28" fill="none" viewBox="0 0 24 24">
                    <path d="M12 2a9 9 0 100 18A9 9 0 0012 2z" stroke="#fff" stroke-width="1.5"/>
                    <path d="M12 8v4l3 2" stroke="#fff" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
            </div>
            <div>
                <h1 class="hero-title">Materi Latihan Membaca</h1>
                <p class="hero-sub">Pilih kategori materidan mulai latihan membaca</p>
            </div>
        </div>
    </div>

    {{-- STEP INDICATOR --}}
    <div class="step-bar">
        <div class="step active">
            <div class="step-dot">1</div>
            <span>Pilih Kategori Materi</span>
        </div>
        <div class="step-line"></div>
        <div class="step inactive">
            <div class="step-dot">2</div>
            <span>Pilih Materi</span>
        </div>
        <div class="step-line"></div>
        <div class="step inactive">
            <div class="step-dot">3</div>
            <span>Mulai Latihan</span>
        </div>
    </div>

    {{-- PILIH KATEGORI --}}
    <div class="section-wrap">
        <div class="section-heading">
            <span class="section-num">01</span>
            <h2 class="section-title">Pilih Kategori Materi</h2>
        </div>

        <div class="kategori-grid">
            {{-- ABJAD --}}
            <a href="{{ route('siswa.materi.kategori', 'Abjad') }}" class="kategori-card k-blue">
                <div class="k-icon">
                    <svg width="28" height="28" fill="none" viewBox="0 0 24 24">
                        <path d="M4 20l4-10 4 10M6 15h4M16 4v16M13 7h6" stroke="currentColor" stroke-width="1.6"
                              stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <div class="k-info">
                    <div class="k-name">Abjad</div>
                    <div class="k-desc">Pengenalan huruf A–Z</div>
                </div>
                <div class="k-arrow">
                    <svg width="16" height="16" fill="none" viewBox="0 0 16 16">
                        <path d="M6 3l5 5-5 5" stroke="currentColor" stroke-width="1.5"
                              stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </a>

            {{-- SUKU KATA --}}
            <a href="{{ route('siswa.materi.kategori', 'suku_kata') }}" class="kategori-card k-green">
                <div class="k-icon">
                    <svg width="28" height="28" fill="none" viewBox="0 0 24 24">
                        <path d="M3 7h18M3 12h12M3 17h8" stroke="currentColor" stroke-width="1.6"
                              stroke-linecap="round"/>
                    </svg>
                </div>
                <div class="k-info">
                    <div class="k-name">Suku Kata</div>
                    <div class="k-desc">Latihan membaca suku kata</div>
                </div>
                <div class="k-arrow">
                    <svg width="16" height="16" fill="none" viewBox="0 0 16 16">
                        <path d="M6 3l5 5-5 5" stroke="currentColor" stroke-width="1.5"
                              stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </a>

            {{-- KATA DASAR --}}
            <a href="{{ route('siswa.materi.kategori', 'kata_dasar') }}" class="kategori-card k-orange">
                <div class="k-icon">
                    <svg width="28" height="28" fill="none" viewBox="0 0 24 24">
                        <rect x="3" y="5" width="18" height="14" rx="2" stroke="currentColor" stroke-width="1.6"/>
                        <path d="M8 10h8M8 14h5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                    </svg>
                </div>
                <div class="k-info">
                    <div class="k-name">Kata Dasar</div>
                    <div class="k-desc">Latihan membaca kata sederhana</div>
                </div>
                <div class="k-arrow">
                    <svg width="16" height="16" fill="none" viewBox="0 0 16 16">
                        <path d="M6 3l5 5-5 5" stroke="currentColor" stroke-width="1.5"
                              stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </a>
        </div>
    </div>

</div>
@endsection