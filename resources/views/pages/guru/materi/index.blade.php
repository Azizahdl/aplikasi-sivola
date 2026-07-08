@extends('layouts.guru')

@push('styles')
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/guru/materi/index.css') }}">
@endpush

@section('content')
    <div class="container-fluid">
        <div class="materi-card">

            {{-- HEADER --}}
            <div class="card-header-custom p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="header-title">
                        <h4>Materi Bacaan</h4>
                        <small>Kelola semua materi latihan bacaan siswa</small>
                    </div>
                    <button type="button" class="btn-tambah" onclick="bukaModalTambah()">
                        <svg width="13" height="13" fill="none" viewBox="0 0 16 16">
                            <path d="M8 3v10M3 8h10" stroke="#fff" stroke-width="1.8" stroke-linecap="round" />
                        </svg>
                        Tambah Materi
                    </button>
                </div>

                {{-- FILTER + SEARCH --}}
                <div class="filter-row d-flex align-items-center gap-2 flex-wrap mt-3">
                    <div class="filter-btns">
                        <a href="{{ route('guru.materi.index', array_merge(request()->except('kategori'), ['search' => request('search')])) }}"
                            class="btn-filter {{ !request('kategori') ? 'active' : '' }}">Semua</a>
                        <a href="{{ route('guru.materi.index', array_merge(request()->except('kategori'), ['kategori' => 'abjad', 'search' => request('search')])) }}"
                            class="btn-filter {{ request('kategori') == 'abjad' ? 'active f-blue' : '' }}">Abjad</a>
                        <a href="{{ route('guru.materi.index', array_merge(request()->except('kategori'), ['kategori' => 'suku_kata', 'search' => request('search')])) }}"
                            class="btn-filter {{ request('kategori') == 'suku_kata' ? 'active f-green' : '' }}">Suku
                            Kata</a>
                        <a href="{{ route('guru.materi.index', array_merge(request()->except('kategori'), ['kategori' => 'kata_dasar', 'search' => request('search')])) }}"
                            class="btn-filter {{ request('kategori') == 'kata_dasar' ? 'active f-orange' : '' }}">Kata
                            Dasar</a>
                    </div>
                    <form method="GET" action="{{ route('guru.materi.index') }}" class="ms-auto">
                        @if (request('kategori'))
                            <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                        @endif
                        <div class="search-pill">
                            <svg width="13" height="13" fill="none" viewBox="0 0 16 16" style="flex-shrink:0;">
                                <circle cx="6.5" cy="6.5" r="4.5" stroke="#b0a89e" stroke-width="1.4" />
                                <path d="M10.5 10.5l3 3" stroke="#b0a89e" stroke-width="1.4" stroke-linecap="round" />
                            </svg>
                            <input type="text" name="search" placeholder="Cari teks bacaan..."
                                value="{{ request('search') }}">
                            <button type="submit" class="btn-cari">CARI</button>
                        </div>
                    </form>
                </div>
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
                <select
                    onchange="location.href='?per_page='+this.value+'&kategori={{ request('kategori') }}&search={{ request('search') }}'">
                    <option value="5" {{ $materi->perPage() == 5 ? 'selected' : '' }}>5</option>
                    <option value="10" {{ $materi->perPage() == 10 ? 'selected' : '' }}>10</option>
                    <option value="20" {{ $materi->perPage() == 20 ? 'selected' : '' }}>20</option>
                    <option value="50" {{ $materi->perPage() == 50 ? 'selected' : '' }}>50</option>
                </select>
                data per halaman
            </div>

            {{-- TABLE --}}
            <div class="table-responsive">
                <table class="table-custom">
                    <thead>
                        <tr>
                            <th class="tc" style="width:44px;">
                                <div class="cell-ellipsis">No</div>
                            </th>
                            <th>
                                <div class="cell-ellipsis">Teks Bacaan</div>
                            </th>
                            <th class="tc" style="width:150px;">
                                <div class="cell-ellipsis">kategori Materi</div>
                            </th>
                            <th class="tc" style="width:120px;">
                                <div class="cell-ellipsis">Aksi</div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($materi as $index => $item)
                            @php
                                $kategoriColors = [
                                    'abjad' => 'b-blue',
                                    'suku_kata' => 'b-green',
                                    'kata_dasar' => 'b-orange',
                                ];
                                $colorClass = $kategoriColors[$item->kategori] ?? 'b-blue';
                            @endphp
                            <tr>
                                <td class="tc no-cell">
                                    <div class="cell-ellipsis">{{ $materi->firstItem() + $index }}</div>
                                </td>
                                <td style="font-weight:500;">
                                    <div class="cell-ellipsis">{{ Str::limit($item->teks_bacaan, 70) }}</div>
                                </td>
                                <td class="tc">
                                    <span class="badge-pill {{ $colorClass }}">
                                        {{ ucfirst(str_replace('_', ' ', $item->kategori)) }}
                                    </span>
                                </td>
                                {{-- <td class="tc">
                                <span class="threshold-val">{{ $item->threshold }}</span>
                            </td> --}}
                                <td class="tc">
                                    <div class="aksi-wrap">
                                        {{-- Tombol Rekam Referensi --}}
                                        {{-- <button type="button"
                                        class="btn-act rekam-ref"
                                        title="Rekam Suara Referensi"
                                        onclick="bukaModalRekam('{{ $item->id_materi }}', '{{ addslashes($item->teks_bacaan) }}')">
                                        <svg fill="none" viewBox="0 0 16 16">
                                            <rect x="5.5" y="1" width="5" height="8" rx="2.5"
                                                stroke="#0C447C" stroke-width="1.3"/>
                                            <path d="M3 7a5 5 0 0010 0M8 12v2.5M5.5 14.5h5"
                                                stroke="#0C447C" stroke-width="1.3" stroke-linecap="round"/>
                                        </svg>
                                    </button> --}}
                                        {{-- <a href="{{ route('guru.materi.edit', $item->id_materi) }}"
                                       class="btn-act edit" title="Edit">
                                        <svg fill="none" viewBox="0 0 16 16">
                                            <path d="M11 3l2 2-7 7H4v-2l7-7z"
                                                stroke="#854F0B" stroke-width="1.3" stroke-linejoin="round"/>
                                        </svg>
                                    </a> --}}
                                        <form action="{{ route('guru.materi.destroy', $item->id_materi) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Yakin ingin menghapus materi ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn-act del" title="Hapus">
                                                <svg fill="none" viewBox="0 0 16 16">
                                                    <path d="M3 5h10M6 5V3h4v2M6 8v4M10 8v4" stroke="#A32D2D"
                                                        stroke-width="1.3" stroke-linecap="round" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">
                                    <div class="empty-state">
                                        <svg width="36" height="36" fill="none" viewBox="0 0 24 24">
                                            <path d="M4 19.5A2.5 2.5 0 016.5 17H20" stroke="#b0a89e" stroke-width="1.5"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"
                                                stroke="#b0a89e" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                        <p>Belum ada data materi</p>
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
                    @if ($materi->count())
                        Menampilkan {{ $materi->firstItem() }} &ndash; {{ $materi->lastItem() }}
                        dari {{ $materi->total() }} data
                    @else
                        Tidak ada data
                    @endif
                </div>
                <div>{{ $materi->withQueryString()->links('vendor.pagination.simple-number') }}</div>
            </div>

        </div>
    </div>

    {{-- ══════════════════════════════════════════════
     MODAL 1: TAMBAH MATERI
══════════════════════════════════════════════ --}}
    <div class="modal-overlay" id="modal-tambah" onclick="tutupModalLuar(event,'modal-tambah')">
        <div class="modal-card">
            <div class="modal-header">
                <div>
                    <p class="modal-header-title">Tambah Materi Bacaan</p>
                    <p class="modal-header-sub">Isi form berikut untuk menambahkan materi baru</p>
                </div>
                <button class="modal-close" onclick="tutupModal('modal-tambah')" type="button">
                    <svg width="12" height="12" fill="none" viewBox="0 0 16 16">
                        <path d="M12 4L4 12M4 4l8 8" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                    </svg>
                </button>
            </div>
            <form action="{{ route('guru.materi.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group-m">
                        <label class="form-label-m" for="teks_bacaan">Teks Bacaan <span class="req">*</span></label>
                        <textarea id="teks_bacaan" name="teks_bacaan" class="textarea-m" rows="4"
                            placeholder="Masukkan teks bacaan yang akan dilatih siswa..." required>{{ old('teks_bacaan') }}</textarea>
                        @error('teks_bacaan')
                            <div class="error-m">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-row-m">
                        <div class="form-group-m mb-0">
                            <label class="form-label-m" for="kategori">kategori Materi <span
                                    class="req">*</span></label>
                            <div class="select-wrap-m">
                                <select id="kategori" name="kategori" class="select-m" required>
                                    <option value="" disabled {{ old('kategori') ? '' : 'selected' }}>Pilih
                                        kategori...</option>
                                    <option value="abjad" {{ old('kategori') == 'abjad' ? 'selected' : '' }}>Abjad
                                    </option>
                                    <option value="suku_kata" {{ old('kategori') == 'suku_kata' ? 'selected' : '' }}>Suku
                                        Kata</option>
                                    <option value="kata_dasar" {{ old('kategori') == 'kata_dasar' ? 'selected' : '' }}>
                                        Kata Dasar</option>
                                </select>
                            </div>
                            @error('kategori')
                                <div class="error-m">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-modal-cancel" onclick="tutupModal('modal-tambah')">Batal</button>
                    <button type="submit" class="btn-modal-save">
                        <svg width="13" height="13" fill="none" viewBox="0 0 16 16">
                            <path d="M2 8.5L6 12.5L14 4" stroke="#fff" stroke-width="1.8" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════
     MODAL 2: REKAM SUARA REFERENSI
══════════════════════════════════════════════ --}}
    <div class="modal-overlay" id="modal-rekam" onclick="tutupModalLuar(event,'modal-rekam')">
        <div class="modal-card">
            <div class="modal-header">
                <div>
                    <p class="modal-header-title">Rekam Suara Referensi</p>
                    <p class="modal-header-sub">Ucapkan teks berikut sebagai suara referensi</p>
                </div>
                <button class="modal-close" onclick="tutupModalRekam()" type="button">
                    <svg width="12" height="12" fill="none" viewBox="0 0 16 16">
                        <path d="M12 4L4 12M4 4l8 8" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                    </svg>
                </button>
            </div>

            <div class="modal-body">

                {{-- Teks yang harus diucapkan --}}
                <div class="rekam-teks-box" id="rekam-teks-display">—</div>

                {{-- Error --}}
                <div id="rekam-error-box" class="rekam-error-box" style="display:none">
                    <svg width="13" height="13" fill="none" viewBox="0 0 16 16">
                        <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-width="1.4" />
                        <path d="M8 5v4M8 11v.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                    </svg>
                    <span id="rekam-error-msg"></span>
                </div>

                {{-- STATUS: idle --}}
                <div class="rekam-status" id="rs-idle">
                    <svg width="40" height="40" fill="none" viewBox="0 0 24 24">
                        <rect x="9" y="2" width="6" height="12" rx="3" stroke="#8a96a8"
                            stroke-width="1.5" />
                        <path d="M5 10a7 7 0 0014 0M12 19v3M8 22h8" stroke="#8a96a8" stroke-width="1.5"
                            stroke-linecap="round" />
                    </svg>
                    <span class="rekam-status-label" style="color:#8a96a8">Siap merekam</span>
                    <span class="rekam-status-hint">Tekan tombol di bawah untuk mulai</span>
                </div>

                {{-- STATUS: recording --}}
                <div class="rekam-status" id="rs-recording" style="display:none">
                    <div class="rec-pulse">
                        <svg width="22" height="22" fill="none" viewBox="0 0 24 24">
                            <rect x="9" y="2" width="6" height="12" rx="3" fill="#ef4444"
                                stroke="#ef4444" stroke-width="1.2" />
                            <path d="M5 10a7 7 0 0014 0M12 19v3M8 22h8" stroke="#ef4444" stroke-width="1.5"
                                stroke-linecap="round" />
                        </svg>
                    </div>
                    <span class="rekam-status-label" style="color:#ef4444">Merekam...</span>
                    <span class="rekam-status-hint" id="rekam-timer">00:00</span>
                </div>

                {{-- STATUS: done --}}
                <div class="rekam-status" id="rs-done" style="display:none">
                    <audio id="rekam-audio-preview" controls class="audio-preview"></audio>
                    <span class="rekam-status-hint">Dengarkan rekaman, lalu kirim atau rekam ulang</span>
                </div>

                {{-- STATUS: loading --}}
                <div class="rekam-status" id="rs-loading" style="display:none">
                    <div class="rekam-loading">
                        <div class="rekam-spinner"></div>
                        <span class="rekam-status-hint" id="rekam-loading-text">Mengirim ke server...</span>
                    </div>
                </div>

                {{-- STATUS: sukses --}}
                <div class="rekam-status" id="rs-sukses" style="display:none">
                    <div class="rekam-sukses">
                        <div class="rekam-sukses-icon">
                            <svg width="26" height="26" fill="none" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10" stroke="#22c55e" stroke-width="1.5" />
                                <path d="M7 12l4 4 6-6" stroke="#22c55e" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </div>
                        <span class="rekam-status-label" style="color:#16a34a">Berhasil dikirim!</span>
                        <span class="rekam-status-hint">Suara referensi berhasil disimpan ke server</span>
                    </div>
                </div>

                {{-- TOMBOL --}}
                <div class="rekam-btn-group" id="rekam-btn-group">
                    <button type="button" class="btn-rekam-mulai" id="rbtn-mulai" onclick="mulaiRekam()">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24">
                            <rect x="9" y="2" width="6" height="12" rx="3" stroke="currentColor"
                                stroke-width="1.8" />
                            <path d="M5 10a7 7 0 0014 0M12 19v3M8 22h8" stroke="currentColor" stroke-width="1.8"
                                stroke-linecap="round" />
                        </svg>
                        Mulai Rekam
                    </button>
                    <button type="button" class="btn-rekam-stop" id="rbtn-stop" style="display:none"
                        onclick="stopRekam()">
                        <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24">
                            <rect x="5" y="5" width="14" height="14" rx="2" />
                        </svg>
                        Stop
                    </button>
                    <button type="button" class="btn-rekam-ulang" id="rbtn-ulang" style="display:none"
                        onclick="ulangRekam()">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24">
                            <path d="M1 4v6h6M23 20v-6h-6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path d="M20.49 9A9 9 0 005.64 5.64L1 10M23 14l-4.64 4.36A9 9 0 013.51 15"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        Rekam Ulang
                    </button>
                    <button type="button" class="btn-modal-save" id="rbtn-kirim" style="display:none"
                        onclick="kirimReferensi()">
                        <svg width="13" height="13" fill="none" viewBox="0 0 16 16">
                            <path d="M14 2L7 9M14 2l-4 11-3-5-5-3 12-3z" stroke="#fff" stroke-width="1.6"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        Kirim Referensi
                    </button>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // ── CSRF & Route ──────────────────────────────────────────────
        const csrfToken = '{{ csrf_token() }}';
        const routeReferensi = '{{ route('guru.materi.simpan-referensi') }}';

        // ══════════════════════════════════════════════════════════════
        // MODAL HELPERS
        // ══════════════════════════════════════════════════════════════
        function bukaModal(id) {
            document.getElementById(id).classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        function tutupModal(id) {
            document.getElementById(id).classList.remove('show');
            document.body.style.overflow = '';
        }

        function tutupModalLuar(e, id) {
            if (e.target === document.getElementById(id)) tutupModal(id);
        }

        function bukaModalTambah() {
            bukaModal('modal-tambah');
        }

        // Buka modal rekam (dari tombol tabel atau setelah simpan)
        function bukaModalRekam(idMateri, teksBacaan) {
            resetRekam();
            currentIdMateri = idMateri;
            currentTeks = teksBacaan;
            document.getElementById('rekam-teks-display').textContent = teksBacaan;
            bukaModal('modal-rekam');
        }

        function tutupModalRekam() {
            if (mediaRecorder && mediaRecorder.state !== 'inactive') {
                mediaRecorder.stop();
                stopTimer();
            }
            resetRekam();
            tutupModal('modal-rekam');
        }

        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') {
                tutupModal('modal-tambah');
                tutupModalRekam();
            }
        });

        // Buka modal tambah jika ada validation error
        @if ($errors->any())
            document.addEventListener('DOMContentLoaded', () => bukaModalTambah());
        @endif

        // ✅ FIX: json_encode aman dari karakter kutip/apostrof di teks
        @if (session('new_materi_id'))
            document.addEventListener('DOMContentLoaded', () => {
                bukaModalRekam(
                    '{{ session('new_materi_id') }}',
                    {!! json_encode(session('new_materi_teks')) !!}
                );
            });
        @endif

        // ══════════════════════════════════════════════════════════════
        // REKAM SUARA REFERENSI
        // ══════════════════════════════════════════════════════════════
        let mediaRecorder = null;
        let audioChunks = [];
        let audioBlob = null;
        let timerInterval = null;
        let timerSec = 0;
        let currentIdMateri = null;
        let currentTeks = '';

        function showRS(name) {
            ['idle', 'recording', 'done', 'loading', 'sukses'].forEach(n => {
                document.getElementById('rs-' + n).style.display = n === name ? 'flex' : 'none';
            });
        }

        function showBtn(...ids) {
            ['rbtn-mulai', 'rbtn-stop', 'rbtn-ulang', 'rbtn-kirim'].forEach(id => {
                document.getElementById(id).style.display = ids.includes(id) ? 'inline-flex' : 'none';
            });
        }

        function formatTime(s) {
            return `${Math.floor(s/60).toString().padStart(2,'0')}:${(s%60).toString().padStart(2,'0')}`;
        }

        function startTimer() {
            timerSec = 0;
            document.getElementById('rekam-timer').textContent = formatTime(0);
            timerInterval = setInterval(() => {
                timerSec++;
                document.getElementById('rekam-timer').textContent = formatTime(timerSec);
            }, 1000);
        }

        function stopTimer() {
            clearInterval(timerInterval);
        }

        function showRekamError(msg) {
            const box = document.getElementById('rekam-error-box');
            document.getElementById('rekam-error-msg').textContent = msg;
            box.style.display = 'flex';
        }

        function hideRekamError() {
            document.getElementById('rekam-error-box').style.display = 'none';
        }

        function resetRekam() {
            audioBlob = null;
            document.getElementById('rekam-audio-preview').src = '';
            showRS('idle');
            showBtn('rbtn-mulai');
            hideRekamError();
        }

        async function mulaiRekam() {
            hideRekamError();
            try {
                const stream = await navigator.mediaDevices.getUserMedia({
                    audio: true
                });
                audioChunks = [];
                const mime = MediaRecorder.isTypeSupported('audio/webm') ? 'audio/webm' : 'audio/ogg';
                mediaRecorder = new MediaRecorder(stream, {
                    mimeType: mime
                });

                mediaRecorder.ondataavailable = e => {
                    if (e.data.size > 0) audioChunks.push(e.data);
                };
                mediaRecorder.onstop = () => {
                    stream.getTracks().forEach(t => t.stop());
                    audioBlob = new Blob(audioChunks, {
                        type: mime
                    });
                    document.getElementById('rekam-audio-preview').src = URL.createObjectURL(audioBlob);
                    showRS('done');
                    showBtn('rbtn-ulang', 'rbtn-kirim');
                };

                mediaRecorder.start();
                startTimer();
                showRS('recording');
                showBtn('rbtn-stop');

            } catch (err) {
                const msg = (err.name === 'NotAllowedError' || err.name === 'PermissionDeniedError') ?
                    'Izin mikrofon ditolak. Izinkan akses mikrofon di browser.' :
                    'Tidak dapat mengakses mikrofon: ' + err.message;
                showRekamError(msg);
            }
        }

        function stopRekam() {
            if (mediaRecorder && mediaRecorder.state !== 'inactive') {
                mediaRecorder.stop();
                stopTimer();
            }
            showBtn();
        }

        function ulangRekam() {
            resetRekam();
        }

        async function kirimReferensi() {
            if (!audioBlob) {
                showRekamError('Belum ada rekaman.');
                return;
            }

            showRS('loading');
            showBtn();
            document.getElementById('rekam-loading-text').textContent = 'Mengirim ke server...';

            const ext = audioBlob.type.includes('webm') ? 'webm' : 'ogg';
            const fd = new FormData();
            fd.append('audio', new File([audioBlob], `referensi.${ext}`, {
                type: audioBlob.type
            }));
            fd.append('id_materi', currentIdMateri);
            fd.append('_token', csrfToken);

            try {
                const resp = await fetch(routeReferensi, {
                    method: 'POST',
                    body: fd
                });
                const data = await resp.json();

                if (data.status === 'ok') {
                    showRS('sukses');
                    setTimeout(() => tutupModalRekam(), 2000);
                } else {
                    showRS('done');
                    showBtn('rbtn-ulang', 'rbtn-kirim');
                    showRekamError(data.pesan || 'Gagal mengirim. Coba lagi.');
                }
            } catch (err) {
                showRS('done');
                showBtn('rbtn-ulang', 'rbtn-kirim');
                showRekamError('Koneksi gagal. Pastikan server aktif.');
            }
        }
    </script>
@endpush
