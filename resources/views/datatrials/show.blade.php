@extends('layouts.main')

@section('title', 'Quality Chesksheet')

@section('content')

<div class="container mt-5">
    <h3 class="text-center mb-4">Detail Dokumen Quality Check</h3>
    <div class="card border-0 shadow-sm rounded">
        <div class="card-body">
            <!-- Menampilkan Keterangan -->
            <div class="mb-3">
                <h5>Keterangan:</h5>
                <p>{{ $DataTrial->keterangan ?? 'Tidak ada keterangan' }}</p> <!-- Menampilkan keterangan jika ada, jika kosong tampilkan 'Tidak ada keterangan' -->
            </div>

            <!-- Menampilkan File PDF langsung di halaman -->
            <div class="mb-3">
                <h5>File PDF:</h5>
                <!-- Menggunakan <embed> untuk menampilkan PDF langsung -->
                <embed src="{{ asset('/storage/' . $DataTrial->file) }}" type="application/pdf" width="100%" height="600px">
            </div>

            <!-- Tombol Kembali ke Daftar -->
            <div class="mt-3">
                <a href="{{ route('datatrials.index') }}" class="btn btn-secondary">Kembali ke Daftar</a>
            </div>
        </div>
    </div>
</div>

@endsection