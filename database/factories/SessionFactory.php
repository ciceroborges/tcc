<?php

namespace Database\Factories;

use App\Models\Session;
use Illuminate\Database\Eloquent\Factories\Factory;

class SessionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Session::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // ONE TO MANY relationship (with data already created)
        $appointments = \App\Models\Appointment::pluck('id')->toArray();
        return [
            'appointment_id' => $this->faker->randomElement($appointments),
            'title' => $this->faker->sentence,
            'description' => $this->faker->sentence,
            'status' => 'WAITING',
            'date' => now(),
        ];
    }
}
