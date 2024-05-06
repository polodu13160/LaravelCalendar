<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::inRandomOrder()->first();
        $start = Carbon::now('Europe/Paris')->startOfMonth();
        $end = Carbon::now('Europe/Paris')->endOfMonth();

        return [
            'user_id' => $user->id,
            'start' => $this->faker->dateTimeBetween($start, $end),
            'end' => $this->faker->dateTimeBetween($start, $end),
            'title' => $this->faker->text(15),
            'description' => $this->faker->text(60),
            'is_all_day' => $this->faker->boolean(50),
            'backgroundColor' => $user->color,
            'borderColor' => $user->color.'80',
        ];
    }
}
