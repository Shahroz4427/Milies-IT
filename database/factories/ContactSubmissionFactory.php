<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ContactSubmission>
 */
class ContactSubmissionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'landing_page_id'=>1,
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'company_email' => $this->faker->unique()->companyEmail(),
            'phone' => $this->faker->phoneNumber(),
            'company_name' => $this->faker->company(),
            'description' => $this->faker->paragraph(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
