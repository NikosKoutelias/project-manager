<?php

namespace Tests\Unit\Http\Controllers;

use App\Models\Domain\Company;
use App\Models\SubDomains\Project;
use App\Models\SubDomains\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp(): void
    {
        parent::setUp();
        Company::factory(3)->create();
        $this->user = User::factory()->create();

    }

    /**
     * Test that the index method retrieves all projects.
     */
    public function test_index_retrieves_all_projects()
    {
        // Arrange: Create multiple projects in the database

        $projects = Project::factory()->count(3)->create();

        // Act: Call the index method
        $response = $this->actingAs($this->user)->getJson(route('project.index'));

        // Assert: Check the response structure and data
        $response->assertOk();
        $response->assertJsonCount(3);
        $response->assertJsonStructure([
            '*' => ['id', 'name', 'description', 'company_id'],
        ]);
        foreach ($projects as $project) {
            $response->assertJsonFragment([
                'id' => $project->id,
                'name' => $project->name,
                'description' => $project->description,
                'company_id' => $project->company_id,
            ]);
        }
    }

    /**
     * Test that the destroy method successfully deletes a project.
     */
    public function test_destroy_deletes_project_successfully()
    {
        // Arrange: Create a project
        $project = Project::factory()->create();

        // Act: Call the destroy method
        $response = $this->actingAs($this->user)->deleteJson(route('project.destroy', $project->id));

        // Assert: Ensure the project was deleted
        $response->assertNoContent();
        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
    }

    /**
     * Test that the destroy method returns a 404 error for a non-existent project.
     */
    public function test_destroy_returns_not_found_for_non_existent_project()
    {
        // Act: Attempt to delete a project that does not exist
        $response = $this->actingAs($this->user)->deleteJson(route('project.destroy', 999));

        // Assert: Ensure 404 response is returned
        $response->assertNotFound();
    }

    /**
     * Test that the store method successfully creates a project.
     */
    public function test_store_creates_project_successfully()
    {
        // Arrange: Prepare request data
        $data = [
            'name' => 'New Project',
            'description' => 'A test description',
            'company' => $company_id = Company::factory()->create()->id,
        ];

        // Act: Call the store method
        $response = $this->actingAs($this->user)->postJson(route('project.store'), $data);

        // Assert: Verify the project was created
        $response->assertStatus(200);
        $response->assertJsonFragment(['message' => 'Project created successfully.']);
        $this->assertDatabaseHas('projects', [
            'name' => 'New Project',
            'description' => 'A test description',
            'company_id' => $company_id,
        ]);
    }

    /**
     * Test that the store method returns validation errors for missing fields.
     */
    public function test_store_returns_validation_error_for_missing_fields()
    {
        // Arrange: Prepare incomplete request data
        $data = [
            'name' => '',
            'description' => '',
            'company' => null,
        ];

        // Act: Call the store method
        $response = $this->actingAs($this->user)->postJson(route('project.store'), $data);

        // Assert: Ensure validation errors are returned
        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['name', 'description', 'company']);
    }

    /**
     * Test that the store method fails when the name is not unique.
     */
    public function test_store_returns_validation_error_for_non_unique_name()
    {
        // Arrange: Create a project with a specific name
        Project::factory()->create(['name' => 'Existing Project']);

        // Act: Try to create another project with the same name
        $data = [
            'name' => 'Existing Project',
            'description' => 'Another test description',
            'company' => 1,
        ];

        $response = $this->actingAs($this->user)->postJson(route('project.store'), $data);

        // Assert: Ensure validation errors are returned
        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['name']);
    }

    /**
     * Test that the index method returns an empty array when no projects exist.
     */
    public function test_index_returns_empty_when_no_projects_exist()
    {
        // Act: Call the index method
        $response = $this->actingAs($this->user)->getJson(route('project.index'));

        // Assert: Check the response is an empty array
        $response->assertOk();
        $response->assertExactJson([]);
    }

    /**
     * Test that the update method successfully updates a project.
     */
    public function test_update_updates_project_successfully()
    {
        // Arrange: Create a project
        $project = Project::factory()->create();

        // Prepare updated data
        $updatedData = [
            'name' => 'Updated Project',
            'description' => 'Updated description',
            'company_id' => Company::factory()->create()->id,
        ];

        // Act: Call the update method
        $response = $this->actingAs($this->user)->putJson(route('project.update', $project->id), $updatedData);

        // Assert: Ensure the project was updated
        $response->assertOk();
        $response->assertSeeText('Project Updated successfully');
        $this->assertDatabaseHas('projects', $updatedData);
    }

    /**
     * Test that the update method returns validation errors for missing fields.
     */
    public function test_update_returns_validation_error_for_missing_fields()
    {
        // Arrange: Create a project and prepare incomplete data
        $project = Project::factory()->create();

        $data = [
            'name' => '',
            'description' => '',
            'company_id' => null,
        ];

        // Act: Call the update method
        $response = $this->actingAs($this->user)->putJson(route('project.update', $project->id), $data);

        // Assert: Ensure validation errors are returned
        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['name', 'description', 'company_id']);
    }

    /**
     * Test that the update method returns validation error when name is not unique.
     */
    public function test_update_returns_validation_error_for_non_unique_name()
    {
        // Arrange: Create two projects
        $existingProject = Project::factory()->create(['name' => 'Existing Project']);
        $project = Project::factory()->create();

        // Try to update the project with a duplicate name
        $data = [
            'name' => 'Existing Project',
            'description' => 'Some description',
            'company_id' => $existingProject->company_id,
        ];

        // Act: Call the update method
        $response = $this->actingAs($this->user)->putJson(route('project.update', $project->id), $data);

        // Assert: Ensure validation error for the name field
        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['name']);
    }

    /**
     * Test that the perUser method retrieves only the projects assigned to a user.
     */
    public function test_per_user_returns_projects_assigned_to_user()
    {
        // Arrange: Create a user with assigned project permissions and projects
        $user = User::factory()->create([
            'permissions' => json_encode(['projects' => [1, 2]])
        ]);
        Project::factory()->create(['id' => 1, 'name' => 'Project 1']);
        Project::factory()->create(['id' => 2, 'name' => 'Project 2']);
        Project::factory()->create(['id' => 3, 'name' => 'Project 3']); // Not assigned

        // Act: Call the perUser method
        $response = $this->actingAs($this->user)->actingAs($user)->getJson(route('projects.perUser', ['userId' => $user->id]));

        // Assert: Ensure only the assigned projects are returned
        $response->assertOk();
        $response->assertJsonCount(2);
        $response->assertJsonFragment(['id' => '1', 'name' => 'Project 1']);
        $response->assertJsonFragment(['id' => '2', 'name' => 'Project 2']);
    }

    /**
     * Test that the perUser method returns an empty array when a user has no projects.
     */
    public function test_per_user_returns_empty_array_when_user_has_no_projects()
    {
        // Arrange: Create a user without any project permissions
        $user = User::factory()->create([
            'permissions' => json_encode(['projects' => []])
        ]);

        // Act: Call the perUser method
        $response = $this->actingAs($this->user)->actingAs($user)->getJson(route('projects.perUser', ['userId' => $user->id]));

        // Assert: Ensure the response is an empty array
        $response->assertOk();
        $response->assertExactJson([]);
    }

    /**
     * Test that the perUser method returns a 404 error for a non-existent user.
     */
    public function test_per_user_returns_not_found_for_non_existent_user()
    {
        // Act: Attempt to retrieve projects for a non-existent user
        $response = $this->actingAs($this->user)->getJson(route('projects.perUser', ['userId' => 999]));

        // Assert: Ensure a 404 response is returned
        $response->assertNotFound();
    }
}
