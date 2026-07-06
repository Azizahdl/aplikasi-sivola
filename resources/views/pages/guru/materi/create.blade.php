@extends('layouts.guru')

@push('styles')
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/guru/materi/create.css') }}">
@endpush

@section('content')
<div class="create-page">
    <div class="create-card">

        {{-- HEADER --}}
        <div class="create-card-header">
            <div class="header-title">
                <h4>Tambah Materi Bacaan</h4>
                <small>Isi form di bawah untuk menambahkan materi baru</small>
            </div>
            <a href="{{ route('guru.materi.index') }}" class="btn-back">
                <svg width="13" height="13" fill="none" viewBox="0 0 16 16">
                    <path d="M10 3L5 8l5 5" stroke="currentColor" stroke-width="1.6"
                        stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Kembali
            </a>
        </div>

        {{-- FORM --}}
        <form action="{{ route('guru.materi.store') }}" method="POST">
            @csrf

            <div class="create-card-body">

                {{-- Teks Bacaan --}}
                <div class="form-group-custom">
                    <label class="form-label-custom" for="teks_bacaan">
                        Teks Bacaan <span class="req">*</span>
                        <small>Teks yang akan diucapkan siswa</small>
                    </label>
                    <textarea
                        id="teks_bacaan"
                        name="teks_bacaan"
                        class="textarea-custom @error('teks_bacaan') is-invalid @enderror"
                        rows="5"
                        placeholder="Masukkan teks bacaan yang akan dilatih siswa..."
                        required>{{ old('teks_bacaan') }}</textarea>
                    @error('teks_bacaan')
                        <div class="error-msg">
                            <svg width="11" height="11" fill="none" viewBox="0 0 16 16">
                                <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-width="1.4"/>
                                <path d="M8 5v4M8 11v.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            </svg>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <hr class="form-divider">

                <div class="row g-3">

                    {{-- Tipe Materi (Dropdown) --}}
                    <div class="col-md-6">
                        <div class="form-group-custom mb-0">
                            <label class="form-label-custom" for="kategori">
                                Tipe Materi <span class="req">*</span>
                            </label>
                            <div class="select-wrap">
                                <select
                                    id="kategori"
                                    name="kategori"
                                    class="select-custom @error('kategori') is-invalid @enderror"
                                    required>
                                    <option value="" disabled {{ old('kategori') ? '' : 'selected' }}>
                                        Pilih tipe materi...
                                    </option>
                                    <option value="abjad"      {{ old('kategori') == 'abjad'      ? 'selected' : '' }}>Abjad</option>
                                    <option value="suku_kata"  {{ old('kategori') == 'suku_kata'  ? 'selected' : '' }}>Suku Kata</option>
                                    <option value="kata_dasar" {{ old('kategori') == 'kata_dasar' ? 'selected' : '' }}>Kata Dasar</option>
                                </select>
                            </div>
                            @error('kategori')
                                <div class="error-msg">
                                    <svg width="11" height="11" fill="none" viewBox="0 0 16 16">
                                        <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-width="1.4"/>
                                        <path d="M8 5v4M8 11v.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    {{-- Threshold --}}
                    {{-- <div class="col-md-6">
                        <div class="form-group-custom mb-0">
                            <label class="form-label-custom" for="threshold">
                                Threshold <span class="req">*</span>
                                <small>0.0 – 1.0</small>
                            </label>
                            <input
                                type="number"
                                id="threshold"
                                name="threshold"
                                class="input-custom @error('threshold') is-invalid @enderror"
                                value="{{ old('threshold', '0.85') }}"
                                step="0.01"
                                min="0"
                                max="1"
                                placeholder="Contoh: 0.85"
                                required>
                            <div class="threshold-hint">
                                <svg width="12" height="12" fill="none" viewBox="0 0 16 16">
                                    <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-width="1.4"/>
                                    <path d="M8 5v4M8 11v.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                </svg>
                                Nilai minimum kemiripan suara agar dinyatakan benar
                            </div>
                            @error('threshold')
                                <div class="error-msg">
                                    <svg width="11" height="11" fill="none" viewBox="0 0 16 16">
                                        <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-width="1.4"/>
                                        <path d="M8 5v4M8 11v.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div> --}}

                </div>

            </div>

            {{-- FOOTER --}}
            <div class="create-card-footer">
                <a href="{{ route('guru.materi.index') }}" class="btn-cancel">Batal</a>
                <button type="submit" class="btn-save">
                    <svg width="14" height="14" fill="none" viewBox="0 0 16 16">
                        <path d="M2 8.5L6 12.5L14 4" stroke="#fff" stroke-width="1.8"
                            stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Simpan Materi
                </button>
            </div>

        </form>

    </div>
</div>
@endsection