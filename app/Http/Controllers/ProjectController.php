<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\View\View;

use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    /**
     * index
     *
     * @return View
     */
    public function index(): View
    {
        $projects = Project::orderBy('prj_no_spk', 'asc')->paginate(10);
        return view('projects.index', compact('projects'));
    }

    /**
     * create
     *
     * @return View
     */
    public function create(): View
    {
        return view('projects.create');
    }

    /**
     * store
     *
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'prj_no_spk'    => 'required|unique:projects,prj_no_spk|max:50',
            'prj_nama'      => 'required|min:5|max:100',
            'prj_jenis'     => 'required|in:Internal,Eksternal',
            'prj_status'    => 'required|in:Sedang Berlangsung,Selesai,Batal',
            'prj_start_date'=> 'required|date',
            'prj_deadline'  => 'required|date|after_or_equal:prj_start_date',
        ]);

        Project::create($request->all());

        return redirect()->route('projects.index')->with(['success' => 'Proyek berhasil dibuat!']);
    }

    /**
     * edit
     *
     * @param  string  $id
     * @return View
     */
    public function edit($id)
    {
        $project = Project::findOrFail($id); 
        return view('projects.edit', compact('project'));
    }
    

    /**
     * update
     *
     * @param  Request  $request
     * @param  string   $id
     * @return RedirectResponse
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $project = Project::findOrFail($id);

        $request->validate([
            'prj_no_spk'    => "required|unique:projects,prj_no_spk,$id|max:50",
            'prj_nama'      => 'required|min:5|max:100',
            'prj_jenis'     => 'required|in:Internal,Eksternal',
            'prj_status'    => 'required|in:Sedang Berlangsung,Selesai,Batal',
            'prj_start_date'=> 'required|date',
            'prj_deadline'  => 'required|date|after_or_equal:prj_start_date',
        ]);

        $project->update($request->all());

        return redirect()->route('projects.index')->with(['success' => 'Proyek berhasil diperbarui!']);
    }

     
}