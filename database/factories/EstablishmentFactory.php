<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Establishment;
use App\Models\Company;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Establishment>
 */
class EstablishmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Establishment::class;

    public function definition(): array
    {
        return [
            'company_id' => $this->faker->randomElement([1, 2, 3, 4, 5]),
            'department_id' => '01',
            'province_id' => '0101',
            'district_id' => '010101',
            'code' => $this->faker->bothify('00##'),
            'description' => $this->faker->company(),
            'address' => $this->faker->address(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
        ];
    }

}
