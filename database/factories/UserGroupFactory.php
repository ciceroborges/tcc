<?php

namespace Database\Factories;

use App\Models\UserGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserGroupFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserGroup::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $users = \App\Models\User::pluck('id')->toArray();
        $groups = \App\Models\Group::pluck('id')->toArray();
        return [
            'user_id'  => $this->faker->randomElement($users),
            'group_id' => $this->faker->randomElement($groups),
        ];
    }
}
