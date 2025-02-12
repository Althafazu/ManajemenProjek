@extends('layouts.main')

@section('title', 'Gambar Teknik')

@section('content')
<div class="container mt-5">
    <h3 class="text-center mb-4">Unggah Dokumen Gamtek</h3>
    <div class="card border-0 shadow-sm rounded">
        <div class="card-body">
            <form id="uploadForm" action="{{ route('gamteks.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="file" class="form-label">Pilih File (PDF, Max 10MB)</label>
                    <input 
                        type="file" 
                        name="file" 
                        id="file" 
                        class="form-control" 
                        accept=".pdf"
                        required 
                        oninvalid="this.setCustomValidity('Silakan pilih file yang akan diunggah.')"
                        oninput="this.setCustomValidity('')">
                </div>
                <button type="submit" class="btn btn-primary">Unggah</button>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('uploadForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Mencegah form langsung submit
        
        // Menampilkan SweetAlert2 konfirmasi
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Setelah diunggah, file tidak bisa diubah atau dihapus.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, unggah!',
            cancelButtonText: 'Tidak, batalkan'
        }).then((result) => {
            if (result.isConfirmed) {
                // Jika user memilih 'Ya', submit form
                this.submit();
            }
        });
    });
</script>

@endsection