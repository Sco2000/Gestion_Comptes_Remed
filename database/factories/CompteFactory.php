<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Compte>
 */
class CompteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client_id' => null, // sera assigné dans le seeder
            'numero_compte' => 'CPT-' . $this->faker->unique()->numberBetween(100000, 999999),
            'type' => $this->faker->randomElement(['epargne', 'cheque']),
            'statut' => 'actif',
        ];
    }
}
