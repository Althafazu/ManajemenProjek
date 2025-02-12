@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')
    <h1>Selamat Datang di Dashboard</h1>
    <p>Ini adalah halaman dashboard.</p>
    <p> "<a href='/logout'>log out</a>"</p>

{{-- <ul>

    @if (Auth::user()->role == 'ROL23')
    <li>mahasiswa</li>
    @endif
    @if (Auth::user()->role == 'ROL25')
    <li>dosen</li>
    @endif
</ul> --}}

        
@endsection
