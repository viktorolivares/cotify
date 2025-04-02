<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\Establishment;
use App\Models\Account;
use App\Models\Company;
use App\Models\Person;
use App\Models\User;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $account = Account::create(['name' => 'Company Ltd.']);

        User::factory()->create([
            'account_id' => $account->id,
            'first_name' => 'Admin',
            'last_name' => 'Istrator',
            'email' => 'demo@gmail.com',
            'password' => 'password',
            'owner' => true,
        ]);

        // Test Elements

        // User::factory(20)->create(['account_id' => $account->id]);
        // $companies = Company::factory(5)->create();

        // Establishment::factory(20)
        //     ->create()
        //     ->each(function ($company) use ($companies) {
        //         $company->update(['company_id' => $companies->random()->id]);
        //     });

        // Person::factory(20)->create();

        // s3rv1f0m_sac : gmail
    }
}
