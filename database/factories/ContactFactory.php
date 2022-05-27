<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Database\Factories\Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contact>
 */
class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        
        return [
            'first_name'=> this->$faker->firstName,
            'last_name'=> $faker->lastName,
            'phone'=> $faker->phonenumber,
            'email'=> $faker->email,
            'address'=> $faker->address,
            'company_id'=> Company::pluck('id')->rondom(),
        ];
    }
}
