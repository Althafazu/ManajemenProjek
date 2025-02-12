@extends('layouts.main')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <h4 class="card-title mb-4">Membuat Task Baru</h4>
                    
                    <form action="{{ route('tasks.store', $aktualPlan->ap_id) }}" method="POST">
                        @csrf
                        
                        <div class="row g-3">
                            {{-- Fase Selection --}}
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select name="apf_id" id="apf_id" class="form-select @error('apf_id') is-invalid @enderror" required>
                                        <option value="">Pilih Fase</option>
                                        @foreach($fases as $fase)
                                            @if(!in_array($fase->apf_id, $existingFases))
                                                <option value="{{ $fase->apf_id }}" {{ old('apf_id') == $fase->apf_id ? 'selected' : '' }}>
                                                    {{ $fase->nama_fase }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <label for="apf_id">Fase</label>
                                    @error('apf_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- PIC Selection --}}
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select name="pic" id="pic" class="form-select @error('pic') is-invalid @enderror" required>
                                        <option value="">Pilih PIC</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->usr_id }}" {{ old('pic') == $user->usr_id ? 'selected' : '' }}>
                                                {{ $user->usr_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="pic">Person In Charge</label>
                                    @error('pic')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Plan Start Date --}}
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="date" 
                                           class="form-control @error('plan_start') is-invalid @enderror" 
                                           id="plan_start" 
                                           name="plan_start" 
                                           value="{{ old('plan_start') }}"
                                           required>
                                    <label for="plan_start">Planning Tanggal Mulai</label>
                                    @error('plan_start')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Plan End Date --}}
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="date" 
                                           class="form-control @error('plan_end') is-invalid @enderror" 
                                           id="plan_end" 
                                           name="plan_end" 
                                           value="{{ old('plan_end') }}"
                                           required>
                                    <label for="plan_end">Planning Tanggal Selesai</label>
                                    @error('plan_end')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Keterangan --}}
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control @error('keterangan') is-invalid @enderror" 
                                              id="keterangan" 
                                              name="keterangan" 
                                              style="height: 100px">{{ old('keterangan') }}</textarea>
                                    <label for="keterangan">Keterangan</label>
                                    @error('keterangan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Form Actions --}}
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('tasks.index', $aktualPlan->ap_id) }}" 
                               class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Buat Task</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection