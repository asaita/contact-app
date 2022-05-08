<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\factory as Faker;


class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //önce veritabanımızda veri varsa hepsini siliyoruz
        DB::table('companies')->delete();

        $companies=[];
        $faker = Faker::create();


        foreach (range(1,10) as $index) {
            $companies[]= [
                'name'=> $faker->company(),
                'adres'=> $faker->address(),
                'website'=>$faker->domainname(),
                'email'=>$faker->email(),
                'created_at'=>now(),
                'updated_at'=>now(),
            ];
        }

        DB::table('companies')->insert($companies);
    }
}
