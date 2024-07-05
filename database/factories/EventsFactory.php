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
        $start = Carbon::now()->startOfMonth();
        $end = Carbon::now()->endOfMonth();
        $timestamp = mt_rand($start->timestamp, $end->timestamp);
        $startDate = Carbon::createFromTimestamp($timestamp);
        $endDate = $startDate->copy()->addHours(2);
        $isAllDay = $this->faker->boolean(50);

        $formattedStart = $isAllDay ? $startDate->startOfDay()->format('Y-m-d H:i') : $startDate->format('Y-m-d H:i');
        $formattedEnd = $isAllDay ? $endDate->endOfDay()->format('Y-m-d H:i') : $endDate->format('Y-m-d H:i');
        $category = include base_path('app/Tableaux/Categorie.php');

        return [
            'user_id' => $user->id,
            'start' => $formattedStart,
            'end' => $formattedEnd,
            'is_all_day' => $isAllDay,
            'title' => $this->faker->text(15),
            'description' => $this->faker->text(60),
            'category' => $category[array_rand($category)],
            'backgroundColor' => $user->color,
            'borderColor' => $user->color.'80',
            'event_id' => uniqid(),
            'hubspot_id' => uniqid(),
            'visibility' => 'public',
        ];
    }
}
