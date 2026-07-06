@extends('layouts.guru')

@section('content')
    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Custom CSS --}}
    <link href="{{ asset('frontend/assets/css/guru/daftar-siswa/index.css') }}" rel="stylesheet">


    <div class="container-fluid">
        <div class="siswa-card">

            {{-- ALERT SUKSES / ERROR --}}
            @if (session('success'))
                <div class="alert alert-success alert-import alert-dismissible fade show" role="alert">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" style="vertical-align:-2px;margin-right:6px">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                        <polyline points="22 4 12 14.01 9 11.01" />
                    </svg>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-import alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- HEADER --}}
            <div class="card-header-custom">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                    <div class="header-title">
                        <h4>Daftar Siswa</h4>
                        <small>Kelola dan lihat data siswa</small>
                    </div>

                    {{-- TOMBOL EKSPOR + IMPORT --}}
                    <div class="d-flex gap-2 align-items-center flex-wrap">

                        {{-- Tombol Import --}}
                        <button class="btn-import" data-bs-toggle="modal" data-bs-target="#modalImport">
                            <svg width="14" height="14" viewBox="0 0 16 16" fill="none">
                                <path d="M2 11v2a1 1 0 001 1h10a1 1 0 001-1v-2M8 10V2M5 5l3-3 3 3" stroke="#0C447C"
                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            Import
                        </button>

                        {{-- Tombol Ekspor --}}
                        <a href="{{ route('guru.daftar-siswa.export', ['search' => request('search')]) }}"
                            class="btn-export">
                            <svg width="14" height="14" viewBox="0 0 16 16" fill="none">
                                <path d="M2 11v2a1 1 0 001 1h10a1 1 0 001-1v-2M8 2v8M5 7l3 3 3-3" stroke="#3B6D11"
                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            Ekspor
                        </a>
                    </div>
                </div>

                {{-- SEARCH --}}
                <div class="d-flex justify-content-end">
                    <form method="GET" action="{{ route('guru.daftar-siswa') }}" style="width:100%; max-width:300px;">
                        <div class="search-bar">
                            <svg width="14" height="14" viewBox="0 0 16 16" fill="none" style="flex-shrink:0;">
                                <circle cx="6.5" cy="6.5" r="4.5" stroke="#aaa" stroke-width="1.5" />
                                <path d="M10.5 10.5l3 3" stroke="#aaa" stroke-width="1.5" stroke-linecap="round" />
                            </svg>
                            <input type="text" name="search" placeholder="Cari nama, NIS, NISN, atau email..."
                                value="{{ request('search') }}">
                            <button type="submit" class="btn-cari">CARI</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- SHOW ENTRIES --}}
            <div class="show-row d-flex align-items-center gap-2">
                Tampilkan
                <select onchange="location.href='?per_page='+this.value+'&search={{ request('search') }}'">
                    <option value="5" {{ $siswa->perPage() == 5 ? 'selected' : '' }}>5</option>
                    <option value="10" {{ $siswa->perPage() == 10 ? 'selected' : '' }}>10</option>
                    <option value="20" {{ $siswa->perPage() == 20 ? 'selected' : '' }}>20</option>
                    <option value="50" {{ $siswa->perPage() == 50 ? 'selected' : '' }}>50</option>
                </select>
                data per halaman
            </div>

            {{-- TABLE --}}
            <div class="table-responsive">
                <table class="table-custom">
                    <thead>
                        <tr>
                            <th class="center" style="width:52px;">No</th>
                            <th>Nama Siswa</th>
                            <th>NIS</th>
                            <th>NISN</th>
                            <th>Tanggal Lahir</th>
                            <th>Jenis Kelamin</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($siswa as $index => $item)
                            @php
                                $initials = collect(explode(' ', $item->nama))
                                    ->take(2)
                                    ->map(fn($w) => strtoupper(substr($w, 0, 1)))
                                    ->join('');
                                $avatarColors = [
                                    ['bg' => '#B5D4F4', 'color' => '#0C447C'],
                                    ['bg' => '#F4C0D1', 'color' => '#72243E'],
                                    ['bg' => '#FAC775', 'color' => '#633806'],
                                    ['bg' => '#9FE1CB', 'color' => '#085041'],
                                    ['bg' => '#CECBF6', 'color' => '#3C3489'],
                                    ['bg' => '#F5C4B3', 'color' => '#712B13'],
                                ];
                                $av = $avatarColors[$index % count($avatarColors)];
                            @endphp
                            <tr>
                                <td class="center no-cell">{{ $siswa->firstItem() + $index }}</td>
                                <td>
                                    <div class="nama-wrapper">
                                        <span class="avatar"
                                            style="background:{{ $av['bg'] }};color:{{ $av['color'] }};">
                                            {{ $initials }}
                                        </span>
                                        <span class="nama-text">{{ $item->nama }}</span>
                                    </div>
                                </td>
                                <td>{{ $item->nis }}</td>
                                <td>{{ $item->nisn ?? '-' }}</td>
                                <td>{{ $item->tanggal_lahir?->format('d/m/Y') ?? '-' }}</td>
                                <td>
                                    @if ($item->jenis_kelamin == 'L')
                                        Laki-laki
                                    @elseif($item->jenis_kelamin == 'P')
                                        Perempuan
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="email-cell">{{ $item->user->email ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">
                                    <div class="empty-state">
                                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none">
                                            <path d="M3 7h18M3 12h18M3 17h18" stroke="#aaa" stroke-width="1.5"
                                                stroke-linecap="round" />
                                        </svg>
                                        <p>Tidak ada data siswa ditemukan</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- FOOTER PAGINATION --}}
            <div class="card-footer-custom">
                <div class="footer-info">
                    @if ($siswa->count())
                        Menampilkan {{ $siswa->firstItem() }} &ndash; {{ $siswa->lastItem() }}
                        dari {{ $siswa->total() }} data
                    @else
                        Tidak ada data
                    @endif
                </div>
                <div>
                    {{ $siswa->appends(request()->input())->links('vendor.pagination.simple-number') }}
                </div>
            </div>

        </div>
    </div>

    {{-- ===== MODAL IMPORT ===== --}}
    <div class="modal fade modal-import" id="modalImport" tabindex="-1" aria-labelledby="modalImportLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width:460px;">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="modal-title" id="modalImportLabel">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#0C447C"
                            stroke-width="2" style="vertical-align:-2px;margin-right:6px">
                            <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4" />
                            <polyline points="17 8 12 3 7 8" />
                            <line x1="12" y1="3" x2="12" y2="15" />
                        </svg>
                        Import Data Siswa
                    </span>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form method="POST" action="{{ route('guru.daftar-siswa.import') }}" enctype="multipart/form-data"
                    id="formImport">
                    @csrf
                    <div class="modal-body">

                        {{-- Tombol Download Template --}}
                        <a href="{{ route('guru.daftar-siswa.template') }}" class="btn-download-template"
                            style="display:flex; align-items:center; justify-content:center; gap:6px;
                               background:#eff6ff; border:1px solid #bfdbfe; color:#1d4ed8;
                               font-size:13px; font-weight:600; padding:9px 12px; border-radius:8px;
                               text-decoration:none; margin-bottom:14px;">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#1d4ed8"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4" />
                                <polyline points="7 10 12 15 17 10" />
                                <line x1="12" y1="15" x2="12" y2="3" />
                            </svg>
                            Download Format Tabel (.xlsx)
                        </a>

                        {{-- Drop zone --}}
                        <div class="drop-zone" id="dropZone">
                            <input type="file" name="file_excel" id="fileInput" accept=".xlsx,.xls,.csv" required>
                            <div class="dz-icon">
                                <svg width="36" height="36" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="1.5">
                                    <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z" />
                                    <polyline points="14 2 14 8 20 8" />
                                    <line x1="12" y1="18" x2="12" y2="12" />
                                    <line x1="9" y1="15" x2="12" y2="12" />
                                    <line x1="15" y1="15" x2="12" y2="12" />
                                </svg>
                            </div>
                            <div class="dz-text">
                                Seret file ke sini atau <strong>klik untuk pilih</strong>
                            </div>
                            <div class="dz-filename" id="dzFilename"></div>
                        </div>

                        {{-- Info format --}}
                        <div class="format-info">
                            <div
                                style="font-weight:600; font-size:13px; display:flex; align-items:center; gap:6px; margin-bottom:10px; color:#92400e;">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#d97706"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path
                                        d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />
                                    <line x1="12" y1="9" x2="12" y2="13" />
                                    <line x1="12" y1="17" x2="12.01" y2="17" />
                                </svg>
                                Panduan Format File Excel
                            </div>
                            <div style="display:flex; flex-direction:column; gap:6px; font-size:12.5px; color:#92400e;">
                                <div style="display:flex; align-items:flex-start; gap:8px;">
                                    <span
                                        style="width:5px;height:5px;border-radius:50%;background:#d97706;flex-shrink:0;margin-top:5px;"></span>
                                    <span>Header baris pertama wajib:
                                        <span
                                            style="background:#fef3c7;border:1px solid #fde68a;border-radius:4px;padding:1px 6px;font-family:monospace;font-size:11.5px;font-weight:600;margin:0 2px;display:inline-block;">nama</span>
                                        <span
                                            style="background:#fef3c7;border:1px solid #fde68a;border-radius:4px;padding:1px 6px;font-family:monospace;font-size:11.5px;font-weight:600;margin:0 2px;display:inline-block;">nis</span>
                                        <span
                                            style="background:#fef3c7;border:1px solid #fde68a;border-radius:4px;padding:1px 6px;font-family:monospace;font-size:11.5px;font-weight:600;margin:0 2px;display:inline-block;">nisn</span>
                                        <span
                                            style="background:#fef3c7;border:1px solid #fde68a;border-radius:4px;padding:1px 6px;font-family:monospace;font-size:11.5px;font-weight:600;margin:0 2px;display:inline-block;">tanggal_lahir</span>
                                        <span
                                            style="background:#fef3c7;border:1px solid #fde68a;border-radius:4px;padding:1px 6px;font-family:monospace;font-size:11.5px;font-weight:600;margin:0 2px;display:inline-block;">jenis_kelamin</span>
                                        <span
                                            style="background:#fef3c7;border:1px solid #fde68a;border-radius:4px;padding:1px 6px;font-family:monospace;font-size:11.5px;font-weight:600;margin:0 2px;display:inline-block;">email</span>
                                    </span>
                                </div>
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <span
                                        style="width:5px;height:5px;border-radius:50%;background:#d97706;flex-shrink:0;"></span>
                                    <span>Format <strong>tanggal_lahir</strong>: YYYY-MM-DD, <strong>jenis_kelamin</strong>: L atau P</span>
                                </div>
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <span
                                        style="width:5px;height:5px;border-radius:50%;background:#d97706;flex-shrink:0;"></span>
                                    <span>Format file: <strong>.xlsx / .xls / .csv</strong> &mdash; Maks. 2MB</span>
                                </div>
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <span
                                        style="width:5px;height:5px;border-radius:50%;background:#d97706;flex-shrink:0;"></span>
                                    <span>NIS, NISN, atau email yang sudah terdaftar akan dilewati otomatis</span>
                                </div>
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <span
                                        style="width:5px;height:5px;border-radius:50%;background:#d97706;flex-shrink:0;"></span>
                                    <span>Password default siswa: <strong>password</strong></span>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn-submit-import" id="btnSubmitImport" disabled>
                            Import
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const fileInput = document.getElementById('fileInput');
        const dzFilename = document.getElementById('dzFilename');
        const btnSubmit = document.getElementById('btnSubmitImport');
        const dropZone = document.getElementById('dropZone');

        fileInput.addEventListener('change', function() {
            if (this.files.length) {
                dzFilename.textContent = '✓ ' + this.files[0].name;
                btnSubmit.disabled = false;
            }
        });

        // Drag & drop visual
        dropZone.addEventListener('dragover', e => {
            e.preventDefault();
            dropZone.classList.add('dragover');
        });
        dropZone.addEventListener('dragleave', () => dropZone.classList.remove('dragover'));
        dropZone.addEventListener('drop', e => {
            e.preventDefault();
            dropZone.classList.remove('dragover');
            if (e.dataTransfer.files.length) {
                fileInput.files = e.dataTransfer.files;
                dzFilename.textContent = '✓ ' + e.dataTransfer.files[0].name;
                btnSubmit.disabled = false;
            }
        });
    </script>
@endsection