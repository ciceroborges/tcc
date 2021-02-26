<?php

namespace Database\Factories;

use App\Models\Appointment;
use Illuminate\Database\Eloquent\Factories\Factory;

class AppointmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Appointment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // ONE TO MANY relationship (with data already created)
        $departments = \App\Models\Department::pluck('id')->toArray();
        $patients = \App\Models\Patient::pluck('id')->toArray();
        return [
            'department_id' => $this->faker->randomElement($departments),
            'patient_id' => $this->faker->randomElement($patients),
            'anamnesis' => $this->faker->sentence,
            'complaint' => $this->faker->sentence,
            'status' => 'WAITING',
        ];
    }
}
