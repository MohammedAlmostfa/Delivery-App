<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\User;
use App\Models\Meal;
use App\Models\Restaurant;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $restaurants = Restaurant::all();
        $meals = Meal::all();

        for ($i = 0; $i < 10; $i++) {
            $user = $users->random();
            $restaurant = $restaurants->random();

            $order = Order::create([
                'restaurant_id' => $restaurant->id,
                'user_id' => $user->id,
                'latitude' => fake()->latitude(),
                'longitude' => fake()->longitude(),
                'payment_method' => 'cash',
            ]);

            if ($order) {
                // Attach 1–3 meals randomly
                $selectedMeals = $meals->random(rand(1, 3));

                foreach ($selectedMeals as $meal) {
                    $order->meals()->attach($meal->id, [
                        'quantity' => rand(1, 5)
                    ]);
                }
            }
        }
    }
}
