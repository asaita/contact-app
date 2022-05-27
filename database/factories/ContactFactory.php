<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Company;

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
        //Contact tablosu için fake datalar ekliyoruz. 
        //Bunları terminalden php artisan migrate:fresh --seed komutu ile seed ettiriyoruz

        return [
            'first_name'=> $this->faker->firstName(),
            'last_name'=> $this->faker->lastName(),
            'phone'=> $this->faker->phoneNumber(),
            'email'=> $this->faker->email(),
            'address'=> $this->faker->address(),
            
            //Aşağıdaki pluck komutu Company sayfasından rastgele idleri alıyor
            'company_id'=> Company::pluck('id')->random()
        ];
    }
}
