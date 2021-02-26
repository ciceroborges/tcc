<?php

namespace Database\Factories;

use App\Models\UserDepartment;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserDepartmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserDepartment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {   
        // ONE TO MANY relationship (with data already created)
        $users = \App\Models\User::pluck('id')->toArray();
        $departments = \App\Models\Department::pluck('id')->toArray();
        return [
            'user_id' => $this->faker->randomElement($users),
            'department_id' => $this->faker->randomElement($departments)
        ];
    }
}
