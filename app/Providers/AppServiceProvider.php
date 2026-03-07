<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Institution;
use App\Observers\InstitutionObserver;
use Spatie\Activitylog\Models\Activity;
use App\Policies\ActivityPolicy;
use App\Policies\CountryPolicy;
use App\Policies\InstitutionPolicy;
use App\Models\Country;
use App\Policies\ProvincePolicy;
use App\Models\Province;

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
        Institution::observe(InstitutionObserver::class);

        Gate::policy(Institution::class, InstitutionPolicy::class);
        Gate::policy(Activity::class, ActivityPolicy::class);
        Gate::policy(Country::class, CountryPolicy::class);
        Gate::policy(Province::class, ProvincePolicy::class);
    }
}
