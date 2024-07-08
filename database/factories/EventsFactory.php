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
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        $start = Carbon::createFromTimestamp(rand($startOfMonth->timestamp, $endOfMonth->timestamp));
        $end = $start->copy()->addHours(2);
        $endAllDay = $start->copy()->addDays(1);
        $isAllDay = $this->faker->boolean(50);
        $category = include base_path('app/Tableaux/Categories.php');
        $visibility = include base_path('app/Tableaux/Visibility.php');
        $status = array_keys(include base_path('app/Tableaux/Status.php'));

        return [
            'user_id' => $user->id,
            'start' => $isAllDay ? $start->format('Y-m-d') : $start->format('Y-m-d H:i'),
            'end' => $isAllDay ? $endAllDay->format('Y-m-d') : $end->format('Y-m-d H:i'),
            'is_all_day' => $isAllDay,
            'title' => $this->faker->text(15),
            'description' => $this->faker->text(60),
            'category' => $category[array_rand($category)],
            'backgroundColor' => $user->color,
            'borderColor' => $user->color.'80',
            'event_id' => uniqid(),
            'hubspot_id' => uniqid(),
            'visibility' => $visibility[array_rand($visibility)],
            'status' => $status[array_rand($status)],
        ];
    }
}
