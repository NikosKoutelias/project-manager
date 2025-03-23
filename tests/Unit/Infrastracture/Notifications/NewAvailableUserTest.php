<?php

namespace Tests\Unit\Infrastracture\Notifications;

use App\Infrastracture\Notifications\NewAvailableUser;
use Illuminate\Notifications\Messages\MailMessage;
use PHPUnit\Framework\TestCase;

class NewAvailableUserTest extends TestCase
{
    public function testToMailReturnsCorrectMailMessage()
    {
        // Arrange
        $sender = (object)['id' => 1, 'name' => 'Admin'];
        $message = (object)[
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'role' => new class {
                public function toString(): string
                {
                    return 'User';
                }
            },
            'id' => 123,
        ];

        $notification = new NewAvailableUser($sender, $message);
        $notifiable = (object)['email' => 'recipient@example.com'];

        // Act
        $mailMessage = $notification->toMail($notifiable);

        // Assert
        $this->assertInstanceOf(MailMessage::class, $mailMessage);
        $this->assertEquals('New User from Registration Process', $mailMessage->subject);
        $this->assertStringContainsString('The following user was created:', $mailMessage->introLines[0]);
        $this->assertStringContainsString('Name: John Doe', $mailMessage->introLines[1]);
        $this->assertStringContainsString('email: johndoe@example.com', $mailMessage->introLines[2]);
        $this->assertStringContainsString('role: User', $mailMessage->introLines[3]);
        $this->assertStringContainsString('id: 123', $mailMessage->introLines[4]);
    }
}
