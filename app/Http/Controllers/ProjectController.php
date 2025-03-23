<?php

namespace App\Http\Controllers;

use App\Models\SubDomains\Project;
use App\Models\SubDomains\User;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\Request;
use PDOException;

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
        try {
            Project::create([
                'name' => $request->name,
                'description' => $request->description,
                'company_id' => $request->company,
            ]);
        } catch (UniqueConstraintViolationException|PDOException $e) {
            if ($e->getCode() == 23000) {
                return response([
                    'errors' => [
                        'name' => [
                            'Project with same company already exists',
                        ]
                    ]
                ], 422);
            } else {
                return response()->json([
                    'error' => 'Generic error',
                    'error_description' => $e->getMessage(),
                ]);
            }
        }

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
        try {
            $project->update([
                'name' => $request->name,
                'description' => $request->description,
                'company_id' => $request->company_id,
            ]);
        } catch (UniqueConstraintViolationException|PDOException $e) {
            if ($e->getCode() == 23000) {
                return response([
                    'errors' => [
                        'name' => [
                            'Project with same company already exists',
                        ]
                    ]
                ], 422);
            } else {
                return response()->json([
                    'error' => 'Generic error',
                    'error_description' => $e->getMessage(),
                ]);
            }
        }
        return response('Project Updated successfully', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return response(null, 204);
    }

    public function perUser(Request $request)
    {
        $user = User::findOrFail($request->userId);
        $project_ids_assigned = json_decode($user->permissions)->projects;
        return Project::whereIn('id', $project_ids_assigned)->get()->map(function ($project) {
            return [
                'id' => $project->id,
                'name' => $project->name,
                'description' => $project->description,
                'company_id' => $project->company_id,
            ];
        });
    }
}
