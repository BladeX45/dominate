<?php

namespace Tests\Unit;

use App\Http\Controllers\PageController;
use App\Models\Car;
use Illuminate\Http\Request;
use Tests\TestCase;

class PageControllerTest extends TestCase
{
    /**
     * Test that the isCarAvailable method returns true when a car is available.
     */
    public function test_isCarAvailable_returns_true_when_car_is_available(): void
    {
        // Arrange
        $car = Car::factory()->create([
            'carStatus' => 'available',
            'Transmission' => 'automatic',
        ]);
        $request = new Request([
            'type' => 'automatic',
            'date' => '2022-01-01',
            'session' => '1',
        ]);
        $pageController = new PageController();

        // Act
        $result = $pageController->isCarAvailable($request);

        // Assert
        $this->assertTrue($result);
    }

    /**
     * Test that the isCarAvailable method returns false when a car is not available.
     */
    public function test_isCarAvailable_returns_false_when_car_is_not_available(): void
    {
        // Arrange
        $car = Car::factory()->create([
            'carStatus' => 'unavailable',
            'Transmission' => 'manual',
        ]);
        $request = new Request([
            'type' => 'manual',
            'date' => '2022-01-01',
            'session' => 'morning',
        ]);
        $pageController = new PageController();

        // Act
        $result = $pageController->isCarAvailable($request);

        // Assert
        $this->assertFalse($result);
    }
}
