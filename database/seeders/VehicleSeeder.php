<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Vehicle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $brandsIds = Brand::pluck('id');

    if ($brandsIds->isEmpty()) {
      return;
    }

    foreach (range(1, 50) as $index) {
      Vehicle::factory()->create([
        'brand_id' => $brandsIds->random(),
      ]);
    }
  }
}
