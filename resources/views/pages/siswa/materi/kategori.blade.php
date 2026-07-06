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
                <p class="hero-sub">Pilih materi yang ingin dilatih</p>
            </div>
        </div>
    </div>

    {{-- STEP INDICATOR --}}
    <div class="step-bar">
        <div class="step done">
            <div class="step-dot">
                <svg width="12" height="12" fill="none" viewBox="0 0 16 16">
                    <path d="M3 8l4 4 6-6" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <span>Pilih Kategori Materi</span>
        </div>
        <div class="step-line filled"></div>
        <div class="step active">
            <div class="step-dot">2</div>
            <span>Pilih Materi</span>
        </div>
        <div class="step-line"></div>
        <div class="step inactive">
            <div class="step-dot">3</div>
            <span>Mulai Latihan</span>
        </div>
    </div>

    {{-- BREADCRUMB / KEMBALI --}}
    <div class="breadcrumb-wrap">
        <a href="{{ route('siswa.materi.index') }}" class="breadcrumb-back">
            <svg width="16" height="16" fill="none" viewBox="0 0 16 16">
                <path d="M10 3L5 8l5 5" stroke="currentColor" stroke-width="1.5"
                      stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Kategori Materi
        </a>
        <span class="breadcrumb-sep">/</span>
        <span class="breadcrumb-current">
            @if($kategori == 'Abjad') Abjad
            @elseif($kategori == 'suku_kata') Suku Kata
            @else Kata Dasar
            @endif
        </span>
    </div>

    {{-- LIST MATERI --}}
    <div class="section-wrap">
        <div class="section-heading">
            <span class="section-num">02</span>
            <h2 class="section-title">
                @if($kategori == 'Abjad') Materi Abjad
                @elseif($kategori == 'suku_kata') Materi Suku Kata
                @else Materi Kata Dasar
                @endif
            </h2>
            @if($materiList->count())
                <span class="section-badge">{{ $materiList->count() }} materi</span>
            @endif
        </div>

        @if($materiList->count())
        <div class="materi-list">
            @foreach($materiList as $index => $item)
            <a href="{{ route('siswa.materi.show', $item->id_materi) }}" class="materi-item">
                <div class="materi-num">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</div>
                <div class="materi-body">
                    <div class="materi-text">{{ $item->teks_bacaan }}</div>
                    <div class="materi-meta">
                        <span class="meta-threshold">
                            <svg width="11" height="11" fill="none" viewBox="0 0 16 16">
                                <path d="M8 2l1.8 3.6L14 6.4l-3 2.9.7 4.1L8 11.3l-3.7 2.1.7-4.1L2 6.4l4.2-.8L8 2z"
                                      stroke="currentColor" stroke-width="1.3" stroke-linejoin="round"/>
                            </svg>
                            Threshold {{ $item->threshold * 100 }}%
                        </span>
                    </div>
                </div>
                <div class="materi-go">
                    <svg width="14" height="14" fill="none" viewBox="0 0 16 16">
                        <path d="M6 3l5 5-5 5" stroke="currentColor" stroke-width="1.5"
                              stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </a>
            @endforeach
        </div>
        @else
        <div class="empty-materi">
            <svg width="40" height="40" fill="none" viewBox="0 0 24 24">
                <path d="M4 19.5A2.5 2.5 0 016.5 17H20M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"
                      stroke="#c9c4bd" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <p>Belum ada materi untuk kategori ini</p>
        </div>
        @endif
    </div>

</div>
@endsection