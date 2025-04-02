<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Company;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Company::class;

    public function definition(): array
    {
        return [
            'account_id' => 1,
            'identity_document_type_id' => $this->faker->randomElement([1, 6]),
            'number' => $this->faker->unique()->numberBetween(20000000000, 20999999999),
            'name' => $this->faker->company(),
            'trade_name' => $this->faker->company().' '.$this->faker->companySuffix(),
            'email' => $this->faker->companyEmail(),
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'department_id' => '01',
            'province_id' => '0101',
            'district_id' => '010101',
            'template_id' => $this->faker->numberBetween(1, 10),
        ];
    }
}
