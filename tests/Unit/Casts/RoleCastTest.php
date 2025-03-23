<?php

namespace Tests\Unit\Casts;

use App\Casts\RoleCast;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class RoleCastTest extends TestCase
{
    private RoleCast $roleCast;

    protected function setUp(): void
    {
        parent::setUp();
        $this->roleCast = new RoleCast();
    }

    public function testSetMethodSuccessfullyConvertsRoleInstanceToString(): void
    {
        $model = $this->createMock(Model::class);
        $key = 'role';

        $roleMock = $this->createMock(\App\Models\ValueObjects\Role::class);
        $roleMock->expects($this->once())
            ->method('toString')
            ->willReturn('ADMIN');

        $result = $this->roleCast->set($model, $key, $roleMock, []);

        $this->assertEquals('ADMIN', $result);
    }

    public function testSetMethodThrowsExceptionForInvalidValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The given value is not an Role instance.');

        $model = $this->createMock(Model::class);
        $key = 'role';
        $value = 'invalid_value';

        $this->roleCast->set($model, $key, $value, []);
    }

    public function testGetMethodReturnsCorrectRole(): void
    {
        $model = $this->createMock(Model::class);
        $key = 'role';
        $value = 'admin';
        $attributes = [];

        $result = $this->roleCast->get($model, $key, $value, $attributes);

        $this->assertEquals('ADMIN', $result);
    }

    public function testGetMethodThrowsExceptionForInvalidRole(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('It is not valid role value');
        $this->expectExceptionCode(0);

        $model = $this->createMock(Model::class);
        $key = 'role';
        $value = 'invalid_role';
        $attributes = [];

        $this->roleCast->get($model, $key, $value, $attributes);
    }
}
