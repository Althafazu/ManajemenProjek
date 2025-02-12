<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\AktualPlan;
use Illuminate\Http\Request;

class GanttController extends Controller
{
    public function index($apId)
    {
        $aktualPlan = AktualPlan::with(['tasks' => function($query) {
            $query->orderBy('apf_id', 'asc');
        }])->findOrFail($apId);
        
        return view('aktual-plan.index', compact('aktualPlan'));
    }

    public function getGanttData($apId)
    {
        $aktualPlan = AktualPlan::with(['tasks' => function($query) {
            $query->orderBy('apf_id', 'asc');
        }])->findOrFail($apId);

        $ganttData = $aktualPlan->tasks->map(function ($task) {
            // Plan bar
            $planData = [
                'id' => $task->tsk_id . '-plan',
                'name' => '📅 Task ' . $task->apf_id . ' (Plan)',
                'start' => $task->plan_start,
                'end' => $task->plan_end,
                'progress' => 0,
                'custom_class' => 'plan-bar',
                'originalTask' => [
                    'id' => $task->tsk_id,
                    'apf_id' => $task->apf_id,
                    'keterangan' => $task->keterangan,
                    'status' => $task->status,
                    'progress' => $task->progress,
                    'pic' => $task->pic
                ]
            ];

            $actualData = null;
            if ($task->actual_start && $task->actual_end) {
                $actualData = [
                    'id' => $task->tsk_id . '-actual',
                    'name' => '✅ Task ' . $task->apf_id . ' (Actual)',
                    'start' => $task->actual_start,
                    'end' => $task->actual_end,
                    'progress' => floatval($task->progress),
                    'custom_class' => 'actual-bar',
                    'dependencies' => $task->tsk_id . '-plan',
                    'originalTask' => [
                        'id' => $task->tsk_id,
                        'apf_id' => $task->apf_id,
                        'keterangan' => $task->keterangan,
                        'status' => $task->status,
                        'progress' => $task->progress,
                        'pic' => $task->pic
                    ]
                ];
            }

            return $actualData ? [$planData, $actualData] : [$planData];
        })->flatten(1);

        return response()->json($ganttData);
    }

    public function updateProgress(Request $request, $taskId)
    {
        $request->validate([
            'progress' => 'required|numeric|min:0|max:100'
        ]);

        $task = Task::findOrFail($taskId);
        
        // Update progress
        $task->progress = $request->progress;
        
        // Update status based on progress
        if ($request->progress == 100) {
            $task->status = 'Selesai';
        } elseif ($request->progress > 0) {
            $task->status = 'Sedang Dikerjakan';
        } else {
            $task->status = 'Belum Dikerjakan';
        }
        
        $task->save();

        return response()->json([
            'success' => true,
            'message' => 'Progress updated successfully',
            'task' => $task
        ]);
    }
}