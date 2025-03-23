<?php

namespace Tests\Feature\Intergration;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\SubDomains\User;
use Tests\Unit\TestCase;

class UserApiTest extends TestCase
{

    public function test_user_get_success_response(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('api/user');

        $response->assertContent(json_encode($user->toArray()));
        $response->assertStatus(200);
    }
    public function test_user_get_unauthorized_response(): void
    {}
}
