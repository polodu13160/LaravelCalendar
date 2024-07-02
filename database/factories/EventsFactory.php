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
        $isAllDay = $this->faker->boolean(50);

        return [
            'user_id' => $user->id,
            'start' => $isAllDay == true ? Carbon::parse($startDate)->startOfDay() : $startDate,
            'end' => $isAllDay == true ? Carbon::parse($endDate)->endOfDay() : $endDate,
            'is_all_day' => $isAllDay,
            'title' => $this->faker->text(15),
            'description' => $this->faker->text(60),
            'backgroundColor' => $user->color,
            'borderColor' => $user->color.'80',
            'event_id' => uniqid(),
            'visibility' => 'public',
        ];
    }
}
