<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use App\Models\User;
use App\Models\Classroom;
use App\Models\DailyAssignment;
use App\Models\Post;
use App\Models\Doubt;
use App\Models\ClassroomResource;
use App\Models\Homework;
use App\Models\Category;
use App\Models\Subject;
use App\Models\Course;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        Route::model('category', Category::class);
        Route::model('subject', Subject::class);
        Route::model('course', Course::class);

        Route::model('user', User::class);
        Route::model('classroom', Classroom::class);
        Route::model('daily_assignment', DailyAssignment::class);
        Route::model('post', Post::class);
        Route::model('doubt', Doubt::class);
        Route::model('resource', ClassroomResource::class);
        Route::model('homework', Homework::class);
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace.'\Api')
             ->group(base_path('routes/api.php'));
    }
}
