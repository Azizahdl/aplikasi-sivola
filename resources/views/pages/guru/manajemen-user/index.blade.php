@extends('layouts.guru')

@push('styles')
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/guru/manajemen-user/index.css') }}">
@endpush

@section('content')
<div class="container-fluid user-page">
    <div class="user-card">

        {{-- HEADER --}}
        <div class="user-card-header">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <div class="head-title">Manajemen Pengguna</div>
                    <div class="head-subtitle">Kelola data akun guru dan siswa</div>
                </div>
                <a href="{{ route('guru.manajemen-user.create') }}" class="btn-tambah">
                    <svg width="13" height="13" fill="none" viewBox="0 0 16 16">
                        <path d="M8 3v10M3 8h10" stroke="#fff" stroke-width="1.8" stroke-linecap="round"/>
                    </svg>
                    Tambah Pengguna
                </a>
            </div>

            {{-- FILTER --}}
            <form method="GET" class="filter-row">
                <select name="role" class="filter-select" onchange="this.form.submit()">
                    <option value="">Semua Role</option>
                    <option value="guru"  {{ request('role') == 'guru'  ? 'selected' : '' }}>Guru</option>
                    <option value="siswa" {{ request('role') == 'siswa' ? 'selected' : '' }}>Siswa</option>
                </select>

                <select name="status" class="filter-select" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="aktif"    {{ request('status') == 'aktif'    ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>

                <div class="search-pill">
                    <svg width="13" height="13" fill="none" viewBox="0 0 16 16" style="flex-shrink:0;">
                        <circle cx="6.5" cy="6.5" r="4.5" stroke="#b0a89e" stroke-width="1.4"/>
                        <path d="M10.5 10.5l3 3" stroke="#b0a89e" stroke-width="1.4" stroke-linecap="round"/>
                    </svg>
                    <input type="text" name="search" placeholder="Cari nama atau email..."
                           value="{{ request('search') }}">
                    <button type="submit" class="btn-cari">CARI</button>
                </div>
            </form>
        </div>

        {{-- ALERT --}}
        @if(session('success'))
        <div class="alert-success-custom mx-4 mt-3">
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" class="alert-close-btn">&times;</button>
        </div>
        @endif

        {{-- SHOW ENTRIES --}}
        <div class="show-row d-flex align-items-center gap-2">
            Tampilkan
            <select onchange="location.href='?per_page='+this.value+'&search={{ request('search') }}'">
                <option value="5"  {{ $users->perPage() == 5  ? 'selected' : '' }}>5</option>
                <option value="10" {{ $users->perPage() == 10 ? 'selected' : '' }}>10</option>
                <option value="20" {{ $users->perPage() == 20 ? 'selected' : '' }}>20</option>
                <option value="50" {{ $users->perPage() == 50 ? 'selected' : '' }}>50</option>
            </select>
            data per halaman
        </div>

        {{-- TABLE --}}
        <div class="table-responsive">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th class="tc" style="width:52px;">No</th>
                        <th >Nama</th>
                        <th >Email</th>
                        <th >Role</th>
                        <th >Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $avatarColors = [
                            ['bg'=>'#EBF3FA','color'=>'#0C447C'],
                            ['bg'=>'#FAEEDA','color'=>'#633806'],
                            ['bg'=>'#E1F5EE','color'=>'#085041'],
                            ['bg'=>'#FBEAF0','color'=>'#72243E'],
                            ['bg'=>'#EEEDFE','color'=>'#3C3489'],
                            ['bg'=>'#EAF3DE','color'=>'#27500A'],
                        ];
                    @endphp

                    @forelse($users as $index => $user)
                        @php
                            $initials = collect(explode(' ', $user->nama))
                                ->take(2)
                                ->map(fn($w) => strtoupper(substr($w, 0, 1)))
                                ->join('');
                            $av = $avatarColors[$index % count($avatarColors)];
                        @endphp
                        <tr>
                            <td class="tc no-cell">{{ $users->firstItem() + $index }}</td>
                            <td>
                                <div class="name-wrap">
                                    <div class="av" style="background:{{ $av['bg'] }};color:{{ $av['color'] }};">
                                        {{ $initials }}
                                    </div>
                                    <span class="name-text">{{ $user->nama }}</span>
                                </div>
                            </td>
                            <td class="email-cell">{{ $user->email }}</td>
                            <td>
                                @if($user->role == 'guru')
                                    <span class="badge-pill b-guru">Guru</span>
                                @else
                                    <span class="badge-pill b-siswa">Siswa</span>
                                @endif
                            </td>
                            <td>
                                @if($user->status_akun == 'aktif')
                                    <span class="badge-pill b-aktif"><span class="dot dot-a"></span>Aktif</span>
                                @elseif($user->status_akun == 'nonaktif')
                                    <span class="badge-pill b-nonaktif"><span class="dot dot-n"></span>Nonaktif</span>
                                @else
                                    <span class="badge-pill b-suspend"><span class="dot dot-s"></span>Suspend</span>
                                @endif
                            </td>
                            <td>
                                <div class="aksi-wrap">
                                    <a href="{{ route('guru.manajemen-user.show', $user->id) }}"
                                       class="btn-act view" title="Lihat">
                                        <svg fill="none" viewBox="0 0 16 16">
                                            <ellipse cx="8" cy="8" rx="6" ry="4" stroke="#185FA5" stroke-width="1.3"/>
                                            <circle cx="8" cy="8" r="1.5" fill="#185FA5"/>
                                        </svg>
                                    </a>
                                    <a href="{{ route('guru.manajemen-user.edit', $user->id) }}"
                                       class="btn-act edit" title="Edit">
                                        <svg fill="none" viewBox="0 0 16 16">
                                            <path d="M11 3l2 2-7 7H4v-2l7-7z" stroke="#854F0B" stroke-width="1.3" stroke-linejoin="round"/>
                                        </svg>
                                    </a>
                                    @if(auth()->id() !== $user->id)
                                    <form action="{{ route('guru.manajemen-user.destroy', $user->id) }}"
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-act del" title="Hapus">
                                            <svg fill="none" viewBox="0 0 16 16">
                                                <path d="M3 5h10M6 5V3h4v2M6 8v4M10 8v4"
                                                      stroke="#A32D2D" stroke-width="1.3" stroke-linecap="round"/>
                                            </svg>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <svg width="36" height="36" fill="none" viewBox="0 0 24 24">
                                        <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2M9 11a4 4 0 100-8 4 4 0 000 8zM23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75" stroke="#b0a89e" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <p>Tidak ada pengguna ditemukan</p>
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
                @if($users->count())
                    Menampilkan {{ $users->firstItem() }} &ndash; {{ $users->lastItem() }}
                    dari {{ $users->total() }} data
                @else
                    Tidak ada data
                @endif
            </div>
            <div>
                {{ $users->appends(request()->input())->links('vendor.pagination.simple-number') }}
            </div>
        </div>

    </div>
</div>
@endsection