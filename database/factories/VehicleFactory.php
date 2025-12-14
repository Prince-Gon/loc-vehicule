<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicle>
 */
class VehicleFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    $availabilityStatuses = ['available', 'reserved', 'maintenance'];
    $vehicleTypes = ['sedan', 'suv', 'truck', 'van', 'wagon', 'hatchback'];

    $wilayaCode = $this->faker->numberBetween(1, 58);
    $yearCode = $this->faker->numberBetween(100, 199);
    $number = $this->faker->numberBetween(10000, 99999);
    $licensePlate = sprintf('%d %d %d', $number, $yearCode, $wilayaCode);

    return [
      'model' => $this->faker->randomElement(['Corolla', 'Yaris', 'Golf', 'Clio', 'Symbol', 'Picanto', 'Accent', 'Duster', '301', '208']),
      'license_plate' => $licensePlate,
      'year' => $this->faker->numberBetween(2015, 2025),
      'kilometers' => $this->faker->numberBetween(100, 150000),
      'rental_price_per_day' => $this->faker->randomFloat(2, 10000, 60000),
      'availability_status' => $this->faker->randomElement($availabilityStatuses),
      'vehicle_type' => $this->faker->randomElement($vehicleTypes),
      'description' => $this->faker->sentence(),
    ];
  }
}
