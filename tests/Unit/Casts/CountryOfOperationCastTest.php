<?php

namespace Tests\Unit\Casts;

use App\Casts\CountryOfOperationCast;
use App\Models\ValueObjects\CountryOfOperation;
use Illuminate\Database\Eloquent\Model;
use PHPUnit\Framework\TestCase;

class CountryOfOperationCastTest extends TestCase
{
    /**
     * Mock model for testing.
     */
    private function mockModel(): Model
    {
        return $this->createMock(Model::class);
    }

    /**
     * Test that the get method successfully casts the value using CountryOfOperation.
     */
    public function testGetMethodSuccessfullyCastsValue(): void
    {
        $cast = new CountryOfOperationCast();
        $mockModel = $this->mockModel();
        $value = ['country' => 'US'];

        $countryOfOperationMock = $this->createMock(CountryOfOperation::class);
        $countryOfOperationMock->method('toString')->willReturn('US');


        $result = $cast->get($mockModel, 'country_of_operation', $value['country'], []);
        $this->assertSame('US', $result);
    }

    /**
     * Test that the set method successfully converts CountryOfOperation to string.
     */
    public function testSetMethodSuccessfullyConvertsValue(): void
    {
        $cast = new CountryOfOperationCast();
        $mockModel = $this->mockModel();

        $countryOfOperationMock = $this->createMock(CountryOfOperation::class);
        $countryOfOperationMock->method('toString')->willReturn('US');

        $result = $cast->set($mockModel, 'country_of_operation', $countryOfOperationMock, []);
        $this->assertSame('US', $result);
    }

    /**
     * Test that the set method throws an exception for invalid value type.
     */
    public function testSetMethodThrowsExceptionForInvalidValue(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The given value is not an Country of operation instance.');

        $cast = new CountryOfOperationCast();
        $mockModel = $this->mockModel();

        $cast->set($mockModel, 'country_of_operation', 'InvalidValue', []);
    }
}
