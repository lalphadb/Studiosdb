<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'prenom' => fake()->firstName(),
            'nom' => fake()->lastName(),
            'date_naissance' => fake()->date('Y-m-d', '-18 years'),
            'sexe' => fake()->randomElement(['M', 'F']),
            'telephone' => fake()->phoneNumber(),
            'numero_civique' => fake()->buildingNumber(),
            'nom_rue' => fake()->streetName(),
            'ville' => fake()->city(),
            'province' => 'QC',
            'code_postal' => fake()->postcode(),
            'ecole_id' => null, // Sera défini si nécessaire
            'membre_id' => null, // Sera défini si nécessaire
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'username' => fake()->unique()->userName(),
            'role' => 'membre',
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'active' => true,
            'remember_token' => Str::random(10),
            'last_login_at' => null,
            'last_login_ip' => null,
            'login_attempts' => 0,
            'locked_until' => null,
            'theme_preference' => 'dark',
            'language_preference' => 'fr',
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Create an admin user
     */
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'superadmin',
        ]);
    }
}
