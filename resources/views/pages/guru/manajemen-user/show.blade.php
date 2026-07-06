@extends('layouts.guru')

@push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/guru/manajemen-user/show.css') }}">
@endpush

@section('content')
<div class="container-fluid">
    <div class="show-page">
        <div class="show-card">

            {{-- HEADER --}}
            <div class="show-header">
                <div>
                    <div class="head-title">Detail Pengguna</div>
                    <div class="head-subtitle">Informasi lengkap akun pengguna</div>
                </div>
                <a href="{{ route('guru.manajemen-user.index') }}" class="btn-back">
                    <svg width="13" height="13" fill="none" viewBox="0 0 16 16">
                        <path d="M10 3L5 8l5 5" stroke="currentColor" stroke-width="1.5"
                              stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Kembali
                </a>
            </div>

            {{-- BODY --}}
            <div class="show-body">

                {{-- AVATAR COLUMN --}}
                <div class="profile-col">
                    @php
                        $initials = collect(explode(' ', $user->nama))
                            ->take(2)->map(fn($w) => strtoupper(substr($w,0,1)))->join('');
                        $avColors = [
                            ['bg'=>'#EBF3FA','color'=>'#0C447C'],
                            ['bg'=>'#FAEEDA','color'=>'#633806'],
                            ['bg'=>'#E1F5EE','color'=>'#085041'],
                            ['bg'=>'#FBEAF0','color'=>'#72243E'],
                            ['bg'=>'#EEEDFE','color'=>'#3C3489'],
                        ];
                        $av = $avColors[$user->id % count($avColors)];
                    @endphp

                    @if($user->foto_profile)
                        <div class="avatar-wrap">
                            <img src="{{ asset('storage/' . $user->foto_profile) }}"
                                 alt="{{ $user->nama }}">
                        </div>
                    @else
                        <div class="avatar-initials"
                             style="background:{{ $av['bg'] }};color:{{ $av['color'] }};">
                            {{ $initials }}
                        </div>
                    @endif

                    <div class="profile-name">{{ $user->nama }}</div>
                    <div class="profile-role">
                        @if($user->role == 'guru')
                            <span class="badge-pill b-guru">Guru</span>
                        @else
                            <span class="badge-pill b-siswa">Siswa</span>
                        @endif
                    </div>

                    {{-- STATUS --}}
                    <div>
                        @if($user->status_akun == 'aktif')
                            <span class="badge-pill b-aktif">
                                <span class="dot dot-a"></span> Aktif
                            </span>
                        @elseif($user->status_akun == 'nonaktif')
                            <span class="badge-pill b-nonaktif">
                                <span class="dot dot-n"></span> Nonaktif
                            </span>
                        @else
                            <span class="badge-pill b-suspend">
                                <span class="dot dot-s"></span> Suspend
                            </span>
                        @endif
                    </div>
                </div>

                {{-- INFO COLUMN --}}
                <div class="info-col">

                    <div class="info-section">
                        <div class="info-section-title">Informasi Akun</div>
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="info-label">Nama Lengkap</div>
                                <div class="info-value">{{ $user->nama }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Email</div>
                                <div class="info-value">{{ $user->email }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Role</div>
                                <div class="info-value">
                                    @if($user->role == 'guru')
                                        <span class="badge-pill b-guru">Guru</span>
                                    @else
                                        <span class="badge-pill b-siswa">Siswa</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="info-section" style="margin-bottom:0;">
                        <div class="info-section-title">Riwayat Akun</div>
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="info-label">Akun Dibuat</div>
                                <div class="info-value muted">
                                    {{ $user->created_at->format('d F Y, H:i') }}
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Terakhir Diperbarui</div>
                                <div class="info-value muted">
                                    {{ $user->updated_at->format('d F Y, H:i') }}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- FOOTER --}}
            <div class="show-footer">
                <a href="{{ route('guru.manajemen-user.edit', $user->id) }}" class="btn-edit">
                    <svg width="14" height="14" fill="none" viewBox="0 0 16 16">
                        <path d="M11 3l2 2-7 7H4v-2l7-7z" stroke="#fff"
                              stroke-width="1.4" stroke-linejoin="round"/>
                    </svg>
                    Edit Pengguna
                </a>
            </div>

        </div>
    </div>
</div>
@endsection