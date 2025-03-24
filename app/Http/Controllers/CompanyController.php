<?php

namespace App\Http\Controllers;

use App\Models\Domain\Company;
use App\Models\SubDomains\User;
use App\Models\ValueObjects\CountryOfOperation;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    private array $needs_filter = [
        'name',
        'description',
    ];

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
        $sanitizedText = apply_filters($this->needs_filter, $request->all());

        Company::create([
            'name' => $sanitizedText['name'],
            'description' => $sanitizedText['description'],
            'country_of_operation' => CountryOfOperation::fromArray($request->country_of_operation),
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

        $sanitizedText = apply_filters($this->needs_filter, $request->all());

        $company->update([
            'name' => $sanitizedText['name'],
            'description' => $sanitizedText['description'],
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

    public function perUser(Request $request)
    {
        $user = User::findOrFail($request->userId);
        $company_ids_assigned = json_decode($user->permissions)->companies;
        return Company::whereIn('id', $company_ids_assigned)->get()->map(function ($company) {
            return [
                'id' => $company->id,
                'name' => $company->name,
                'description' => $company->description,
                'country_of_operation' => $company->country_of_operation,
            ];
        });
    }
}
