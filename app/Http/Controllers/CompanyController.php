<?php

namespace App\Http\Controllers;

use App\Models\Domain\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Company::all()->map(function ($company) {
            return [
                'id' => $company->id,
                'name' => $company->name,
                'description' => $company->description,
                'country_of_operation' => $company->country_of_operation,
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
            'country_of_operation' => 'required',
        ]);
        $requestData = $request->all();
        $company = Company::create($requestData);

        return response()->json(['message' => 'Company created successfully.']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        $company->delete();

        return response(null, 204);
    }
}
