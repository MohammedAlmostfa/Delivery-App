<?php
namespace App\Providers;

use App\Models\Meal;
use App\Models\Offer;
use App\Models\Restaurant;
use App\Policies\MealPolicy;
use App\Policies\OfferPolicy;
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
        Gate::define('createOffer', [OfferPolicy::class, 'create']);


        Gate::policy(Restaurant::class, RestaurantPolicy::class);
        Gate::policy(Meal::class, MealPolicy::class);
        Gate::policy(Offer::class, OfferPolicy::class);



    }
}
