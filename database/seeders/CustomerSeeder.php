<?php

namespace Database\Seeders;

use App\Models\Customer;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('en_US');

        for ($i = 0; $i < 50; $i++) {
            $name = $faker->firstName;
            $company = $faker->company;
            $email = strtolower(str_replace(' ', '_', $name)).'@'.$faker->freeEmailDomain;
            $address = $faker->address;
            $phone = $faker->numerify('##########');

            Customer::create([
                'name' => $name,
                'email' => $email,
                'company' => $company,
                'address' => $address,
                'phone' => $phone,
            ]);
        }
    }
}
