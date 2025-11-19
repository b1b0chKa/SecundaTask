<?php

namespace Database\Factories;

use App\Models\Building;
use Clickbar\Magellan\Data\Geometries\Point;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Building>
 */
class BuildingFactory extends Factory
{
    protected $model = Building::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $latitude = $this->faker->latitude(-90, 90);
        $longitude = $this->faker->longitude(-180, 180);

        return [
            'address'  => $this->faker->address(),
            'location' => Point::makeGeodetic($latitude, $longitude),
        ];
    }
}
