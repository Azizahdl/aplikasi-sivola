@extends('layouts.siswa')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('frontend/assets/css/siswa/dashboard/dashboard.css') }}" rel="stylesheet">

    <div class="db-wrapper mt-0 pt-0">

        {{-- WELCOME BANNER --}}
        <div class="welcome-banner mb-3">
            <div class="bdeco d1"></div>
            <div class="bdeco d2"></div>
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="banner-text">
                    <h2>Halo, {{ Auth::user()->nama ?? 'Siswa' }} </h2>
                    <p>Semangat berlatih dan tingkatkan kemampuan membacamu!</p>
                    <div class="banner-date">
                        <svg width="12" height="12" fill="none" viewBox="0 0 16 16">
                            <rect x="1" y="3" width="14" height="12" rx="2" stroke="rgba(255,255,255,0.7)"
                                stroke-width="1.4" />
                            <path d="M5 1v4M11 1v4M1 7h14" stroke="rgba(255,255,255,0.7)" stroke-width="1.4"
                                stroke-linecap="round" />
                        </svg>
                        {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
                    </div>
                </div>
                <a href="{{ route('siswa.materi.index') }}" class="btn-cta">
                    <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M6 4l14 8-14 8V4z" />
                    </svg>
                    Mulai Latihan
                </a>
            </div>
        </div>

        {{-- STAT CARDS --}}
        <div class="row g-3 mb-3">
            <div class="col-6 col-md-3">
                <div class="stat-card s-orange h-100">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <span class="stat-label">Materi Dikerjakan</span>
                        <div class="stat-icon-box" style="background:var(--primary-light);">
                            <svg width="16" height="16" fill="none" viewBox="0 0 24 24">
                                <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" stroke="#FF8C42"
                                    stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                    </div>
                    <div class="stat-value">{{ $totalDikerjakan }}</div>
                    <p class="stat-sub">dari {{ $totalMateri }} tersedia</p>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card s-blue h-100">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <span class="stat-label">Total Latihan</span>
                        <div class="stat-icon-box" style="background:var(--accent-light);">
                            <svg width="16" height="16" fill="none" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10" stroke="#73A5CA" stroke-width="1.8" />
                                <path d="M12 6v6l4 2" stroke="#73A5CA" stroke-width="1.8" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </div>
                    </div>
                    <div class="stat-value">{{ $totalLatihan }}</div>
                    <p class="stat-sub">total percobaan</p>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card s-green h-100">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <span class="stat-label">Jawaban Benar</span>
                        <div class="stat-icon-box" style="background:var(--success-light);">
                            <svg width="16" height="16" fill="none" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10" stroke="#3B9E5F" stroke-width="1.8" />
                                <path d="M7 12l4 4 6-6" stroke="#3B9E5F" stroke-width="1.8" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </div>
                    </div>
                    <div class="stat-value">{{ $totalBenar }}</div>
                    <p class="stat-sub">pelafalan benar</p>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card s-warn h-100">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <span class="stat-label">Jawaban Salah</span>
                        <div class="stat-icon-box" style="background:var(--danger-light);">
                            <svg width="16" height="16" fill="none" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10" stroke="#e05c2a" stroke-width="1.8" />
                                <path d="M15 9l-6 6M9 9l6 6" stroke="#e05c2a" stroke-width="1.8" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </div>
                    </div>
                    <div class="stat-value">{{ $totalSalah }}</div>
                    <p class="stat-sub">perlu diperbaiki</p>
                </div>
            </div>
        </div>

        {{-- BOTTOM --}}
        <div class="row g-3">

            {{-- Progress per Kategori --}}
            <div class="col-12 col-md-5">
                <div class="main-card h-100">
                    <div class="card-title">Progress Kategori</div>
                    <div class="card-sub">Materi yang sudah dikerjakan per kategori</div>

                    @php $warna = ['orange','blue','yellow','green']; @endphp
                    @forelse ($progressKategori as $i => $item)
                        <div class="{{ $loop->last ? '' : 'mb-1' }}">
                            <div class="prog-top">
                                <span>{{ $item['label'] }}</span>
                                <span>{{ $item['selesai'] }}/{{ $item['total'] }} · {{ $item['persen'] }}%</span>
                            </div>
                            <div class="prog-bg">
                                <div class="prog-fill {{ $warna[$i % 4] }}" data-width="{{ $item['persen'] }}"></div>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">
                            <p class="mb-0">Belum ada data kategori.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Riwayat Terbaru --}}
            <div class="col-12 col-md-7">
                <div class="main-card h-100">
                    <div class="card-title">Riwayat Latihan Terbaru</div>
                    <div class="card-sub">5 latihan terakhir yang kamu kerjakan</div>

                    @forelse ($riwayatTerbaru as $item)
                        @php $benar = $item->status_validasi === 'Benar'; @endphp
                        <div class="act-row">
                            <div class="act-dot" style="background:{{ $benar ? '#FF8C42' : '#e05c2a' }}"></div>
                            <div class="flex-grow-1" style="min-width:0;">
                                <div class="d-flex justify-content-between align-items-start gap-2">
                                    <span class="act-name">{{ $item->teks_bacaan }}</span>
                                    <span class="score-badge {{ $benar ? 'score-benar' : 'score-salah' }}">
                                        {{ round($item->skor_similarity * 100, 1) }}%
                                    </span>
                                </div>
                                <div class="act-meta">
                                    {{ ucfirst(str_replace('_', ' ', $item->materi->kategori ?? '-')) }}
                                    · {{ $item->created_at->locale('id')->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">
                            <svg width="36" height="36" fill="none" viewBox="0 0 24 24">
                                <path d="M12 8v4l3 3M3.05 11a9 9 0 1 0 .5-3M3 4v4h4" stroke="currentColor"
                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <p class="mb-0">Belum ada riwayat latihan.</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('[data-width]').forEach(el => {
                setTimeout(() => {
                    el.style.width = el.getAttribute('data-width') + '%';
                }, 300);
            });
        });
    </script>
@endsection
