@extends('layouts.main')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-lg-center">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <h4 class="card-title mb-4">Ubah Aktual Pengerjaan Task</h4>

                        {{-- Informasi Plan --}}
                        <div class="mb-4">
                            <h5 class="border-bottom pb-2">Informasi Perencanaan</h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Fase</label>
                                    <input type="text" class="form-control" value="{{ $task->fase->nama_fase }}" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">PIC</label>
                                    <input type="text" class="form-control" value="{{ $task->picUser->usr_name }}" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Rencana Mulai</label>
                                    <input type="text" class="form-control" value="{{ date('d/m/Y', strtotime($task->plan_start)) }}" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Rencana Selesai</label>
                                    <input type="text" class="form-control" value="{{ date('d/m/Y', strtotime($task->plan_end)) }}" readonly>
                                </div>
                            </div>
                        </div>

                        <form action="{{ route('tasks.update', $task->tsk_id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <h5 class="border-bottom pb-2">Informasi Aktual</h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="actual_start" class="form-label">Tanggal Mulai Aktual</label>
                                    <input type="date" 
                                        class="form-control @error('actual_start') is-invalid @enderror" 
                                        id="actual_start" 
                                        name="actual_start" 
                                        value="{{ old('actual_start', $task->actual_start ? date('Y-m-d', strtotime($task->actual_start)) : '') }}">
                                    @error('actual_start')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="actual_end" class="form-label">Tanggal Selesai Aktual</label>
                                    <input type="date" 
                                        class="form-control @error('actual_end') is-invalid @enderror" 
                                        id="actual_end" 
                                        name="actual_end" 
                                        value="{{ old('actual_end', $task->actual_end ? date('Y-m-d', strtotime($task->actual_end)) : '') }}">
                                    @error('actual_end')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label for="progress" class="form-label">Progress (%)</label>
                                    <input type="number" 
                                        class="form-control @error('progress') is-invalid @enderror" 
                                        id="progress" 
                                        name="progress" 
                                        min="0" 
                                        max="100" 
                                        value="{{ old('progress', $task->progress) }}">
                                    @error('progress')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('tasks.index', $task->ap_id) }}" class="btn btn-secondary">Kembali</a>
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection