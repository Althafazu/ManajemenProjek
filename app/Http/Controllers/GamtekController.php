<?php

namespace App\Http\Controllers;

use App\Models\Gamtek;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;  // Import Str untuk menghasilkan string acak

class GamtekController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->get('sort', 'id'); // Default sort by 'id'
        $order = $request->get('order', 'asc'); // Default order is ascending
        $search = $request->get('search', ''); // Search query

        $gamteks = Gamtek::when($search, function ($query, $search) {
            return $query->where('file', 'like', '%' . $search . '%'); // Menggunakan 'file' untuk pencarian
        })
        ->orderBy($sort, $order)
        ->paginate(10); // Menampilkan data dengan pagination

        return view('gamteks.index', compact('gamteks', 'sort', 'order', 'search'));
    }


    public function create()
    {
        return view('gamteks.create'); // Menampilkan halaman form upload file
    }

    public function store(Request $request)
    {
        // Validasi file hanya bisa PDF dan maksimal 10MB
        $request->validate([
            'file' => 'required|mimes:pdf|max:10240', // Maksimal 10 MB, hanya PDF yang diizinkan
        ]);
    
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            
            // Mengambil tanggal sekarang dalam format TahunBulanHari
            $date = now()->format('Ymd');  // Format: 20250211
            
            // Generate random file name dengan prefix 'gmt_' dan tanggal di belakangnya
            $randomFileName = 'GMT_' . Str::random(20) . '_' . $date . '.' . $file->getClientOriginalExtension(); // Format: gmt_(random)_20250211.pdf
    
            // Simpan file dengan nama acak
            $path = $file->storeAs('uploads', $randomFileName, 'public');
    
            // Simpan hanya path file (tanpa 'original_name')
            Gamtek::create([
                'file' => $path, // hanya menyimpan path file
            ]);
        }
    
        return redirect()->route('gamteks.index')->with('success', 'File berhasil diunggah!'); // Mengarahkan ke halaman index setelah file berhasil diupload
    }
    

    public function download($id)
    {
        // Ambil data gamtek berdasarkan ID
        $gamtek = Gamtek::findOrFail($id);

        // Mendapatkan path file
        $filePath = storage_path('app/public/' . $gamtek->file);

        // Cek jika file ada, jika ada maka bisa didownload
        if (file_exists($filePath)) {
            return Response::download($filePath); // Mendownload file
        } else {
            return redirect()->route('gamteks.index')->with('error', 'File tidak ditemukan!'); // Jika file tidak ditemukan, tampilkan pesan error
        }
    }
}
