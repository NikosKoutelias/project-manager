<?php

namespace App\Http\Controllers;

use App\Models\SubDomains\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Project::all()->map(function ($project) {
            return [
                'id' => $project->id,
                'name' => $project->name,
                'description' => $project->description,
                'company_id' => $project->company_id,
            ];
        });
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:companies',
            'description' => 'required',
            'company' => 'required',
        ]);
        $requestData = $request->all();
        $project = Project::create([
            'name' => $requestData['name'],
            'description' => $requestData['description'],
            'company_id' => $requestData['company'],
        ]);

        return response()->json(['message' => 'Project created successfully.']);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $request->validate([
            'name' => 'required|unique:companies',
            'description' => 'required|string',
            'company_id' => 'required',
        ]);
        $project->company_id = $request->company_id;

        $project->update([
            'name' => $request->name,
            'description' => $request->description,
            'company_id' => $request->company_id,
        ]);

        return response('Project Updated successfully', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        //
    }
}
