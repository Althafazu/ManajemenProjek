@extends('layouts.main')

@section('title', 'Quality Chesksheet')

@section('content')

<div class="container mt-5">
    <h3 class="text-center mb-4">Data Dokumen Data Trial</h3>
    <div class="card border-0 shadow-sm rounded">
        <div class="card-body">
            <!-- Search Form -->
            <form action="{{ route('datatrials.index') }}" method="GET" class="mb-3">
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
                            <a class="dropdown-item" href="{{ route('datatrials.index', ['sort' => 'created_at', 'order' => 'asc', 'search' => request('search')]) }}">
                                Urutkan dari Lama ke Baru
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('datatrials.index', ['sort' => 'created_at', 'order' => 'desc', 'search' => request('search')]) }}">
                                Urutkan dari Baru ke Lama
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- End Filter and Sort -->

            <a href="{{ route('datatrials.create') }}" class="btn btn-success mb-3">Upload Data Trial</a>
            <table class="table table-bordered">
                <thead class="bg-dark text-white text-center">
                    <tr>
                        <th>
                            <a href="{{ route('datatrials.index', ['sort' => 'id', 'order' => request('order') === 'asc' ? 'desc' : 'asc', 'search' => request('search')]) }}" class="text-black">
                                No
                            </a>
                        </th>
                        <th>
                            <a href="{{ route('datatrials.index', ['sort' => 'file', 'order' => request('order') === 'asc' ? 'desc' : 'asc', 'search' => request('search')]) }}" class="text-black">
                                File
                            </a>
                        </th>
                        <th>
                            <a href="{{ route('datatrials.index', ['sort' => 'created_at', 'order' => request('order') === 'asc' ? 'desc' : 'asc', 'search' => request('search')]) }}" class="text-black">
                                Waktu Unggah
                            </a>
                        </th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($datatrials as $QC)
                        <tr>
                            <td class="text-center">{{ $loop->iteration + ($datatrials->currentPage() - 1) * $datatrials->perPage() }}</td>
                            <td class="text-center">{{ basename($QC->file) }}</td>
                            <td class="text-center">{{ $QC->created_at->format('d F Y H:i:s') }}</td>
                            <td class="text-center">
                                <a href="{{ route('datatrials.show', $QC->id) }}" class="btn btn-primary btn-sm">Lihat</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">
                                <div class="alert alert-danger">
                                    Data Trial belum tersedia.
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination dengan nomor halaman yang berlanjut -->
            <div class="d-flex justify-content-center">
                {{ $datatrials->appends(['sort' => request('sort'), 'order' => request('order'), 'search' => request('search')])->links('pagination::bootstrap-4') }}
            </div>

        </div>
    </div>
</div>

@endsection
