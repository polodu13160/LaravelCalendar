<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class EventsFactory extends Factory
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
        $timestamp = mt_rand($start->timestamp, $end->timestamp);
        $startDate = Carbon::createFromTimestamp($timestamp, 'Europe/Paris');
        $endDate = $startDate->copy()->addHours(2);

        return [
            'user_id' => $user->id,
            'start' => $startDate,
            'end' => $endDate,
            'title' => $this->faker->text(15),
            'description' => $this->faker->text(60),
            'is_all_day' => $this->faker->boolean(50),
            'backgroundColor' => $user->color,
            'borderColor' => $user->color.'80',
        ];
    }
}
