@extends('layouts.main')

@section('title', 'Gambar Teknik')

@section('content')
<div class="container mt-5">
    <h3 class="text-center mb-4">Data Dokumen Gamtek</h3>
    <div class="card border-0 shadow-sm rounded">
        <div class="card-body">
            <!-- Search Form -->
            <form action="{{ route('gamteks.index') }}" method="GET" class="mb-3">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari dokumen..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary">Cari</button>
                </div>
            </form>
            <!-- End Search Form -->

            <!-- Filter and Sort -->
            <div class="d-flex justify-content-between mb-3">
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        Urut Berdasarkan
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <li>
                            <a class="dropdown-item" href="{{ route('gamteks.index', ['sort' => 'created_at', 'order' => 'asc', 'search' => request('search')]) }}">
                                Urutkan dari Lama ke Baru
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('gamteks.index', ['sort' => 'created_at', 'order' => 'desc', 'search' => request('search')]) }}">
                                Urutkan dari Baru ke Lama
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- End Filter and Sort -->

            <a href="{{ route('gamteks.create') }}" class="btn btn-success mb-3">Unggah Gamtek</a>
            <table class="table table-bordered">
                <thead class="bg-dark text-white text-center">
                    <tr>
                        <th>
                            <a href="{{ route('gamteks.index', ['sort' => 'id', 'order' => request('order') === 'asc' ? 'desc' : 'asc', 'search' => request('search')]) }}" class="text-black">
                                No
                            </a>
                        </th>
                        <th>
                            <a href="{{ route('gamteks.index', ['sort' => 'file', 'order' => request('order') === 'asc' ? 'desc' : 'asc', 'search' => request('search')]) }}" class="text-black">
                                File
                            </a>
                        </th>
                        <th>
                            <a href="{{ route('gamteks.index', ['sort' => 'created_at', 'order' => request('order') === 'asc' ? 'desc' : 'asc', 'search' => request('search')]) }}" class="text-black">
                                Waktu Unggah
                            </a>
                        </th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($gamteks as $gamtek)
                        <tr>
                            <td class="text-center">{{ $loop->iteration + ($gamteks->currentPage() - 1) * $gamteks->perPage() }}</td> <!-- Menampilkan nomor halaman yang berlanjut -->
                            <td class="text-center">{{ basename($gamtek->file) }}</td> <!-- Menampilkan nama file -->
                            <td class="text-center">{{ $gamtek->created_at->format('d F Y H:i:s') }}</td> <!-- Menampilkan waktu unggah -->
                            <td class="text-center">
                                <!-- Ganti Teks dengan Ikon -->
                                <a href="{{ asset('/storage/app/' . $gamtek->file) }}" target="_blank" class="btn btn-primary btn-sm">
                                    <i class="fas fa-eye"></i> <!-- Ikon mata untuk melihat -->
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">
                                <div class="alert alert-danger">
                                    Data Gamtek tidak ditemukan.
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination dengan nomor halaman yang berlanjut -->
            <div class="d-flex justify-content-center">
                {{ $gamteks->appends(['sort' => request('sort'), 'order' => request('order'), 'search' => request('search')])->links('pagination::bootstrap-4') }}
            </div>

        </div>
    </div>
</div>

@endsection
