@extends('layouts.guru')

@section('content')
    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Custom Dashboard CSS --}}
    <link href="{{ asset('frontend/assets/css/guru/dashboard/dashboard.css') }}" rel="stylesheet">

    {{-- Chart.js --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>

    <style>
        .chart-toggle {
            display: inline-flex;
            background: #f7f7f7;
            border-radius: 999px;
            padding: 3px;
            gap: 2px;
        }

        .chart-toggle-btn {
            border: none;
            background: transparent;
            padding: 6px 14px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 500;
            color: #888;
            cursor: pointer;
            transition: 0.2s;
        }

        .chart-toggle-btn:hover {
            color: #555;
        }
    </style>

    <div class="db-wrapper mt-0 pt-0">

        {{-- WELCOME BANNER --}}
        <div class="welcome-banner mb-3">
            <div class="bdeco d1"></div>
            <div class="bdeco d2"></div>
            <div class="bdeco d3"></div>
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="banner-text">
                    <h2>Selamat datang, {{ auth()->user()->nama ?? 'Guru' }}</h2>
                    <p>Pantau terus hasil latihan membaca siswa Anda hari ini.</p>
                    <div class="banner-date">
                        <svg width="13" height="13" fill="none" viewBox="0 0 16 16">
                            <rect x="1" y="3" width="14" height="12" rx="2" stroke="rgba(255,255,255,0.75)" stroke-width="1.4" />
                            <path d="M5 1v4M11 1v4M1 7h14" stroke="rgba(255,255,255,0.75)" stroke-width="1.4" stroke-linecap="round" />
                        </svg>
                        {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                    </div>
                </div>
                <div class="banner-badge">
                    <span>Tahun Ajaran</span>
                    <strong>2025 / 2026</strong>
                </div>
            </div>
        </div>

        {{-- STAT CARDS --}}
        <div class="row g-3 mb-3">

            <div class="col-12 col-md-4">
                <a href="{{ route('guru.manajemen-user.index', ['role' => 'siswa']) }}" class="stat-card-link">
                    <div class="stat-card s-orange h-100">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="stat-label">Total Siswa</span>
                            <div class="stat-icon-box" style="background:var(--primary-light);">
                                <svg width="18" height="18" fill="none" viewBox="0 0 20 20">
                                    <circle cx="8" cy="6" r="3.5" stroke="#FF8C42" stroke-width="1.5" />
                                    <path d="M1 17c0-3.314 3.134-6 7-6" stroke="#FF8C42" stroke-width="1.5" stroke-linecap="round" />
                                    <path d="M13 13l2 2 3-3" stroke="#FF8C42" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>
                        </div>
                        <div class="stat-value">{{ $totalSiswa ?? 0 }}</div>
                        <p class="stat-sub">Total seluruh siswa terdaftar</p>
                    </div>
                </a>
            </div>

            <div class="col-12 col-md-4">
                <a href="{{ route('guru.manajemen-user.index', ['role' => 'siswa', 'status' => 'aktif']) }}" class="stat-card-link">
                    <div class="stat-card s-blue h-100">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="stat-label">Siswa Aktif</span>
                            <div class="stat-icon-box" style="background:var(--accent-light);">
                                <svg width="18" height="18" fill="none" viewBox="0 0 20 20">
                                    <circle cx="8" cy="6" r="3.5" stroke="#73A5CA" stroke-width="1.5" />
                                    <path d="M1 17c0-3.314 3.134-6 7-6" stroke="#73A5CA" stroke-width="1.5" stroke-linecap="round" />
                                    <path d="M13 13l2 2 3-3" stroke="#73A5CA" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>
                        </div>
                        <div class="stat-value">{{ $totalSiswaAktif ?? 0 }}</div>
                        <p class="stat-sub">Status akun aktif</p>
                    </div>
                </a>
            </div>

            <div class="col-12 col-md-4">
                <a href="{{ route('guru.manajemen-user.index', ['role' => 'siswa', 'status' => 'nonaktif']) }}" class="stat-card-link">
                    <div class="stat-card s-warn h-100">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="stat-label">Siswa Nonaktif</span>
                            <div class="stat-icon-box" style="background:var(--danger-light);">
                                <svg width="18" height="18" fill="none" viewBox="0 0 20 20">
                                    <path d="M10 6v5M10 14h.01" stroke="#e05c2a" stroke-width="1.5" stroke-linecap="round" />
                                    <circle cx="10" cy="10" r="8" stroke="#e05c2a" stroke-width="1.5" />
                                </svg>
                            </div>
                        </div>
                        <div class="stat-value">{{ $totalSiswaNonaktif ?? 0 }}</div>
                        <p class="stat-sub">Status akun nonaktif</p>
                    </div>
                </a>
            </div>

        </div>
        {{-- END STAT CARDS --}}

        {{-- <div class="col-12 col-md-4">
            <div class="stat-card s-blue h-100">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <span class="stat-label">Total Uji Pelafalan</span>
                    <div class="stat-icon-box" style="background:var(--accent-light);">
                        <svg width="18" height="18" fill="none" viewBox="0 0 20 20">
                            <path d="M10 2a4 4 0 014 4v2a4 4 0 01-8 0V6a4 4 0 014-4z" stroke="#73A5CA" stroke-width="1.5" />
                            <path d="M4 18c0-3.314 2.686-6 6-6s6 2.686 6 6" stroke="#73A5CA" stroke-width="1.5" stroke-linecap="round" />
                        </svg>
                    </div>
                </div>
                <div class="stat-value">{{ $totalUjiPelafalan ?? 312 }}</div>
                <p class="stat-sub"><span class="up">+28</span> minggu ini</p>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="stat-card s-warn h-100">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <span class="stat-label">Perlu Bimbingan</span>
                    <div class="stat-icon-box" style="background:var(--danger-light);">
                        <svg width="18" height="18" fill="none" viewBox="0 0 20 20">
                            <path d="M10 6v5M10 14h.01" stroke="#e05c2a" stroke-width="1.5" stroke-linecap="round" />
                            <circle cx="10" cy="10" r="8" stroke="#e05c2a" stroke-width="1.5" />
                        </svg>
                    </div>
                </div>
                <div class="stat-value">{{ $siswaPerlubimbingan ?? 6 }}</div>
                <p class="stat-sub"><span class="dn">Cosine similarity &lt; 0.6</span></p>
            </div>
        </div> --}}

        {{-- MATERI CARDS
        <div class="row g-3 mb-3">
            <div class="col-12 col-md-4">
                <div class="d-flex align-items-center gap-3 p-3 bg-white rounded-3 border" style="border-color:var(--border)!important;">
                    <div class="stat-icon-box" style="background:#FFF0E6; width:44px; height:44px; border-radius:12px;">
                        <svg width="20" height="20" fill="none" viewBox="0 0 24 24"><path d="M4 6h16M4 10h10M4 14h8" stroke="#FF8C42" stroke-width="1.8" stroke-linecap="round"/></svg>
                    </div>
                    <div>
                        <div class="fw-semibold" style="font-size:13px; color:var(--dark);">Abjad</div>
                        <div style="font-size:12px; color:var(--muted);">{{ $totalUjiAbjad ?? 134 }} percobaan</div>
                        <div class="fw-bold" style="font-size:13px; color:#FF8C42;">{{ $avgAbjad ?? '0.84' }} <span class="fw-normal" style="font-size:11px; color:var(--muted);">avg cosine</span></div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="d-flex align-items-center gap-3 p-3 bg-white rounded-3 border" style="border-color:var(--border)!important;">
                    <div class="stat-icon-box" style="background:#EBF3FA; width:44px; height:44px; border-radius:12px;">
                        <svg width="20" height="20" fill="none" viewBox="0 0 24 24"><path d="M12 4C8 4 5 7 5 11s3 7 7 7 7-3 7-7-3-7-7-7z" stroke="#73A5CA" stroke-width="1.8"/><path d="M9 11l2 2 4-4" stroke="#73A5CA" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <div>
                        <div class="fw-semibold" style="font-size:13px; color:var(--dark);">Suku Kata</div>
                        <div style="font-size:12px; color:var(--muted);">{{ $totalUjiSukukata ?? 98 }} percobaan</div>
                        <div class="fw-bold" style="font-size:13px; color:#73A5CA;">{{ $avgSukukata ?? '0.76' }} <span class="fw-normal" style="font-size:11px; color:var(--muted);">avg cosine</span></div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="d-flex align-items-center gap-3 p-3 bg-white rounded-3 border" style="border-color:var(--border)!important;">
                    <div class="stat-icon-box" style="background:#FFF8EC; width:44px; height:44px; border-radius:12px;">
                        <svg width="20" height="20" fill="none" viewBox="0 0 24 24"><rect x="4" y="4" width="16" height="16" rx="3" stroke="#FFB347" stroke-width="1.8"/><path d="M8 9h8M8 12h6M8 15h4" stroke="#FFB347" stroke-width="1.5" stroke-linecap="round"/></svg>
                    </div>
                    <div>
                        <div class="fw-semibold" style="font-size:13px; color:var(--dark);">Kata Dasar</div>
                        <div style="font-size:12px; color:var(--muted);">{{ $totalUjiKatadasar ?? 80 }} percobaan</div>
                        <div class="fw-bold" style="font-size:13px; color:#FFB347;">{{ $avgKatadasar ?? '0.71' }} <span class="fw-normal" style="font-size:11px; color:var(--muted);">avg cosine</span></div>
                    </div>
                </div>
            </div>
        </div>
        --}}

        {{-- GRAFIK PERKEMBANGAN BULANAN --}}
        <div class="row g-3 mb-3">
            <div class="col-12">
                <div class="chart-card">
                    <div class="d-flex justify-content-between align-items-start mb-3 flex-wrap gap-2">
                        <div>
                            <div class="chart-title-text">Grafik Perkembangan Aktivitas Membaca Siswa</div>
                            <div class="chart-subtitle">Tren mingguan (±12 minggu / 3 bulan) menuju ujian — pilih periode di bawah</div>
                        </div>
                        <div class="chart-toggle">
                            <button type="button" class="chart-toggle-btn" id="btnToggleUts" onclick="switchPerkembangan('uts', this)">Menuju UTS</button>
                            <button type="button" class="chart-toggle-btn" id="btnToggleUas" onclick="switchPerkembangan('uas', this)">Menuju UAS</button>
                        </div>
                    </div>

                    <div style="position:relative; height:300px;">
                        <canvas id="perkembanganChart"></canvas>
                    </div>

                    <div class="chart-legend mt-3">
                        <div class="legend-item">
                            <div class="legend-dot" id="perkembanganLegendDot" style="background:#73A5CA;"></div>
                            <span id="perkembanganLegendLabel">Rata-rata Skor — Menuju UTS</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- END GRAFIK PERKEMBANGAN BULANAN --}}

        {{-- BOTTOM GRID --}}
        <div class="row g-3 align-items-start">

            {{-- DONUT CHARTS --}}
            <div class="col-12 col-xl-8">
                <div class="chart-card">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div>
                            <div class="chart-title-text">Hasil Validasi Pelafalan per Materi</div>
                            <div class="chart-subtitle">Persentase pelafalan benar vs salah berdasarkan cosine similarity ≥ 0.6</div>
                        </div>
                    </div>

                    <div class="row g-3 justify-content-center">

                        @php
                            $bAbjad = $benarAbjad ?? 118; $sAbjad = $salahAbjad ?? 16;
                            $tAbjad = $bAbjad + $sAbjad;
                            $pAbjad = $tAbjad > 0 ? round($bAbjad / $tAbjad * 100) : null;

                            $bSuku = $benarSukukata ?? 71; $sSuku = $salahSukukata ?? 27;
                            $tSuku = $bSuku + $sSuku;
                            $pSuku = $tSuku > 0 ? round($bSuku / $tSuku * 100) : null;

                            $bKata = $benarKatadasar ?? 49; $sKata = $salahKatadasar ?? 31;
                            $tKata = $bKata + $sKata;
                            $pKata = $tKata > 0 ? round($bKata / $tKata * 100) : null;
                        @endphp

                        {{-- Abjad --}}
                        <div class="col-12 col-sm-4 d-flex justify-content-center">
                            <div class="donut-item">
                                <div class="donut-wrap">
                                    <canvas id="donutAbjad"></canvas>
                                    <div class="donut-center">
                                        <div class="donut-pct" style="color:#FF8C42;">{{ $pAbjad !== null ? $pAbjad . '%' : '-' }}</div>
                                        <div class="donut-desc">benar</div>
                                    </div>
                                </div>
                                <div class="donut-label">Abjad</div>
                                <div class="donut-stats">
                                    <div class="dstat">
                                        <div class="dstat-dot" style="background:#FF8C42;"></div>
                                        <strong>{{ $benarAbjad ?? 118 }}</strong>&nbsp;benar
                                    </div>
                                    <div class="dstat">
                                        <div class="dstat-dot" style="background:#f5ede4;border:1px solid #e05c2a;"></div>
                                        <strong>{{ $salahAbjad ?? 16 }}</strong>&nbsp;salah
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Suku Kata --}}
                        <div class="col-12 col-sm-4 d-flex justify-content-center">
                            <div class="donut-item">
                                <div class="donut-wrap">
                                    <canvas id="donutSukukata"></canvas>
                                    <div class="donut-center">
                                        <div class="donut-pct" style="color:#73A5CA;">{{ $pSuku !== null ? $pSuku . '%' : '-' }}</div>
                                        <div class="donut-desc">benar</div>
                                    </div>
                                </div>
                                <div class="donut-label">Suku Kata</div>
                                <div class="donut-stats">
                                    <div class="dstat">
                                        <div class="dstat-dot" style="background:#73A5CA;"></div>
                                        <strong>{{ $benarSukukata ?? 71 }}</strong>&nbsp;benar
                                    </div>
                                    <div class="dstat">
                                        <div class="dstat-dot" style="background:#f5ede4;border:1px solid #e05c2a;"></div>
                                        <strong>{{ $salahSukukata ?? 27 }}</strong>&nbsp;salah
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Kata Dasar --}}
                        <div class="col-12 col-sm-4 d-flex justify-content-center">
                            <div class="donut-item">
                                <div class="donut-wrap">
                                    <canvas id="donutKatadasar"></canvas>
                                    <div class="donut-center">
                                        <div class="donut-pct" style="color:#FFB347;">{{ $pKata !== null ? $pKata . '%' : '-' }}</div>
                                        <div class="donut-desc">benar</div>
                                    </div>
                                </div>
                                <div class="donut-label">Kata Dasar</div>
                                <div class="donut-stats">
                                    <div class="dstat">
                                        <div class="dstat-dot" style="background:#FFB347;"></div>
                                        <strong>{{ $benarKatadasar ?? 49 }}</strong>&nbsp;benar
                                    </div>
                                    <div class="dstat">
                                        <div class="dstat-dot" style="background:#f5ede4;border:1px solid #e05c2a;"></div>
                                        <strong>{{ $salahKatadasar ?? 31 }}</strong>&nbsp;salah
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>{{-- end row donut --}}

                    <div class="chart-legend mt-4">
                        <div class="legend-item">
                            <div class="legend-dot" style="background:#FF8C42;"></div> Abjad — benar
                        </div>
                        <div class="legend-item">
                            <div class="legend-dot" style="background:#73A5CA;"></div> Suku Kata — benar
                        </div>
                        <div class="legend-item">
                            <div class="legend-dot" style="background:#FFB347;"></div> Kata Dasar — benar
                        </div>
                        <div class="legend-item">
                            <div class="legend-dot" style="background:#f0e0d0; border:1.5px solid #e05c2a;"></div> Salah (semua materi)
                        </div>
                    </div>
                </div>
            </div>

            {{-- SIDE COLUMN --}}
            <div class="col-12 col-xl-4 d-flex flex-column gap-3">

                {{-- Progress Kelulusan --}}
                {{-- <div class="side-card">
                    <div class="side-card-title">Tingkat Kelulusan per Materi</div>
                    @php
                        $materis = $kelulusanMateri ?? [
                            ['nama' => 'Abjad',     'persen' => 88, 'warna' => '#FF8C42'],
                            ['nama' => 'Suku Kata', 'persen' => 72, 'warna' => '#73A5CA'],
                            ['nama' => 'Kata Dasar','persen' => 61, 'warna' => '#FFB347'],
                        ];
                    @endphp
                    @foreach ($materis as $m)
                        <div class="mb-3">
                            <div class="prog-top">
                                <span>{{ $m['nama'] }}</span>
                                <span>{{ $m['persen'] }}%</span>
                            </div>
                            <div class="prog-bg">
                                <div class="prog-fill" style="width:{{ $m['persen'] }}%; background:{{ $m['warna'] }};"></div>
                            </div>
                        </div>
                    @endforeach
                </div> --}}

                {{-- Aktivitas Terbaru --}}
                {{-- <div class="side-card">
                    <div class="side-card-title">Aktivitas Validasi Terbaru</div>
                    @php
                        $aktivitas = $aktivitasTerbaru ?? [
                            ['siswa'=>'Andi Saputra',    'materi'=>'Abjad — huruf "R"',      'skor'=>'0.91','status'=>'lulus', 'waktu'=>'5 menit lalu',  'warna'=>'#FF8C42'],
                            ['siswa'=>'Dewi Lestari',    'materi'=>'Suku Kata — "ba-ca"',     'skor'=>'0.78','status'=>'baik',  'waktu'=>'18 menit lalu', 'warna'=>'#73A5CA'],
                            ['siswa'=>'Riko Firmansyah', 'materi'=>'Kata Dasar — "buku"',     'skor'=>'0.52','status'=>'kurang','waktu'=>'32 menit lalu', 'warna'=>'#e05c2a'],
                            ['siswa'=>'Siti Rahayu',     'materi'=>'Abjad — huruf "S"',       'skor'=>'0.87','status'=>'lulus', 'waktu'=>'1 jam lalu',    'warna'=>'#FF8C42'],
                            ['siswa'=>'Budi Santoso',    'materi'=>'Suku Kata — "ma-kan"',    'skor'=>'0.63','status'=>'baik',  'waktu'=>'1 jam lalu',    'warna'=>'#FFB347'],
                        ];
                    @endphp
                    @foreach ($aktivitas as $a)
                        <div class="act-row">
                            <div class="act-dot" style="background:{{ $a['warna'] }};"></div>
                            <div class="flex-grow-1" style="min-width:0;">
                                <div class="d-flex justify-content-between align-items-start gap-2">
                                    <span class="act-name">{{ $a['siswa'] }}</span>
                                    <span class="score-badge score-{{ $a['status'] }}">{{ $a['skor'] }}</span>
                                </div>
                                <div class="act-mat">{{ $a['materi'] }}</div>
                                <div class="act-time">{{ $a['waktu'] }}</div>
                            </div>
                        </div>
                    @endforeach
                </div> --}}

            </div>

        </div>{{-- end bottom grid --}}

    </div>{{-- end db-wrapper --}}

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function makeDonut(id, benar, salah, color) {
            const ctx = document.getElementById(id).getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Benar', 'Salah'],
                    datasets: [{
                        data: [benar, salah],
                        backgroundColor: [color, '#f5ede4'],
                        borderColor: [color, '#e8d5c4'],
                        borderWidth: 1.5,
                        hoverOffset: 6,
                    }]
                },
                options: {
                    responsive: false,
                    cutout: '72%',
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: ctx => {
                                    const total = ctx.dataset.data.reduce((a, b) => a + b, 0);
                                    const pct = ((ctx.parsed / total) * 100).toFixed(1);
                                    return ` ${ctx.label}: ${ctx.parsed} (${pct}%)`;
                                }
                            }
                        }
                    },
                    animation: {
                        animateRotate: true,
                        duration: 900,
                        easing: 'easeInOutQuart',
                    }
                }
            });
        }

        makeDonut('donutAbjad',     {{ $benarAbjad     ?? 118 }}, {{ $salahAbjad     ?? 16 }}, '#FF8C42');
        makeDonut('donutSukukata',  {{ $benarSukukata  ?? 71  }}, {{ $salahSukukata  ?? 27 }}, '#73A5CA');
        makeDonut('donutKatadasar', {{ $benarKatadasar ?? 49  }}, {{ $salahKatadasar ?? 31 }}, '#FFB347');

        // ===== GRAFIK PERKEMBANGAN MINGGUAN: TOGGLE MENUJU UTS / MENUJU UAS =====

        // Data dari controller. Selama belum disambungkan, dipakai data contoh (fallback) di bawah ini.
        // ±12 minggu (≈3 bulan) menuju masing-masing ujian.
        @php
            $weeklyLabelsJs   = $weeklyLabels   ?? collect(range(1, 12))->map(fn($i) => "Minggu {$i}")->values()->all();
            $dataMenujuUTSJs  = $dataMenujuUTS  ?? [55, 58, 60, 62, 65, 67, 68, 70, 72, 74, 76, 78];
            $dataMenujuUASJs  = $dataMenujuUAS  ?? [70, 73, 75, 77, 79, 81, 83, 85, 86, 88, 90, 92];
        @endphp
        const weeklyLabels  = @json($weeklyLabelsJs);
        const dataMenujuUTS = @json($dataMenujuUTSJs);
        const dataMenujuUAS = @json($dataMenujuUASJs);

        const perkembanganColors = {
            uts: { border: '#73A5CA', bg: 'rgba(115,165,202,0.12)' },
            uas: { border: '#3B6D11', bg: 'rgba(59,109,17,0.12)' },
        };
        const perkembanganDatasets = {
            uts: { label: 'Menuju UTS', data: dataMenujuUTS },
            uas: { label: 'Menuju UAS', data: dataMenujuUAS },
        };

        const perkembanganChart = new Chart(document.getElementById('perkembanganChart').getContext('2d'), {
            type: 'line',
            data: {
                labels: weeklyLabels,
                datasets: [{
                    label: perkembanganDatasets.uts.label,
                    data: perkembanganDatasets.uts.data,
                    borderColor: perkembanganColors.uts.border,
                    backgroundColor: perkembanganColors.uts.bg,
                    fill: true,
                    tension: 0.35,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    pointBackgroundColor: perkembanganColors.uts.border,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: { mode: 'index', intersect: false },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: ctx => ` ${ctx.dataset.label}: ${ctx.parsed.y}%`
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        ticks: { callback: v => v + '%' },
                        grid: { color: '#f0ece6' }
                    },
                    x: { grid: { display: false } }
                }
            }
        });

        function switchPerkembangan(target, btnEl) {
            const cfg = perkembanganColors[target];
            const ds  = perkembanganDatasets[target];

            const dataset = perkembanganChart.data.datasets[0];
            dataset.label = ds.label;
            dataset.data = ds.data;
            dataset.borderColor = cfg.border;
            dataset.backgroundColor = cfg.bg;
            dataset.pointBackgroundColor = cfg.border;
            perkembanganChart.update();

            document.querySelectorAll('.chart-toggle-btn').forEach(b => {
                b.style.background = 'transparent';
                b.style.color = '#888';
            });
            btnEl.style.background = cfg.border;
            btnEl.style.color = '#fff';

            document.getElementById('perkembanganLegendDot').style.background = cfg.border;
            document.getElementById('perkembanganLegendLabel').textContent = 'Rata-rata Skor — ' + ds.label;
        }

        // Set tampilan awal: toggle "Menuju UTS" aktif
        switchPerkembangan('uts', document.getElementById('btnToggleUts'));
    </script>
@endsection