<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Company;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
               
        // $this->call(UsersTableSeeder::class);
        //bulunduğumuz databasesseder sayfasını seeding için çağırdığımızda aşağıdaki
        //iki seeder sayfası çağrılacak
        // $this->call([
        //     CompaniesTableSeeder::class,
        //     ContactsTableSeeder::class,
            
        // ]);

        //80.derste kodu buna çevirdik iki seederda yapılanları bu tek yapiyi
        Company::factory(10)->hasContact(10)->create();

    }
}
