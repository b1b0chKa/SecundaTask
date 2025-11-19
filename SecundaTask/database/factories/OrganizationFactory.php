<?php

namespace Database\Factories;

use App\Models\Building;
use App\Models\Organization;
use App\Models\Phone;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Organization>
 */
class OrganizationFactory extends Factory
{
    protected $model = Organization::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'          => $this->faker->company(),
            'office_number' => $this->faker->unique()->numberBetween(1,100),
        ];
    }


    public function withPhones(int $count = 1)
    {
        return $this->afterCreating(function(Organization $organization) use ($count)
        {
            Phone::factory($count)->create([
                'organization_id' => $organization->id,
            ]);
        });
    }
}
