@extends('layouts.siswa')

@push('styles')
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/siswa/riwayat-latihan/index.css') }}">
@endpush

@section('content')
<div class="container-fluid">

    {{-- HEADER BANNER --}}
    <div class="rl-banner">
        <div>
            <h4 class="rl-banner-title">Riwayat Latihan</h4>
            <p class="rl-banner-sub">Pantau semua aktivitas latihan membacamu</p>
        </div>
        <div class="rl-banner-icon">
            <svg width="48" height="48" fill="none" viewBox="0 0 24 24">
                <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2
                         M9 5a2 2 0 002 2h2a2 2 0 002-2
                         M9 5a2 2 0 012-2h2a2 2 0 012 2
                         M9 12l2 2 4-4"
                      stroke="rgba(255,255,255,0.8)" stroke-width="1.5"
                      stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>
    </div>

    {{-- STATS CARDS --}}
    <div class="rl-stats-row">
        <div class="rl-stat-card">
            <div class="rl-stat-icon ic-total">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/>
                    <path d="M12 7v5l3 3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                </svg>
            </div>
            <div>
                <div class="rl-stat-num">{{ $stats['total'] }}</div>
                <div class="rl-stat-lbl">Total Latihan</div>
            </div>
        </div>

        <div class="rl-stat-card">
            <div class="rl-stat-icon ic-benar">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/>
                    <path d="M8 12l3 3 5-5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <div>
                <div class="rl-stat-num">{{ $stats['benar'] }}</div>
                <div class="rl-stat-lbl">Jawaban Benar</div>
            </div>
        </div>

        <div class="rl-stat-card">
            <div class="rl-stat-icon ic-salah">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/>
                    <path d="M9 9l6 6M15 9l-6 6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                </svg>
            </div>
            <div>
                <div class="rl-stat-num">{{ $stats['salah'] }}</div>
                <div class="rl-stat-lbl">Jawaban Salah</div>
            </div>
        </div>

        <div class="rl-stat-card">
            <div class="rl-stat-icon ic-skor">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24">
                    <path d="M12 2l3 6 7 1-5 5 1 7-6-3-6 3 1-7-5-5 7-1 3-6z"
                          stroke="currentColor" stroke-width="1.6"
                          stroke-linejoin="round"/>
                </svg>
            </div>
            <div>
                <div class="rl-stat-num">{{ $stats['total'] > 0 ? number_format($stats['rata_skor'], 1) . '%' : '-' }}</div>
                <div class="rl-stat-lbl">Rata-rata Skor</div>
            </div>
        </div>
    </div>

    {{-- MAIN CARD --}}
    <div class="rl-card">

        {{-- FILTER & SEARCH --}}
        <div class="d-flex justify-content-start align-items-center gap-2 px-4 pt-4 pb-4 flex-wrap">
            <form method="GET" action="{{ route('siswa.riwayat-latihan') }}" class="d-flex align-items-center gap-2 flex-wrap rl-filter-form">

                {{-- Dari Tanggal --}}
                <input type="date" name="date_from" class="rl-select" value="{{ request('date_from') }}"
                       max="{{ request('date_to') ?? now()->format('Y-m-d') }}"
                       onchange="this.form.submit()">

                {{-- Sampai Tanggal --}}
                <input type="date" name="date_to" class="rl-select" value="{{ request('date_to') }}"
                       min="{{ request('date_from') }}" max="{{ now()->format('Y-m-d') }}"
                       onchange="this.form.submit()">

                {{-- Status --}}
                <select name="status" class="rl-select" onchange="this.form.submit()">
                    <option value="semua" {{ request('status', 'semua') == 'semua' ? 'selected' : '' }}>Semua Status</option>
                    <option value="Benar" {{ request('status') == 'Benar' ? 'selected' : '' }}>✔ Benar</option>
                    <option value="Salah" {{ request('status') == 'Salah' ? 'selected' : '' }}>✖ Salah</option>
                </select>

                {{-- Kategori --}}
                <select name="kategori" class="rl-select" onchange="this.form.submit()">
                    <option value="semua" {{ request('kategori', 'semua') == 'semua' ? 'selected' : '' }}>Semua Kategori</option>
                    <option value="Abjad"      {{ request('kategori') == 'Abjad'      ? 'selected' : '' }}>Abjad</option>
                    <option value="suku_kata"  {{ request('kategori') == 'suku_kata'  ? 'selected' : '' }}>Suku Kata</option>
                    <option value="kata_dasar" {{ request('kategori') == 'kata_dasar' ? 'selected' : '' }}>Kata Dasar</option>
                </select>

                {{-- Search --}}
                <div class="rl-search">
                    <svg width="13" height="13" fill="none" viewBox="0 0 16 16" style="flex-shrink:0;">
                        <circle cx="6.5" cy="6.5" r="4.5" stroke="#aaa" stroke-width="1.4"/>
                        <path d="M10.5 10.5l3 3" stroke="#aaa" stroke-width="1.4" stroke-linecap="round"/>
                    </svg>
                    <input type="text" name="search"
                           placeholder="Cari materi..."
                           value="{{ request('search') }}">
                    <button type="submit" class="rl-btn-cari">Cari</button>
                </div>

                @if (request('search') || (request('status') && request('status') != 'semua') || (request('kategori') && request('kategori') != 'semua') || request('date_from') || request('date_to'))
                    <a href="{{ route('siswa.riwayat-latihan') }}" class="rl-btn-cari" style="background:#f0f0f0;color:#888;">Reset</a>
                @endif

            </form>
        </div>

        {{-- SHOW ENTRIES --}}
        <div class="rl-show-row d-flex align-items-center gap-2">
            Tampilkan
            <select onchange="location.href='{{ route('siswa.riwayat-latihan') }}?search={{ request('search') }}&status={{ request('status') }}&kategori={{ request('kategori') }}&date_from={{ request('date_from') }}&date_to={{ request('date_to') }}&per_page='+this.value">
                <option value="5"  {{ $riwayat->perPage() == 5  ? 'selected' : '' }}>5</option>
                <option value="10" {{ $riwayat->perPage() == 10 ? 'selected' : '' }}>10</option>
                <option value="20" {{ $riwayat->perPage() == 20 ? 'selected' : '' }}>20</option>
                <option value="50" {{ $riwayat->perPage() == 50 ? 'selected' : '' }}>50</option>
            </select>
            data per halaman
        </div>

        {{-- TABLE --}}
        <div class="table-responsive">
            <table class="rl-table">
                <thead>
                    <tr>
                        <th style="width:44px;">No</th>
                        <th>Waktu</th>
                        <th>Materi</th>
                        <th>Kategori</th>
                        <th>Skor</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayat as $index => $item)
                        <tr>
                            <td class="tc">{{ $riwayat->firstItem() + $index }}</td>
                            <td>
                                <div class="rl-time">{{ $item->created_at->format('d M Y') }}</div>
                                <div class="rl-time-sub">{{ $item->created_at->format('H:i') }}</div>
                            </td>
                            <td>
                                <strong>{{ $item->teks_bacaan ?? $item->materi->teks_bacaan ?? '-' }}</strong>
                            </td>
                            <td>
                                @php $kat = $item->materi->kategori ?? '-'; @endphp
                                <span class="rl-badge-kat kat-{{ Str::slug($kat) }}">{{ $kat }}</span>
                            </td>
                            <td>
                                <div class="rl-skor-wrap">
                                    <span class="rl-skor-num {{ $item->skor_similarity >= 0.95 ? 'skor-good' : ($item->skor_similarity >= 0.70 ? 'skor-mid' : 'skor-low') }}">
                                        {{ number_format($item->skor_similarity * 100, 1) }}%
                                    </span>
                                    <div class="rl-skor-bar">
                                        <div class="rl-skor-fill {{ $item->skor_similarity >= 0.95 ? 'fill-good' : ($item->skor_similarity >= 0.70 ? 'fill-mid' : 'fill-low') }}"
                                             style="width: {{ number_format($item->skor_similarity * 100, 1) }}%">
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($item->status_validasi == 'Benar')
                                    <span class="rl-badge-status s-benar">✔ Benar</span>
                                @else
                                    <span class="rl-badge-status s-salah">✖ Salah</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="rl-empty">
                                    <svg width="40" height="40" fill="none" viewBox="0 0 24 24">
                                        <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"
                                              stroke="#ddd" stroke-width="1.5" stroke-linecap="round"/>
                                    </svg>
                                    <p>Belum ada riwayat latihan</p>
                                    <a href="{{ route('siswa.materi.index') }}" class="rl-btn-mulai">Mulai Latihan</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- FOOTER --}}
        <div class="card-footer-custom">
                <div class="footer-info">
                @if($riwayat->count())
                    Menampilkan {{ $riwayat->firstItem() }} &ndash; {{ $riwayat->lastItem() }}
                    dari {{ $riwayat->total() }} data
                @else
                    Tidak ada data
                @endif
            </div>
            <div>
                {{ $riwayat->appends(request()->input())->links('vendor.pagination.simple-number') }}
            </div>
        </div>

    </div>
</div>
@endsection