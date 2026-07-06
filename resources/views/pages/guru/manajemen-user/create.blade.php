@extends('layouts.guru')

@push('styles')
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/guru/manajemen-user/create.css') }}">
@endpush

@section('content')
<div class="container-fluid ">

    {{-- PAGE HEADER --}}
    <div class="page-header d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="page-title">Tambah Pengguna</h5>
            <p class="page-sub">Buat akun baru untuk guru atau siswa</p>
        </div>
        <a href="{{ route('guru.manajemen-user.index') }}" class="btn-back">
            <svg width="14" height="14" fill="none" viewBox="0 0 16 16">
                <path d="M10 3L5 8l5 5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Kembali
        </a>
    </div>

    <form action="{{ route('guru.manajemen-user.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-card">

            {{-- SECTION: Identitas --}}
            <div class="section-label">Identitas Pengguna</div>

            <div class="row g-4">
                <div class="col-md-6">
                    <div class="field-group">
                        <label class="field-label" for="nama">Nama Lengkap <span class="req">*</span></label>
                        <input type="text"
                               id="nama" name="nama"
                               class="field-input @error('nama') is-error @enderror"
                               value="{{ old('nama') }}"
                               placeholder="Masukkan nama lengkap"
                               required>
                        @error('nama')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="field-group">
                        <label class="field-label" for="email">Email <span class="req">*</span></label>
                        <input type="email"
                               id="email" name="email"
                               class="field-input @error('email') is-error @enderror"
                               value="{{ old('email') }}"
                               placeholder="email@contoh.com"
                               required>
                        @error('email')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="field-group">
                        <label class="field-label" for="role">Role <span class="req">*</span></label>
                        <select id="role" name="role"
                                class="field-input field-select @error('role') is-error @enderror"
                                required>
                            <option value="" disabled selected>— Pilih Role —</option>
                            <option value="siswa" {{ old('role') == 'siswa' ? 'selected' : '' }}>Siswa</option>
                            <option value="guru"  {{ old('role') == 'guru'  ? 'selected' : '' }}>Guru</option>
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

            <div class="row g-4">
                <div class="col-md-6">
                    <div class="field-group">
                        <label class="field-label" for="password">Password <span class="req">*</span></label>
                        <div class="input-eye-wrap">
                            <input type="password"
                                   id="password" name="password"
                                   class="field-input @error('password') is-error @enderror"
                                   placeholder="Minimal 8 karakter"
                                   required>
                            <button type="button" class="eye-btn" onclick="togglePass('password', this)">
                                <svg width="14" height="14" fill="none" viewBox="0 0 16 16" class="icon-eye">
                                    <ellipse cx="8" cy="8" rx="6" ry="4" stroke="currentColor" stroke-width="1.4"/>
                                    <circle cx="8" cy="8" r="1.5" fill="currentColor"/>
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
                        <label class="field-label" for="password_confirmation">Konfirmasi Password <span class="req">*</span></label>
                        <div class="input-eye-wrap">
                            <input type="password"
                                   id="password_confirmation" name="password_confirmation"
                                   class="field-input"
                                   placeholder="Ulangi password"
                                   required>
                            <button type="button" class="eye-btn" onclick="togglePass('password_confirmation', this)">
                                <svg width="14" height="14" fill="none" viewBox="0 0 16 16" class="icon-eye">
                                    <ellipse cx="8" cy="8" rx="6" ry="4" stroke="currentColor" stroke-width="1.4"/>
                                    <circle cx="8" cy="8" r="1.5" fill="currentColor"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="section-divider"></div>

            {{-- SECTION: Lainnya --}}
            <div class="section-label">Pengaturan Akun</div>

            <div class="row g-4">
                <div class="col-md-6">
                    <div class="field-group">
                        <label class="field-label" for="status_akun">Status Akun <span class="req">*</span></label>
                        <select id="status_akun" name="status_akun"
                                class="field-input field-select @error('status_akun') is-error @enderror"
                                required>
                            <option value="aktif"    {{ old('status_akun', 'aktif') == 'aktif'    ? 'selected' : '' }}>Aktif</option>
                            <option value="nonaktif" {{ old('status_akun') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                            <option value="suspend"  {{ old('status_akun') == 'suspend'  ? 'selected' : '' }}>Suspend</option>
                        </select>
                        @error('status_akun')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="field-group">
                        <label class="field-label" for="foto_profile">Foto Profil <span class="field-hint">(opsional)</span></label>
                        <label class="upload-area" id="upload-label" for="foto_profile">
                            <svg width="20" height="20" fill="none" viewBox="0 0 24 24">
                                <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M17 8l-5-5-5 5M12 3v12"
                                      stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span class="upload-text" id="upload-text">Klik untuk upload foto</span>
                            <span class="upload-hint">JPG, PNG, max 2MB</span>
                        </label>
                        <input type="file" id="foto_profile" name="foto_profile"
                               accept="image/*" class="upload-input"
                               onchange="previewFile(this)">
                        @error('foto_profile')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

        </div>

        {{-- ACTION BUTTONS --}}
        <div class="form-actions d-flex justify-content-end gap-2 mt-3">
            <button type="reset" class="btn-reset" onclick="resetUpload()">Reset</button>
            <button type="submit" class="btn-submit">
                <svg width="13" height="13" fill="none" viewBox="0 0 16 16">
                    <path d="M3 8l4 4 6-7" stroke="#fff" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Simpan 
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
        if (input.files && input.files[0]) {
            text.textContent = input.files[0].name;
            document.getElementById('upload-label').classList.add('has-file');
        }
    }

    function resetUpload() {
        const text = document.getElementById('upload-text');
        text.textContent = 'Klik untuk upload foto';
        document.getElementById('upload-label').classList.remove('has-file');
    }
</script>
@endpush