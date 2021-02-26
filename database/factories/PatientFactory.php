<?php

namespace Database\Factories;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PatientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Patient::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'nickname'=> Str::random(10),
            'cpf' => Str::random(10),
            'birth_date' => now(),
            'gender' => 'M',
            'blood_type' => 'A+',
            'allergy' => $this->faker->sentence,
            'address' => $this->faker->sentence,
            'email' => $this->faker->unique()->safeEmail,
            'phone_number' => '54996690167',
            'picture' => Str::random(10),
            'contact_name' => Str::random(10),
            'contact_phone_number' => '54996690167',
        ];
    }
}
