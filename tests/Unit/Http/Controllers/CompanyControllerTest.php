<?php

namespace Tests\Unit\Http\Controllers;

use App\Models\Domain\Company;
use App\Models\SubDomains\User;
use App\Models\ValueObjects\CountryOfOperation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompanyControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }
    /**
     * Test if the index method returns all companies with the correct structure.
     */
    public function testIndexReturnsAllCompanies()
    {
        // Arrange: Create test records in the database
        $companies = Company::factory()->count(3)->create();

        $this->isAuthenticated();
        // Act: Call the index endpoint of the CompanyController
        $response = $this->actingAs($this->user)->getJson(route('company.index'));
        // Assert: Verify the HTTP response and structure
        $response->assertOk();
        $response->assertJsonCount(3);
        $response->assertJsonStructure([
            '*' => [
                'id',
                'name',
                'description',
                'country_of_operation',
            ],
        ]);

        // Assert: Validate the data correctness
        $responseData = $response->json();
        foreach ($companies as $key => $company) {
            $this->assertEquals($company->id, $responseData[$key]['id']);
            $this->assertEquals($company->name, $responseData[$key]['name']);
            $this->assertEquals($company->description, $responseData[$key]['description']);
            $this->assertEquals($company->country_of_operation->toString(), $responseData[$key]['country_of_operation']);
        }
    }

    /**
     * Test if the index method returns an empty array when no companies exist.
     */
    public function testIndexReturnsEmptyArrayWhenNoCompaniesExist()
    {

        // Act: Call the index endpoint of the CompanyController
        $response = $this->actingAs($this->user)->getJson(route('company.index'));

        // Assert: Verify that an empty array is returned
        $response->assertOk();
        $response->assertExactJson([]);
    }

    /**
     * Test if the store method creates a new company successfully with valid data.
     */
    public function testStoreCreatesNewCompany()
    {
        // Arrange: Define valid company data
        $companyData = [
            'name' => 'Test Company',
            'description' => 'Test Description',
            'country_of_operation' => CountryOfOperation::fromArray('US')->toString(),
        ];

        // Act: Call the store endpoint
        $response = $this->actingAs($this->user)->postJson(route('company.store'), $companyData);

        // Assert: Verify the creation and response
        $response->assertStatus(200);
        $response->assertJson(['message' => 'Company created successfully.']);
        $this->assertDatabaseHas('companies', ['name' => $companyData['name']]);
    }

    /**
     * Test if the store method validation fails when required data is missing.
     */
    public function testStoreFailsWithMissingData()
    {
        // Arrange: Define incomplete company data
        $invalidData = [
            'description' => 'Test Description',
        ];

        // Act: Call the store endpoint
        $response = $this->actingAs($this->user)->postJson(route('company.store'), $invalidData);

        // Assert: Verify the validation error response
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name', 'country_of_operation']);
    }

    /**
     * Test if the store method validation fails when the name is not unique.
     */
    public function testStoreFailsWithDuplicateName()
    {
        // Arrange: Create a company with a duplicate name
        $existingCompany = Company::factory()->create(['name' => 'Duplicate Name']);
        $duplicateData = [
            'name' => 'Duplicate Name',
            'description' => 'Another Description',
            'country_of_operation' => ['country' => 'US'],
        ];

        // Act: Call the store endpoint
        $response = $this->actingAs($this->user)->postJson(route('company.store'), $duplicateData);

        // Assert: Verify the validation error response
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name']);
    }

    /**
     * Test if the update method successfully updates a company's details.
     */
    public function testUpdateSuccessfullyUpdatesCompany()
    {
        // Arrange: Create a test company and define updated data
        $company = Company::factory()->create([
            'name' => 'Old Name',
            'description' => 'Old Description',
            'country_of_operation' => CountryOfOperation::fromArray('US'),

        ]);

        $updatedData = [
            'name' => 'Updated Name',
            'description' => 'Updated Description',
            'country_of_operation' => CountryOfOperation::fromArray( 'CA')->toString(),
        ];

        // Act: Call the update endpoint
        $response = $this->actingAs($this->user)->putJson(route('company.update', $company->id), $updatedData);

        // Assert: Verify the update and response
        $response->assertOk();
        $response->assertSee('Country Updated successfully');
        $this->assertDatabaseHas('companies', [
            'id' => $company->id,
            'name' => $updatedData['name'],
            'description' => $updatedData['description'],
        ]);
    }

    /**
     * Test if the update method validation fails with invalid data.
     */
    public function testUpdateFailsWithInvalidData()
    {
        // Arrange: Create a test company and define invalid data
        $company = Company::factory()->create([
            'name' => 'Valid Name',
            'description' => 'Valid Description',
            'country_of_operation' => CountryOfOperation::fromArray('US'),
        ]);

        $invalidData = [
            'name' => 123, // Invalid name type
            'description' => [], // Invalid description type
            'country_of_operation' => 'InvalidCountry', // Invalid country of operation
        ];

        // Act: Call the update endpoint
        $response = $this->actingAs($this->user)->putJson(route('company.update', $company->id), $invalidData);

        // Assert: Verify validation error response
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name', 'description', 'country_of_operation']);
    }

    /**
     * Test if the update method validation fails when required data is missing.
     */
    public function testUpdateFailsWithMissingData()
    {
        // Arrange: Create a company with valid details
        $company = Company::factory()->create([
            'name' => 'Valid Name',
            'description' => 'Valid Description',
            'country_of_operation' => CountryOfOperation::fromArray('US'),
        ]);

        $missingData = [
            // Required fields are missing
        ];

        // Act: Call the update endpoint
        $response = $this->actingAs($this->user)->putJson(route('company.update', $company->id), $missingData);

        // Assert: Verify validation error response
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name', 'description', 'country_of_operation']);
    }

    /**
     * Test if the perUser method returns companies assigned to a user.
     */
    public function testPerUserReturnsAssignedCompanies()
    {
        // Arrange: Create a user with permissions and associated companies
        $companies = Company::factory()->count(2)->create();
        $permissions = ['companies' => $companies->pluck('id')->toArray()];
        $this->user->update(['permissions' => json_encode($permissions)]);

        // Act: Call the perUser endpoint
        $response = $this->actingAs($this->user)->getJson(route('companies.perUser', $this->user->id));

        // Assert: Verify the response and the structure
        $response->assertOk();
        $response->assertJsonCount(count($companies));
        $response->assertJsonStructure([
            '*' => ['id', 'name', 'description', 'country_of_operation'],
        ]);
    }

    /**
     * Test if the perUser method fails for an invalid user ID.
     */
    public function testPerUserFailsForInvalidUser()
    {
        // Arrange: Use a non-existent user ID
        $invalidUserId = 999;

        // Act: Call the perUser endpoint
        $response = $this->actingAs($this->user)->getJson(route('companies.perUser', $invalidUserId));

        // Assert: Verify the error response
        $response->assertStatus(404);
    }
}
