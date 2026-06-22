<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'Matricule'          => strtoupper(Str::random(3)) . rand(100, 999),
            'Nom'                => $this->faker->lastName(),
            'Prénom'             => $this->faker->firstName(),
            'Adresse'            => $this->faker->address(),
            'NumTel'             => '06' . rand(10000000, 99999999),
            'CIN'                => strtoupper(Str::random(2)) . rand(100000, 999999),
            'nbTotal'            => 22,
            'IdService'          => 1,
            'email'              => $this->faker->unique()->safeEmail(),
            'email_verified_at'  => now(),
            'password'           => bcrypt('password'),
            'remember_token'     => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
