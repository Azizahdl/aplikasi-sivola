@extends('layouts.siswa')

@push('styles')
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/siswa/materi/show.css') }}">
@endpush

@section('content')
    <div class="container-fluid">

        {{-- STEP INDICATOR --}}
        <div class="step-bar">
            <div class="step done">
                <div class="step-dot">
                    <svg width="12" height="12" fill="none" viewBox="0 0 16 16">
                        <path d="M3 8l4 4 6-6" stroke="#fff" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </div>
                <span>Pilih Kategori Materi</span>
            </div>
            <div class="step-line filled"></div>
            <div class="step done">
                <div class="step-dot">
                    <svg width="12" height="12" fill="none" viewBox="0 0 16 16">
                        <path d="M3 8l4 4 6-6" stroke="#fff" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </div>
                <span>Pilih Materi</span>
            </div>
            <div class="step-line filled"></div>
            <div class="step active">
                <div class="step-dot">3</div>
                <span>Mulai Latihan</span>
            </div>
        </div>

        {{-- MATERI + REKAM CARD (digabung) --}}
        <div class="materi-card">

            {{-- HEADER BADGE --}}
            <div class="materi-card-header">
                <span class="kategori-badge kategori-{{ strtolower(str_replace('_', '-', $materi->kategori)) }}">
                    {{ ucfirst(str_replace('_', ' ', $materi->kategori)) }}
                </span>
                <span class="threshold-info">
                    <svg width="13" height="13" fill="none" viewBox="0 0 16 16">
                        <path d="M8 2l1.8 3.6L14 6.4l-3 2.9.7 4.1L8 11.3l-3.7 2.1.7-4.1L2 6.4l4.2-.8L8 2z"
                            stroke="currentColor" stroke-width="1.3" stroke-linejoin="round" />
                    </svg>
                    Target {{ $materi->threshold * 100 }}%
                </span>
            </div>

            {{-- TEKS BACAAN --}}
            <div class="instruction-text">Ucapkan teks berikut dengan jelas:</div>
            <div class="teks-bacaan">{{ $materi->teks_bacaan }}</div>

            {{-- DIVIDER --}}
            <div style="border-top: 0.5px solid rgba(0,0,0,0.08); margin: 0.75rem 0;"></div>

            <div class="status-area" id="status-area">
                <div class="status-idle" id="status-idle">
                    <div class="mic-visual">
                        <svg width="36" height="36" fill="none" viewBox="0 0 24 24">
                            <rect x="9" y="2" width="6" height="12" rx="3" stroke="currentColor"
                                stroke-width="1.5" />
                            <path d="M5 10a7 7 0 0014 0M12 19v3M8 22h8" stroke="currentColor" stroke-width="1.5"
                                stroke-linecap="round" />
                        </svg>
                    </div>
                    <p class="status-label">Siap merekam</p>
                    <p class="status-hint">Tekan tombol di bawah untuk mulai</p>
                </div>

                <div class="status-recording" id="status-recording">
                    <div class="recording-pulse">
                        <div class="pulse-ring"></div>
                        <div class="pulse-ring delay"></div>
                        <svg width="32" height="32" fill="none" viewBox="0 0 24 24">
                            <rect x="9" y="2" width="6" height="12" rx="3" fill="#ef4444" stroke="#ef4444"
                                stroke-width="1.2" />
                            <path d="M5 10a7 7 0 0014 0M12 19v3M8 22h8" stroke="#ef4444" stroke-width="1.5"
                                stroke-linecap="round" />
                        </svg>
                    </div>
                    <p class="status-label recording">Merekam...</p>
                    <p class="status-hint" id="timer-display">00:00</p>
                </div>

                <div class="status-processing" id="status-processing" style="display:none">
                    <div class="mic-visual" style="opacity:.6">
                        <svg width="36" height="36" fill="none" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10" stroke="#a78bfa" stroke-width="1.5"
                                stroke-dasharray="4 2" />
                        </svg>
                    </div>
                    <p class="status-label" style="color:#a78bfa">Memvalidasi...</p>
                    <p class="status-hint">Sedang memvalidasi rekaman</p>
                </div>
            </div>

            <div class="btn-group">
                <button type="button" id="btn-mulai" class="btn-rekam btn-start">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24">
                        <rect x="9" y="2" width="6" height="12" rx="3" stroke="currentColor"
                            stroke-width="1.6" />
                        <path d="M5 10a7 7 0 0014 0M12 19v3M8 22h8" stroke="currentColor" stroke-width="1.6"
                            stroke-linecap="round" />
                    </svg>
                    Mulai Rekam
                </button>
                <button type="button" id="btn-stop" class="btn-rekam btn-stop">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24">
                        <rect x="5" y="5" width="14" height="14" rx="2" fill="currentColor" />
                    </svg>
                    Stop & Validasi
                </button>
            </div>

            <div id="mic-error" class="mic-error">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10" stroke="#ef4444" stroke-width="1.5" />
                    <path d="M12 8v5M12 16v.5" stroke="#ef4444" stroke-width="1.8" stroke-linecap="round" />
                </svg>
                <span id="mic-error-msg">Tidak dapat mengakses mikrofon.</span>
            </div>

            {{-- Data untuk JS --}}
            <span id="js-id-materi" style="display:none">{{ $materi->id_materi }}</span>
            <span id="js-teks-bacaan" style="display:none">{{ $materi->teks_bacaan }}</span>
            <span id="js-csrf" style="display:none">{{ csrf_token() }}</span>
            <span id="js-route-validasi" style="display:none">{{ route('siswa.materi.validasi') }}</span>
            <span id="js-route-kembali"
                style="display:none">{{ route('siswa.materi.kategori', $materi->kategori) }}</span>

        </div>

        <div class="back-wrap">
            <a href="{{ route('siswa.materi.kategori', $materi->kategori) }}" class="btn-back">
                <svg width="16" height="16" fill="none" viewBox="0 0 16 16">
                    <path d="M10 3L5 8l5 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
                Kembali ke Daftar Materi
            </a>
        </div>

    </div>

    {{-- LOADING OVERLAY --}}
    <div id="loading-overlay">
        <div class="loading-spinner"></div>
        <p class="loading-text" id="loading-text">Mengirim rekaman...</p>
    </div>

    {{-- HASIL OVERLAY --}}
    <div id="hasil-overlay">
        <div class="hasil-card" id="hasil-card">
            <div class="confetti-container" id="confetti-container"></div>
            <div class="hasil-icon-wrap" id="hasil-icon-wrap"></div>
            <p class="hasil-label" id="hasil-label"></p>
            <p class="hasil-sublabel" id="hasil-sublabel"></p>
            <div class="skor-wrap">
                <div class="skor-row">
                    <span>Kemiripan suara</span>
                    <span class="skor-number" id="skor-number">0%</span>
                </div>
                <div class="skor-bar-bg">
                    <div class="skor-bar-fill" id="skor-bar-fill"></div>
                </div>
            </div>
            <div class="threshold-badge">
                <svg width="12" height="12" fill="none" viewBox="0 0 16 16">
                    <path d="M8 2l1.8 3.6L14 6.4l-3 2.9.7 4.1L8 11.3l-3.7 2.1.7-4.1L2 6.4l4.2-.8L8 2z"
                        stroke="currentColor" stroke-width="1.3" stroke-linejoin="round" />
                </svg>
                <span id="threshold-text"></span>
            </div>
            <div class="hasil-actions">
                <button class="btn-hasil btn-hasil-ulang" id="btn-coba-lagi">
                    <svg width="15" height="15" fill="none" viewBox="0 0 24 24">
                        <path d="M1 4v6h6M23 20v-6h-6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path d="M20.49 9A9 9 0 005.64 5.64L1 10M23 14l-4.64 4.36A9 9 0 013.51 15"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    Coba Lagi
                </button>
                <button class="btn-hasil btn-hasil-lanjut" id="btn-lanjut">
                    <svg width="15" height="15" fill="none" viewBox="0 0 24 24">
                        <path d="M5 12h14M12 5l7 7-7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                    Materi Lain
                </button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        (function() {
            'use strict';

            // ── Elemen ───────────────────────────────────────────────────────
            const btnMulai      = document.getElementById('btn-mulai');
            const btnStop       = document.getElementById('btn-stop');
            const timerDisplay  = document.getElementById('timer-display');
            const micError      = document.getElementById('mic-error');
            const micErrorMsg   = document.getElementById('mic-error-msg');
            const statusIdle    = document.getElementById('status-idle');
            const statusRecording = document.getElementById('status-recording');
            const statusProc    = document.getElementById('status-processing');
            const loadingOverlay = document.getElementById('loading-overlay');
            const loadingText   = document.getElementById('loading-text');
            const hasilOverlay  = document.getElementById('hasil-overlay');
            const hasilCard     = document.getElementById('hasil-card');
            const hasilIconWrap = document.getElementById('hasil-icon-wrap');
            const hasilLabel    = document.getElementById('hasil-label');
            const hasilSublabel = document.getElementById('hasil-sublabel');
            const skorNumber    = document.getElementById('skor-number');
            const skorBarFill   = document.getElementById('skor-bar-fill');
            const thresholdText = document.getElementById('threshold-text');
            const btnCobaLagi   = document.getElementById('btn-coba-lagi');
            const btnLanjut     = document.getElementById('btn-lanjut');

            // ── Data dari server ─────────────────────────────────────────────
            const idMateri      = document.getElementById('js-id-materi').textContent.trim();
            const teksBacaan    = document.getElementById('js-teks-bacaan').textContent.trim();
            const csrfToken     = document.getElementById('js-csrf').textContent.trim();
            const routeValidasi = document.getElementById('js-route-validasi').textContent.trim();
            const routeKembali  = document.getElementById('js-route-kembali').textContent.trim();

            // ── State ─────────────────────────────────────────────────────────
            let mediaRecorder = null;
            let audioChunks   = [];
            let timerInterval = null;
            let seconds       = 0;

            // ── Helpers ───────────────────────────────────────────────────────
            const showBtn = el => el.style.display = 'inline-flex';
            const hideEl  = el => el.style.display = 'none';

            function showStatus(name) {
                statusIdle.style.display      = 'none';
                statusRecording.style.display = 'none';
                statusProc.style.display      = 'none';
                document.getElementById('status-' + name).style.display = 'flex';
            }

            function formatTime(s) {
                return `${Math.floor(s/60).toString().padStart(2,'0')}:${(s%60).toString().padStart(2,'0')}`;
            }

            function startTimer() {
                seconds = 0;
                timerDisplay.textContent = formatTime(0);
                timerInterval = setInterval(() => {
                    seconds++;
                    timerDisplay.textContent = formatTime(seconds);
                }, 1000);
            }

            function stopTimer() { clearInterval(timerInterval); }

            function showError(msg) {
                micErrorMsg.textContent = msg || 'Terjadi kesalahan.';
                micError.style.display  = 'flex';
            }

            function hideError() { hideEl(micError); }

            function showLoading(msg) {
                loadingText.textContent = msg || 'Memproses...';
                loadingOverlay.classList.add('show');
            }

            function hideLoading() { loadingOverlay.classList.remove('show'); }

            // ── Sound (Web Audio API) ─────────────────────────────────────────
            function playSound(type) {
                try {
                    const ctx = new (window.AudioContext || window.webkitAudioContext)();
                    if (type === 'benar') {
                        [[261.6, 0], [329.6, .12], [392, .24]].forEach(([freq, delay]) => {
                            const osc = ctx.createOscillator(), gain = ctx.createGain();
                            osc.connect(gain); gain.connect(ctx.destination);
                            osc.type = 'sine';
                            osc.frequency.value = freq;
                            gain.gain.setValueAtTime(0, ctx.currentTime + delay);
                            gain.gain.linearRampToValueAtTime(.35, ctx.currentTime + delay + .04);
                            gain.gain.exponentialRampToValueAtTime(.001, ctx.currentTime + delay + .5);
                            osc.start(ctx.currentTime + delay);
                            osc.stop(ctx.currentTime + delay + .5);
                        });
                    } else {
                        [[300, 0], [220, .18]].forEach(([freq, delay]) => {
                            const osc = ctx.createOscillator(), gain = ctx.createGain();
                            osc.connect(gain); gain.connect(ctx.destination);
                            osc.type = 'sawtooth';
                            osc.frequency.value = freq;
                            gain.gain.setValueAtTime(0, ctx.currentTime + delay);
                            gain.gain.linearRampToValueAtTime(.2, ctx.currentTime + delay + .04);
                            gain.gain.exponentialRampToValueAtTime(.001, ctx.currentTime + delay + .4);
                            osc.start(ctx.currentTime + delay);
                            osc.stop(ctx.currentTime + delay + .4);
                        });
                    }
                } catch (_) {}
            }

            // ── Text-to-Speech Hasil ──────────────────────────────────────────
            function ucapkanHasil(benar) {
                if (!window.speechSynthesis) return;
                window.speechSynthesis.cancel();
                const pesan = benar
                    ? 'Benar! Pengucapanmu sudah tepat. Bagus sekali!'
                    : 'Salah! Pengucapanmu belum tepat. Yuk coba lagi!';
                const ucap    = new SpeechSynthesisUtterance(pesan);
                ucap.lang     = 'id-ID';
                ucap.rate     = 0.95;
                ucap.pitch    = benar ? 1.2 : 0.9;
                ucap.volume   = 1;
                window.speechSynthesis.speak(ucap);
            }

            // ── Confetti ──────────────────────────────────────────────────────
            function launchConfetti() {
                const container = document.getElementById('confetti-container');
                const colors = ['#22c55e','#86efac','#bbf7d0','#fbbf24','#a78bfa','#60a5fa'];
                for (let i = 0; i < 28; i++) {
                    const dot = document.createElement('div');
                    dot.className = 'confetti-dot';
                    dot.style.cssText = `
                        left:${Math.random()*100}%;
                        top:${Math.random()*30}%;
                        background:${colors[Math.floor(Math.random()*colors.length)]};
                        animation-delay:${Math.random()*.6}s;
                        animation-duration:${.8+Math.random()*.8}s;
                        transform:rotate(${Math.random()*360}deg);
                    `;
                    container.appendChild(dot);
                }
                setTimeout(() => { container.innerHTML = ''; }, 2200);
            }

            // ── Tampilkan hasil ───────────────────────────────────────────────
            function tampilkanHasil(data) {
                const benar = data.status === 'benar';
                const skor  = parseFloat(data.skor) || 0;
                const thr   = parseFloat(data.threshold) || 0;

                hasilCard.className = `hasil-card ${data.status}`;

                hasilIconWrap.innerHTML = benar
                    ? `<svg width="52" height="52" fill="none" viewBox="0 0 24 24">
                         <circle cx="12" cy="12" r="10" stroke="#22c55e" stroke-width="1.5"/>
                         <path d="M7 12l4 4 6-6" stroke="#22c55e" stroke-width="2.5"
                               stroke-linecap="round" stroke-linejoin="round"/>
                       </svg>`
                    : `<svg width="52" height="52" fill="none" viewBox="0 0 24 24">
                         <circle cx="12" cy="12" r="10" stroke="#ef4444" stroke-width="1.5"/>
                         <path d="M15 9l-6 6M9 9l6 6" stroke="#ef4444" stroke-width="2.5"
                               stroke-linecap="round" stroke-linejoin="round"/>
                       </svg>`;

                hasilLabel.textContent    = benar ? 'Benar!' : 'Salah!';
                hasilSublabel.textContent = benar
                    ? 'Pengucapanmu sudah tepat. Bagus sekali!'
                    : 'Pengucapanmu belum tepat. Yuk coba lagi!';
                thresholdText.textContent = `Target minimal ${thr}%`;

                skorNumber.textContent    = '0%';
                skorBarFill.style.width   = '0%';
                hasilOverlay.classList.add('show');

                // Animasi bar
                requestAnimationFrame(() => {
                    setTimeout(() => {
                        skorBarFill.style.width = Math.min(skor, 100) + '%';
                    }, 120);
                });

                // Animasi angka
                const start = performance.now();
                function animateSkor(now) {
                    const p = Math.min((now - start) / 1000, 1);
                    const e = 1 - Math.pow(1 - p, 3);
                    skorNumber.textContent = (e * skor).toFixed(1) + '%';
                    if (p < 1) requestAnimationFrame(animateSkor);
                    else skorNumber.textContent = skor.toFixed(1) + '%';
                }
                requestAnimationFrame(animateSkor);

                // Efek suara + TTS
                if (benar) launchConfetti();
                playSound(data.status);
                ucapkanHasil(benar);
            }

            // ── Kirim audio ke Laravel ────────────────────────────────────────
            async function kirimAudio(blob) {
                showLoading('Mengirim rekaman...');
                showStatus('processing');

                const ext = blob.type.includes('webm') ? 'webm' : 'ogg';
                const fd  = new FormData();
                fd.append('audio',       new File([blob], `rekaman.${ext}`, { type: blob.type }));
                fd.append('id_materi',   idMateri);
                fd.append('teks_bacaan', teksBacaan);
                fd.append('_token',      csrfToken);

                try {
                    loadingText.textContent = 'Memvalidasi suara...';
                    const resp = await fetch(routeValidasi, { method: 'POST', body: fd });
                    const data = await resp.json();
                    hideLoading();

                    if (data.status === 'error') {
                        showError(data.pesan || 'Terjadi kesalahan pada server.');
                        showStatus('idle');
                        showBtn(btnMulai);
                        return;
                    }

                    tampilkanHasil(data);

                } catch (err) {
                    hideLoading();
                    showError('Koneksi gagal. Pastikan server aktif dan coba lagi.');
                    showStatus('idle');
                    showBtn(btnMulai);
                }
            }

            // ── Init state awal ───────────────────────────────────────────────
            hideEl(btnStop);
            hideEl(micError);
            statusRecording.style.display = 'none';

            // ── MULAI REKAM ───────────────────────────────────────────────────
            btnMulai.addEventListener('click', async () => {
                hideError();
                try {
                    const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
                    audioChunks  = [];

                    const mimeType = MediaRecorder.isTypeSupported('audio/webm') ? 'audio/webm' : 'audio/ogg';
                    mediaRecorder  = new MediaRecorder(stream, { mimeType });

                    mediaRecorder.ondataavailable = e => {
                        if (e.data.size > 0) audioChunks.push(e.data);
                    };

                    mediaRecorder.onstop = () => {
                        stream.getTracks().forEach(t => t.stop());
                        kirimAudio(new Blob(audioChunks, { type: mimeType }));
                    };

                    mediaRecorder.start();
                    startTimer();
                    showStatus('recording');
                    hideEl(btnMulai);
                    showBtn(btnStop);

                } catch (err) {
                    showError(
                        (err.name === 'NotAllowedError' || err.name === 'PermissionDeniedError')
                            ? 'Izin mikrofon ditolak. Silakan izinkan akses mikrofon di browser kamu.'
                            : 'Tidak dapat mengakses mikrofon: ' + err.message
                    );
                }
            });

            // ── STOP → langsung kirim ─────────────────────────────────────────
            btnStop.addEventListener('click', () => {
                if (mediaRecorder && mediaRecorder.state !== 'inactive') {
                    mediaRecorder.stop();
                    stopTimer();
                    hideEl(btnStop);
                }
            });

            // ── Coba Lagi ─────────────────────────────────────────────────────
            btnCobaLagi.addEventListener('click', () => {
                window.speechSynthesis && window.speechSynthesis.cancel();
                hasilOverlay.classList.remove('show');
                showStatus('idle');
                showBtn(btnMulai);
                hideError();
            });

            // ── Materi Lain ───────────────────────────────────────────────────
            btnLanjut.addEventListener('click', () => {
                window.speechSynthesis && window.speechSynthesis.cancel();
                window.location.href = routeKembali;
            });

        })();
    </script>
@endpush