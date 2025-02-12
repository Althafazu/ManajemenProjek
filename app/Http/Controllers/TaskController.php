<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with(['aktualPlan', 'fase'])->get();
        return response()->json($tasks);
    }

    public function store(Request $request)
    {
        $request->validate([
            'ap_id' => 'required|exists:msaktualplan,ap_id',
            'apf_id' => 'required|exists:msfase,apf_id',
            'pic' => 'required|exists:users,id',
            'plan_start' => 'required|date|before_or_equal:plan_end',
            'plan_end' => 'required|date|after_or_equal:plan_start',
            'keterangan' => 'nullable|string|max:200'
        ]);

        // Check for existing task in the same phase
        $exists = Task::where('ap_id', $request->ap_id)
            ->where('apf_id', $request->apf_id)
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Task sudah ada untuk fase ini'
            ], 422);
        }

        $task = Task::create([
            'ap_id' => $request->ap_id,
            'apf_id' => $request->apf_id,
            'pic' => $request->pic,
            'plan_start' => $request->plan_start,
            'plan_end' => $request->plan_end,
            'keterangan' => $request->keterangan,
            'status' => 'Menunggu Dikerjakan',
            'progress' => 0
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Task berhasil dibuat',
            'task' => $task
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'actualStartDate' => 'nullable|date|before_or_equal:actualEndDate',
            'actualEndDate' => 'nullable|date|after_or_equal:actualStartDate',
            'progress' => 'required|integer|min:0|max:100',
            'status' => 'required|in:Menunggu Dikerjakan,Sedang Dikerjakan,Selesai'
        ]);
        
        $task = Task::findOrFail($id);
        
        $task->update([
            'actual_start' => $request->actualStartDate,
            'actual_end' => $request->actualEndDate,
            'progress' => $request->progress,
            'status' => $request->status
        ]);
        
        return response()->json([
            'success' => true,
            'task' => $task
        ]);
    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();
        return response()->json(null, 204);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Menunggu Dikerjakan,Sedang Dikerjakan,Selesai',
            'actual_start' => 'required_if:status,Sedang Dikerjakan|date',
            'actual_end' => 'required_if:status,Selesai|date'
        ]);

        $task = Task::findOrFail($id);
        $task->update($request->all());
        return response()->json($task);
    }
}