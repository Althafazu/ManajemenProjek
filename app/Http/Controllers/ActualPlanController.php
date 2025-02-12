<?php

namespace App\Http\Controllers;

use App\Models\AktualPlan;
use Illuminate\Http\Request;

class ActualPlanController extends Controller
{
    public function index()
    {
        $aktualPlans = AktualPlan::with(['project', 'tasks'])->get();
        return response()->json($aktualPlans);
    }

    public function show($id)
    {
        $aktualPlan = AktualPlan::with(['tasks' => function($query) {
            $query->orderBy('apf_id', 'asc');
        }])->findOrFail($id);

        return response()->json($aktualPlan);
    }

    public function getByProject($projectId)
    {
        $aktualPlan = AktualPlan::where('prj_id', $projectId)
            ->with(['tasks' => function($query) {
                $query->orderBy('apf_id', 'asc');
            }])
            ->firstOrFail();

        return response()->json($aktualPlan);
    }

    public function getTasksByFase($id, $faseId)
    {
        $aktualPlan = AktualPlan::findOrFail($id);
        $tasks = $aktualPlan->tasks()
            ->where('apf_id', $faseId)
            ->orderBy('plan_start', 'asc')
            ->get();

        return response()->json($tasks);
    }
}
