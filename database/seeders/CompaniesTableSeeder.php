<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;


class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Faker::create();

        //truncate yerine delete kullansaydık veritabanındaki idler 1 den başlamazdı
        DB::table('companies')->delete();

        $companies=[];

        foreach (range(1,10) as $index) {
            $companies[]=[
                'name'    => $faker->company(),
                'address'  => $faker->address(),
                'website' => $faker->domainname (),
                'email'   => $faker->email(),
                
                'created_at'=>now(),
                'updated_at'=>now(),
            ];
        }

        DB::table('companies')->insert($companies);
    }
}
