@extends('layouts.guru')

@push('styles')
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/guru/riwayat-latihan/index.css') }}">
@endpush

@section('content')
    <div class="container-fluid">
        <div class="riwayat-card bg-white">

            {{-- HEADER --}}
            <div class="card-header-custom p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="header-title">
                        <h4>Riwayat Latihan</h4>
                        <small>Data aktivitas latihan siswa</small>
                    </div>

                    <a href="{{ route('guru.riwayat-latihan.export', [
                            'search' => request('search'),
                            'status' => request('status'),
                            'date_from' => request('date_from'),
                            'date_to' => request('date_to'),
                        ]) }}" class="btn-export">
                        <svg width="14" height="14" viewBox="0 0 16 16" fill="none">
                            <path d="M2 11v2a1 1 0 001 1h10a1 1 0 001-1v-2M8 2v8M5 7l3 3 3-3" stroke="#3B6D11"
                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        Ekspor
                    </a>
                </div>
            </div>

            {{-- FILTER & SEARCH --}}
            <div class="filter-toolbar">
                <form method="GET" action="{{ route('guru.riwayat-latihan') }}" class="filter-bar">

                    {{-- FILTER TANGGAL --}}
                    <div class="filter-group">
                        <label class="filter-label">Dari Tanggal</label>
                        <input type="date" name="date_from" class="filter-date" value="{{ request('date_from') }}"
                            max="{{ request('date_to') ?? now()->format('Y-m-d') }}">
                    </div>

                    <div class="filter-group">
                        <label class="filter-label">Sampai Tanggal</label>
                        <input type="date" name="date_to" class="filter-date" value="{{ request('date_to') }}"
                            min="{{ request('date_from') }}" max="{{ now()->format('Y-m-d') }}">
                    </div>

                    {{-- DROPDOWN STATUS --}}
                    <div class="filter-group">
                        <label class="filter-label">Status</label>
                        <select name="status" class="dropdown-status">
                            <option value="semua" {{ request('status', 'semua') == 'semua' ? 'selected' : '' }}>Semua</option>
                            <option value="Benar" {{ request('status') == 'Benar' ? 'selected' : '' }}>Benar</option>
                            <option value="Salah" {{ request('status') == 'Salah' ? 'selected' : '' }}>Salah</option>
                        </select>
                    </div>

                    {{-- SEARCH + AKSI --}}
                    <div class="search-actions">
                        <div class="search-bar">
                            <svg width="14" height="14" viewBox="0 0 16 16" fill="none" style="flex-shrink:0;">
                                <circle cx="6.5" cy="6.5" r="4.5" stroke="#aaa" stroke-width="1.5" />
                                <path d="M10.5 10.5l3 3" stroke="#aaa" stroke-width="1.5" stroke-linecap="round" />
                            </svg>
                            <input type="text" name="search" placeholder="Cari siswa / materi..."
                                value="{{ request('search') }}">
                        </div>

                        <button type="submit" class="btn-cari">Cari</button>

                        @if (request('search') || (request('status') && request('status') != 'semua') || request('date_from') || request('date_to'))
                            <a href="{{ route('guru.riwayat-latihan') }}" class="btn-reset">Reset</a>
                        @endif
                    </div>
                </form>
            </div>

            {{-- ALERT --}}
            @if (session('success'))
                <div class="alert-success-custom">
                    <span>{{ session('success') }}</span>
                    <button class="alert-close-btn" onclick="this.parentElement.remove()">&times;</button>
                </div>
            @endif

            {{-- SHOW ENTRIES --}}
            <div class="show-row d-flex align-items-center gap-2">
                Tampilkan
                <select onchange="location.href='{{ route('guru.riwayat-latihan') }}?search={{ request('search') }}&status={{ request('status') }}&date_from={{ request('date_from') }}&date_to={{ request('date_to') }}&per_page='+this.value">
                    <option value="5" {{ $riwayat->perPage() == 5 ? 'selected' : '' }}>5</option>
                    <option value="10" {{ $riwayat->perPage() == 10 ? 'selected' : '' }}>10</option>
                    <option value="20" {{ $riwayat->perPage() == 20 ? 'selected' : '' }}>20</option>
                    <option value="50" {{ $riwayat->perPage() == 50 ? 'selected' : '' }}>50</option>
                </select>
                data per halaman
            </div>

            {{-- TABLE --}}
            <div class="table-responsive">
                <table class="table-custom">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Waktu</th>
                            <th>Nama</th>
                            <th>Materi</th>
                            <th>Skor</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($riwayat as $index => $item)
                            <tr>
                                <td>{{ $riwayat->firstItem() + $index }}</td>
                                <td>{{ $item->created_at->format('d M Y, H:i') }}</td>
                                <td>{{ $item->siswa->nama ?? '-' }}</td>
                                <td><strong>{{ $item->materi->teks_bacaan ?? '-' }}</strong></td>
                                <td>{{ number_format($item->skor_similarity * 100, 1) }}%</td>
                                <td>
                                    @if ($item->status_validasi == 'Benar')
                                        <span class="badge-valid">✔ Benar</span>
                                    @else
                                        <span class="badge-invalid">✖ Salah</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state">
                                        Tidak ada riwayat latihan
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
                    @if ($riwayat->count())
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
    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection