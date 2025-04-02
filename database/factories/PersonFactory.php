<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Person;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Person>
 */
class PersonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Person::class;

    public function definition(): array
    {
        return [
            'identity_document_type_id' => $this->faker->randomElement([1, 6]),
            'number' => $this->faker->randomNumber(8, true),
            'name' => $this->faker->name,
            'trade_name' => $this->faker->company,
            'department_id' => '01',
            'province_id' => '0101',
            'district_id' => '010101',
            'address' => $this->faker->address,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber
        ];
    }
}
