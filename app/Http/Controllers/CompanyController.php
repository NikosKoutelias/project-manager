<?php

namespace App\Http\Controllers;

use App\Models\Domain\Company;
use App\Models\ValueObjects\CountryOfOperation;
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
        $company = Company::create([
            'name' => $requestData['name'],
            'description' => $requestData['description'],
            'country_of_operation' => CountryOfOperation::fromArray($requestData['country_of_operation']),
        ]);

        return response()->json(['message' => 'Company created successfully.']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'country_of_operation' => 'required|in:' . implode(',', array_keys(CountryOfOperation::COUNTRIES)),
            ]);

        $company->update([
            'name' => $request->name,
            'description' => $request->description,
            'country_of_operation' => CountryOfOperation::fromArray($request->country_of_operation)
        ]);
        return response('Country Updated successfully', 200);
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
