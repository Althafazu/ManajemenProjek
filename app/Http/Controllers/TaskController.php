<?php

namespace App\Http\Controllers;

use App\Models\AktualPlan;
use App\Models\Fase;
use App\Models\Task;
use App\Models\MsAktualPlan;
use App\Models\MsFase;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\select;

class TaskController extends Controller
{
    public function index($ap_id)
    {
        $tasks = Task::with(['aktualPlan', 'fase'])
            ->where('ap_id', $ap_id)
            ->get();
        return response()->json($tasks);
    }

    public function create($ap_id)
    {
        $aktualPlan = AktualPlan::findOrFail($ap_id);
        $fases = Fase::all();
        $users = User::all();
        
        // Get existing phases for this AP to exclude them from selection
        $existingFases = Task::where('ap_id', $ap_id)
        ->pluck('apf_id')
        ->toArray();
        
        return view('aktual-plan.create', compact('aktualPlan', 'fases', 'users', 'existingFases'));
    }
    public function store(Request $request, $ap_id)
    {
        $request->validate([
            'apf_id' => [
                'required',
                'exists:msfase,apf_id',
                function ($attribute, $value, $fail) use ($ap_id) {
                    $exists = Task::where('ap_id', $ap_id)
                    ->where('apf_id', $value)
                    ->exists();
                    if ($exists) {
                        $fail('Fase ini sudah digunakan dalam AP.');
                    }
                },
            ],
            'pic' => 'required|exists:msuser,usr_id',
            'plan_start' => 'required|date|before_or_equal:plan_end',
            'plan_end' => 'required|date|after_or_equal:plan_start',
        ]);
        
        $task = Task::create([
            'ap_id' => $ap_id,
            'apf_id' => $request->apf_id,
            'pic' => $request->pic,
            'plan_start' => $request->plan_start,
            'plan_end' => $request->plan_end,
            'status' => 'Menunggu Dikerjakan',
            'progress' => 0
        ]);
        
        return redirect()
        ->route('tasks.index', $ap_id)
        ->with('success', 'Task berhasil dibuat');
    }
    
    public function edit($taskId) 
    {
        $task = Task::with(['aktualPlan', 'fase', 'picUser'])
        ->where('tsk_id', $taskId)
        ->firstOrFail();
        
        return view('aktual-plan.edit', compact('task'));
    }
    
    public function update(Request $request, $taskId)
    {
        $task = Task::findOrFail($taskId);
        
        $validated = $request->validate([
            'actual_start' => 'required|date|before_or_equal:actual_end',
            'actual_end' => 'required|date|after_or_equal:actual_start',
            'progress' => 'required|numeric|min:0|max:100',
        ]);
        
        $task->update($validated);
        
        return redirect()
        ->route('tasks.index', $task->ap_id)
        ->with('success', 'Task berhasil diperbarui');
    }

    public function getFases($ap_id)
    {
        $fases = Fase::whereNotIn('apf_id', function($query) use ($ap_id) {
            $query->select('apf_id')
                  ->from('tasks')
                  ->where('ap_id', $ap_id);
        })->get();
        
        return response()->json($fases);
    }

    public function getAll($ap_id)
    {
        $tasks = DB::select("
        SELECT 
            t.tsk_id,
            f.nama_fase,
            u.usr_name,
            t.plan_start,
            t.plan_end,
            t.actual_start,
            t.actual_end,
            t.progress,
            t.status
        FROM mstask t, msfase f, msuser u
        WHERE 
            f.apf_id = t.apf_id
            AND u.usr_id = t.pic
            AND t.ap_id = ?
        ORDER BY f.apf_id ASC
    ", [$ap_id]);

    return response()->json($tasks);
    }
}