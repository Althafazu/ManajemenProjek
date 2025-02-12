<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Response;
use App\Models\QC;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class QCController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->get('sort', 'created_at'); // Default sort by created_at
        $order = $request->get('order', 'asc'); // Default order is descending
        $search = $request->get('search', ''); // Search query

        $qcs = QC::when($search, function ($query, $search) {
            return $query->where('file', 'like', '%' . $search . '%'); // Pencarian berdasarkan file
        })
        ->orderBy($sort, $order) // Urutkan berdasarkan created_at secara default
        ->paginate(10); // Menampilkan data dengan pagination

        return view('qcs.index', compact('qcs', 'sort', 'order', 'search'));
    }

    
    public function create()
    {
        return view('qcs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:pdf|max:10240', // Maksimal 10 MB, hanya PDF yang diizinkan
            'keterangan' => 'nullable|string|max:255', // Validasi kolom keterangan
        ]);
    
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            
            // Mengambil tanggal sekarang dalam format TahunBulanHari
            $date = now()->format('Ymd');  // Format: 20250211
            
            // Generate random file name dengan prefix 'QC_' dan tanggal di belakangnya
            $randomFileName = 'QC_' . Str::random(20) . '_' . $date . '.' . $file->getClientOriginalExtension(); // Format: QC_(random)_20250211.pdf
            
            // Simpan file dengan nama acak
            $path = $file->storeAs('uploads', $randomFileName, 'public');
    
            // Simpan path file dan keterangan (jika ada)
            QC::create([
                'file' => $path, // Menyimpan path file
                'keterangan' => $request->input('keterangan'), // Simpan keterangan
            ]);
        }
    
        return redirect()->route('qcs.index')->with('success', 'File berhasil diunggah!');
    }
    

    public function download($id)
    {
        $QC = QC::findOrFail($id);

        $filePath = storage_path('app/public/' . $QC->file);

        if (file_exists($filePath)) {
            return Response::download($filePath); // Menyediakan file untuk diunduh
        } else {
            return redirect()->route('qcs.index')->with('error', 'File tidak ditemukan!');
        }
    }

    public function show($id)
    {
        $QC = QC::findOrFail($id); // Ambil data berdasarkan ID
        return view('qcs.show', compact('QC')); // Tampilkan halaman show dengan data QC
    }
}
