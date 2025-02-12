<?php

namespace App\Http\Controllers;

use App\Models\Fase;
use Illuminate\Http\Request;

class FaseController extends Controller
{
    public function index()
    {
        $fases = Fase::with('tasks')->get();
        return response()->json($fases);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_fase' => 'required|string|max:100'
        ]);

        $fase = Fase::create($request->all());
        return response()->json($fase, 201);
    }

    public function show($id)
    {
        $fase = Fase::with(['tasks' => function($query) {
            $query->orderBy('plan_start', 'asc');
        }])->findOrFail($id);
        
        return response()->json($fase);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_fase' => 'required|string|max:100'
        ]);

        $fase = Fase::findOrFail($id);
        $fase->update($request->all());
        return response()->json($fase);
    }

    public function destroy($id)
    {
        $fase = Fase::findOrFail($id);
        $fase->delete();
        return response()->json(null, 204);
    }
}
