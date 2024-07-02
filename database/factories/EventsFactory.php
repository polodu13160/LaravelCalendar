<?php

namespace Database\Factories;

use DateTime;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        $datestart=Carbon::createFromTimestamp($timestamp, 'Europe/Paris');
        $dateend=$datestart->copy()->addHours(2);




        return [
            'user_id' => $user->id,
            'start' => $datestart,
            'end' => $dateend,
            'title' => $this->faker->text(15),
            'description' => $this->faker->text(60),
            'is_all_day' => $this->faker->boolean(50),
            'backgroundColor' => $user->color,
            'borderColor' => $user->color.'80',
        ];
    }
}
