<?php
namespace App\Providers;

use App\Models\Meal;
use App\Models\Restaurant;
use App\Policies\MealPolicy;
use App\Policies\RestaurantPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('createMeal', [MealPolicy::class, 'create']);

        // ربط النماذج بالسياسات الخاصة بها
        Gate::policy(Restaurant::class, RestaurantPolicy::class);
        Gate::policy(Meal::class, MealPolicy::class);



    }
}
