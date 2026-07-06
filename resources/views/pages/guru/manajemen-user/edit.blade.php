@extends('layouts.guru')

@push('styles')
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/guru/manajemen-user/edit.css') }}">
@endpush

@section('content')
    <div class="container-fluid">

        {{-- PAGE HEADER --}}
        <div class="page-header d-flex justify-content-between align-items-center mb-4">
            <div>
                <h5 class="page-title">Edit Pengguna</h5>
                <p class="page-sub">Perbarui data akun <strong>{{ $user->nama }}</strong></p>
            </div>
            <a href="{{ route('guru.manajemen-user.index') }}" class="btn-back">
                <svg width="14" height="14" fill="none" viewBox="0 0 16 16">
                    <path d="M10 3L5 8l5 5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
                Kembali
            </a>
        </div>

        <form action="{{ route('guru.manajemen-user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-card">

                {{-- SECTION: Identitas --}}
                <div class="section-label">Identitas Pengguna</div>

                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="field-group">
                            <label class="field-label" for="nama">Nama Lengkap <span class="req">*</span></label>
                            <input type="text" id="nama" name="nama"
                                class="field-input @error('nama') is-error @enderror" value="{{ old('nama', $user->nama) }}"
                                placeholder="Masukkan nama lengkap" required>
                            @error('nama')
                                <span class="field-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="field-group">
                            <label class="field-label" for="email">Email <span class="req">*</span></label>
                            <input type="email" id="email" name="email"
                                class="field-input @error('email') is-error @enderror"
                                value="{{ old('email', $user->email) }}" placeholder="email@contoh.com" required>
                            @error('email')
                                <span class="field-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="field-group">
                            <label class="field-label" for="role">Role <span class="req">*</span></label>
                            <select id="role" name="role"
                                class="field-input field-select @error('role') is-error @enderror" required>
                                <option value="siswa" {{ old('role', $user->role) == 'siswa' ? 'selected' : '' }}>Siswa
                                </option>
                                <option value="guru" {{ old('role', $user->role) == 'guru' ? 'selected' : '' }}>Guru
                                </option>
                            </select>
                            @error('role')
                                <span class="field-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="section-divider"></div>

                {{-- SECTION: Keamanan --}}
                <div class="section-label">Keamanan Akun</div>

                <div class="info-note mb-4">
                    <svg width="13" height="13" fill="none" viewBox="0 0 16 16"
                        style="flex-shrink:0;margin-top:1px;">
                        <circle cx="8" cy="8" r="6.5" stroke="currentColor" stroke-width="1.3" />
                        <path d="M8 7v4M8 5.5v.5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" />
                    </svg>
                    Kosongkan kedua field password jika tidak ingin mengubah password.
                </div>

                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="field-group">
                            <label class="field-label" for="password">Password Baru</label>
                            <div class="input-eye-wrap">
                                <input type="password" id="password" name="password"
                                    class="field-input @error('password') is-error @enderror"
                                    placeholder="Kosongkan jika tidak ingin ganti">
                                <button type="button" class="eye-btn" onclick="togglePass('password', this)">
                                    <svg width="14" height="14" fill="none" viewBox="0 0 16 16"
                                        class="icon-eye">
                                        <ellipse cx="8" cy="8" rx="6" ry="4"
                                            stroke="currentColor" stroke-width="1.4" />
                                        <circle cx="8" cy="8" r="1.5" fill="currentColor" />
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                                <span class="field-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="field-group">
                            <label class="field-label" for="password_confirmation">Konfirmasi Password Baru</label>
                            <div class="input-eye-wrap">
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    class="field-input" placeholder="Ulangi password baru">
                                <button type="button" class="eye-btn"
                                    onclick="togglePass('password_confirmation', this)">
                                    <svg width="14" height="14" fill="none" viewBox="0 0 16 16"
                                        class="icon-eye">
                                        <ellipse cx="8" cy="8" rx="6" ry="4"
                                            stroke="currentColor" stroke-width="1.4" />
                                        <circle cx="8" cy="8" r="1.5" fill="currentColor" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="section-divider"></div>

                {{-- SECTION: Pengaturan --}}
                <div class="section-label">Pengaturan Akun</div>

                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="field-group">
                            <label class="field-label" for="status_akun">Status Akun <span
                                    class="req">*</span></label>
                            <select id="status_akun" name="status_akun"
                                class="field-input field-select @error('status_akun') is-error @enderror" required>
                                <option value="aktif"
                                    {{ old('status_akun', $user->status_akun) == 'aktif' ? 'selected' : '' }}>Aktif
                                </option>
                                <option value="nonaktif"
                                    {{ old('status_akun', $user->status_akun) == 'nonaktif' ? 'selected' : '' }}>Nonaktif
                                </option>
                                <option value="suspend"
                                    {{ old('status_akun', $user->status_akun) == 'suspend' ? 'selected' : '' }}>Suspend
                                </option>
                            </select>
                            @error('status_akun')
                                <span class="field-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="field-group">
                            <label class="field-label" for="foto_profile">
                                Ganti Foto Profil <span class="field-hint">(opsional)</span>
                            </label>

                            {{-- Preview foto existing --}}
                            @if ($user->foto_profile)
                                <div class="current-photo">
                                    <div class="current-photo-thumb">
                                        <img src="{{ asset('storage/' . $user->foto_profile) }}"
                                            alt="Foto {{ $user->nama }}" id="photo-preview">
                                    </div>
                                    <span class="current-photo-label">Foto saat ini</span>
                                </div>
                            @endif

                            <label class="upload-area" id="upload-label" for="foto_profile">
                                <svg width="20" height="20" fill="none" viewBox="0 0 24 24">
                                    <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M17 8l-5-5-5 5M12 3v12"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                                <span class="upload-text" id="upload-text">Klik untuk ganti foto</span>
                                <span class="upload-hint">JPG, PNG, max 2MB</span>
                            </label>
                            <input type="file" id="foto_profile" name="foto_profile" accept="image/*"
                                class="upload-input" onchange="previewFile(this)">
                            @error('foto_profile')
                                <span class="field-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

            </div>

            {{-- ACTION BUTTONS --}}
            <div class="form-actions d-flex justify-content-end gap-2 mt-3">
                <a href="{{ route('guru.manajemen-user.index') }}" class="btn-reset">Batal</a>
                <button type="submit" class="btn-submit">
                    <svg width="13" height="13" fill="none" viewBox="0 0 16 16">
                        <path d="M3 8l4 4 6-7" stroke="#fff" stroke-width="1.8" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                    Perbarui
                </button>
            </div>

        </form>
    </div>
@endsection

@push('scripts')
    <script>
        function togglePass(id, btn) {
            const input = document.getElementById(id);
            const isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';
            btn.style.opacity = isHidden ? '1' : '0.4';
        }

        function previewFile(input) {
            const text = document.getElementById('upload-text');
            const label = document.getElementById('upload-label');
            const preview = document.getElementById('photo-preview');
            if (input.files && input.files[0]) {
                text.textContent = input.files[0].name;
                label.classList.add('has-file');
                if (preview) {
                    const reader = new FileReader();
                    reader.onload = e => preview.src = e.target.result;
                    reader.readAsDataURL(input.files[0]);
                }
            }
        }
    </script>
@endpush
