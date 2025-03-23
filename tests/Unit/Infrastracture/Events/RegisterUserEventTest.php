<?php

namespace Tests\Unit\Infrastracture\Events;

use App\Infrastracture\Events\RegisterUserEvent;
use PHPUnit\Framework\TestCase;

class RegisterUserEventTest extends TestCase
{
    /**
     * Test the constructor of the RegisterUserEvent class.
     */
    public function testConstructSetsUser(): void
    {
        // Arrange
        $mockUser = new \stdClass();

        // Act
        $event = new RegisterUserEvent($mockUser);

        // Assert
        $this->assertSame($mockUser, $event->user);
    }
}
