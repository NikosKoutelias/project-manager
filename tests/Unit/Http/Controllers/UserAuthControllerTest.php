<?php

namespace Tests\Unit\Http\Controllers;

use App\Models\SubDomains\User;
use App\Models\ValueObjects\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserAuthControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /**
     * Tests the destroy method of UserAuthController.
     *
     * The destroy method should successfully delete an existing user.
     */
    public function test_destroy_deletes_existing_user()
    {
        // Arrange: Create a user
        $user = User::factory()->create();

        // Act: Call the destroy method
        $response = $this->actingAs($this->user)->deleteJson(route('user-auth.destroy', ['id' => $user->id]));

        // Assert: Verify user was deleted successfully
        $response->assertStatus(200)
            ->assertSee('User deleted successfully');

        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    }

    /**
     * Tests the destroy method of UserAuthController.
     *
     * The destroy method should return 404 if the user does not exist.
     */
    public function test_destroy_fails_when_user_not_found()
    {
        // Act: Call the destroy method with a non-existent user ID
        $response = $this->actingAs($this->user)->deleteJson(route('user-auth.destroy', ['id' => 9999]));

        // Assert: Verify appropriate error response
        $response->assertStatus(404)
            ->assertSee('No query results for model');
    }

    /**
     * Tests the destroy method of UserAuthController.
     *
     * The destroy method should return 401 if a user is not authenticated.
     */
    public function test_destroy_fails_when_not_authenticated()
    {
        // Arrange: Create a user
        $user = User::factory()->create();

        // Act: Call the destroy method without authenticating
        $this->withHeaders(['Authorization' => 'Bearer invalidtoken']);
        $response = $this->deleteJson(route('user-auth.destroy', ['id' => $user->id]));

        // Assert: Verify unauthorized response
        $response->assertStatus(401);
    }

    /**
     * Tests the update method of UserAuthController.
     *
     * The update method should successfully update a user with valid input data.
     */
    public function test_update_updates_user_with_valid_data()
    {
        // Arrange: Create a user
        $user = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'role' => Role::fromArray('USER'),
            'permissions' => json_encode(['view', 'edit']),
        ]);

        // Prepare valid request data
        $data = [
            'id' => $user->id,
            'name' => 'Updated John Doe',
            'email' => 'updatedjohn@example.com',
            'role' => Role::fromArray('ADMIN')->toString(),
            'permissions' => json_encode(['edit']),
        ];

        // Act: Call the update method
        $response = $this->actingAs($this->user)->putJson(route('user-auth.update', ['id' => $user->id]), $data);

        // Assert: Verify user was updated successfully
        $response->assertStatus(200)
            ->assertSee('User Updated successfully');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated John Doe',
            'email' => 'updatedjohn@example.com',
            'role' => 'Admin',
        ]);
    }

    /**
     * Tests the update method of UserAuthController.
     *
     * The update method should fail if the user does not exist in the database.
     */
    public function test_update_fails_when_user_not_found()
    {
        // Arrange: Prepare request data
        $data = [
            'id' => 9999, // Non-existing ID
            'name' => 'Nonexistent User',
            'email' => 'nonexistent@example.com',
            'role' => Role::fromArray('USER')->toString(),
        ];

        // Act: Call the update method
        $response = $this->actingAs($this->user)->putJson(route('user-auth.update', ['id' => 9999]), $data);

        // Assert: Verify error response
        $response->assertStatus(404)
            ->assertSee('No query results for model');
    }

    /**
     * Tests the update method of UserAuthController.
     *
     * The update method should fail with validation errors for invalid input data.
     */
    public function test_update_fails_with_invalid_data()
    {
        // Arrange: Create a user
        $user = User::factory()->create();

        // Prepare invalid request data
        $data = [
            'id' => $user->id,
            'name' => '',
            'email' => 'invalid-email',
            'role' => 'INVALID_ROLE',
            'permissions' => 'not-json',
        ];

        // Act: Call the update method
        $response = $this->actingAs($this->user)->putJson(route('user-auth.update', ['id' => $user->id]), $data);

        // Assert: Verify validation errors in the response
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'email', 'role', 'permissions']);
    }

    /**
     * Tests the update method of UserAuthController.
     *
     * The update method should fail if attempting to update with a duplicate email.
     */
    public function test_update_fails_on_duplicate_email()
    {
        // Arrange: Create two users
        $user1 = User::factory()->create([
            'email' => 'user1@example.com',
        ]);

        $user2 = User::factory()->create([
            'email' => 'user2@example.com',
        ]);

        // Prepare request data with duplicate email
        $data = [
            'id' => $user1->id,
            'name' => 'Updated User',
            'email' => $user2->email, // Duplicate email
            'role' => Role::fromArray('USER')->toString(),
        ];

        // Act: Call the update method
        $response = $this->actingAs($this->user)->putJson(route('user-auth.update', ['id' => $user1->id]), $data);

        // Assert: Verify validation error for duplicate email
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    /**
     * Tests the index method of UserAuthController.
     *
     * The index method should return a collection of users
     * with properly formatted attributes.
     */
    public function test_index_returns_all_users()
    {
        // Arrange: Create sample users
        $user1 = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'role' => Role::fromArray('USER'),
            'permissions' => json_encode(['projects' => [],'companies' => []]),
        ]);

        $user2 = User::factory()->create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'role' => Role::fromArray('ADMIN'),
            'permissions' => json_encode(['projects' => [],'companies' => []]),
        ]);

        // Act: Call the index method
        $response = $this->actingAs($this->user)->getJson(route('user-auth.index'));

        // Assert: Verify response data matches the created users
        $response->assertOk()
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'name',
                    'email',
                    'role',
                    'permissions',
                ],
            ])
            ->assertJsonFragment([
                'id' => $user1->id,
                'name' => $user1->name,
                'email' => $user1->email,
                'role' => $user1->role->toString(),

            ])
            ->assertJsonFragment([
                'id' => $user2->id,
                'name' => $user2->name,
                'email' => $user2->email,
                'role' =>  $user2->role->toString(),

            ]);
    }

    /**
     * Tests the register method of UserAuthController.
     *
     * The register method should successfully create a new user with valid input data.
     */
    public function test_register_creates_user_with_valid_data()
    {
        // Arrange: Prepare valid request data
        $data = [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => 'securepassword',
            'password_confirmation' => 'securepassword',
            'role' => 'USER',
        ];

        // Act: Call the register method
        $response = $this->actingAs($this->user)->postJson(route('user-auth.register'), $data);

        // Assert: Verify user was created successfully
        $response->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
        ]);
    }

    /**
     * Tests the register method of UserAuthController.
     *
     * The register method should fail with validation errors for invalid input data.
     */
    public function test_register_fails_with_invalid_data()
    {
        // Arrange: Prepare invalid request data
        $data = [
            'name' => '',
            'email' => 'invalid-email',
            'password' => 'short',
        ];

        // Act: Call the register method
        $response = $this->actingAs($this->user)->postJson(route('user-auth.register'), $data);

        // Assert: Verify validation errors in the response
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'email', 'password']);
    }

    /**
     * Tests the register method of UserAuthController.
     *
     * The register method should fail if the email already exists in the database.
     */
    public function test_register_fails_with_duplicate_email()
    {
        // Arrange: Create a user with an existing email
        User::factory()->create([
            'email' => 'existing@example.com',
        ]);

        // Prepare request data with the same email
        $data = [
            'name' => 'New User',
            'email' => 'existing@example.com',
            'password' => 'securepassword',
        ];

        // Act: Call the register method
        $response = $this->actingAs($this->user)->postJson(route('user-auth.register'), $data);

        // Assert: Verify error for duplicate email
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    /**
     * Tests the create method of UserAuthController.
     *
     * The create method should successfully create a new user with valid input data.
     */
    public function test_create_creates_new_user()
    {
        // Arrange: Prepare valid request data
        $data = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'USER',
        ];

        // Act: Call the create method
        $response = $this->actingAs($this->user)->postJson(route('user-auth.register'), $data);

        // Assert: Verify user was created successfully
        $response->assertStatus(200);
        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);
    }

    /**
     * Tests the create method of UserAuthController.
     *
     * The create method should fail with validation errors for invalid input data.
     */
    public function test_create_fails_with_invalid_data()
    {
        // Arrange: Prepare invalid request data
        $data = [
            'name' => '',
            'email' => 'invalid-email',
            'password' => 'short',
            'password_confirmation' => 'different',
            'role' => 'INVALID_ROLE',
        ];

        // Act: Call the create method
        $response = $this->actingAs($this->user)->postJson(route('user-auth.register'), $data);

        // Assert: Verify validation errors in the response
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'email', 'password']);
    }

    /**
     * Tests the create method of UserAuthController.
     *
     * The create method should fail if the email already exists in the database.
     */
    public function test_create_fails_if_email_already_exists()
    {
        // Arrange: Create an existing user
        User::factory()->create([
            'name' => 'Existing User',
            'email' => 'existing@example.com',
        ]);

        // Prepare request data with the same email
        $data = [
            'name' => 'New User',
            'email' => 'existing@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => Role::fromArray('USER'),
        ];

        // Act: Call the create method
        $response = $this->actingAs($this->user)->postJson(route('user-auth.register'), $data);

        // Assert: Verify validation error for duplicate email
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }
}
