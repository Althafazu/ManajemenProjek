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
            'plan_start' => 'required|date',
            'plan_end' => 'required|date|after_or_equal:plan_start',
            'keterangan' => 'nullable|string|max:200'
        ]);

        $exists = Task::where('ap_id', $request->ap_id)
            ->where('apf_id', $request->apf_id)
            ->exists();

        if ($exists) {
            return response()->json([
                'message' => 'Task already exists for this phase in the actual plan'
            ], 422);
        }

        $task = Task::create($request->all());
        return response()->json($task, 201);
    }

    public function show($id)
    {
        $task = Task::with(['aktualPlan', 'fase'])->findOrFail($id);
        return response()->json($task);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'pic' => 'exists:users,id',
            'plan_start' => 'date',
            'plan_end' => 'date|after_or_equal:plan_start',
            'actual_start' => 'nullable|date',
            'actual_end' => 'nullable|date|after_or_equal:actual_start',
            'keterangan' => 'nullable|string|max:200',
            'status' => 'in:Menunggu Dikerjakan,Sedang Dikerjakan,Selesai'
        ]);

        $task = Task::findOrFail($id);
        $task->update($request->all());
        return response()->json($task);
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