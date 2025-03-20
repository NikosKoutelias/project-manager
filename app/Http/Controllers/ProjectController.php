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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        //
    }
}
