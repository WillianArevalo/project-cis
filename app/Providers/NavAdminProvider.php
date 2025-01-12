<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class NavAdminProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer("layouts.__partials.admin.navbar", function ($view) {
            $user = auth()->user();
            $maintenance = Setting::where('key', 'maintenance')->first();
            $project_mode = Setting::where('key', 'project_mode')->first();
            $question_mode = Setting::where('key', 'question_mode')->first();
            $view->with([
                'user' => $user,
                'maintenance' => $maintenance,
                'project_mode' => $project_mode,
                'question_mode' => $question_mode,
            ]);
        });
    }
}
