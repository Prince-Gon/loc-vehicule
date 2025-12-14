<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $brandsData = [
      ['name' => 'Toyota', 'country' => 'Japan'],
      ['name' => 'Honda', 'country' => 'Japan'],
      ['name' => 'Ford', 'country' => 'USA'],
      ['name' => 'Chevrolet', 'country' => 'USA'],
      ['name' => 'BMW', 'country' => 'Germany'],
      ['name' => 'Mercedes-Benz', 'country' => 'Germany'],
      ['name' => 'Volkswagen', 'country' => 'Germany'],
      ['name' => 'Fiat', 'country' => 'Italy'],
    ];

    foreach ($brandsData as $data) {
      Brand::updateOrCreate(
        ['name' => $data['name']],
        $data
      );
    }
  }
}
