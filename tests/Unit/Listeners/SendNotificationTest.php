<?php

namespace Tests\Unit\Listeners;

use App\Infrastracture\Events\RegisterUserEvent;
use App\Infrastracture\Notifications\NewAvailableUser;
use App\Listeners\SendNotification;
use App\Models\SubDomains\User;
use App\Models\ValueObjects\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class SendNotificationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests that notifications are sent to all admin users when the event is handled.
     */
    public function testHandleSendsNotificationToAdminUsers(): void
    {
        // Arrange
        Notification::fake();
        $event = new RegisterUserEvent((object)['id' => 1, 'name' => 'Test User']);
        $adminUser1 = User::factory()->create(['role' => Role::fromArray('ADMIN')]);
        $adminUser2 = User::factory()->create(['role' => Role::fromArray('ADMIN')]);
        $nonAdminUser = User::factory()->create(['role' => Role::fromArray('USER')]);
        $listener = new SendNotification();

        // Act
        $listener->handle($event);

        // Assert
        Notification::assertSentTo([$adminUser1, $adminUser2], NewAvailableUser::class);
        Notification::assertNotSentTo($nonAdminUser, NewAvailableUser::class);
    }

    /**
     * Tests that no notification is sent if there are no admin users.
     */
    public function testHandleDoesNotSendNotificationWhenNoAdminUsersExist(): void
    {
        // Arrange
        Notification::fake();
        $event = new RegisterUserEvent((object)['id' => 1, 'name' => 'Test User']);
        $listener = new SendNotification();

        // Act
        $listener->handle($event);

        // Assert
        Notification::assertNothingSent();
    }

    /**
     * Tests that the handle method does not throw any exceptions with a valid event.
     */
    public function testHandleDoesNotThrowException(): void
    {
        // Arrange
        $event = new RegisterUserEvent((object)['id' => 1, 'name' => 'Test User','email' => 'test@xx.xx','role'=> Role::fromArray('ADMIN')]);
        User::factory()->create(['role' => Role::fromArray('ADMIN'), 'email' => 'admin@xx.xx']);
        $listener = new SendNotification();

        // Act & Assert
        $this->assertNull($listener->handle($event));
    }
}
