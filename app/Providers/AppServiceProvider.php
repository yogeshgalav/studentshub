<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \View::composer('*', function($view){
            if($user=\Auth::user()){
                $notifications=$user->notifications()->get()->each(function($notification){
                    $n_text=\App\Models\NotificationText::where('notification_type',$notification->type)->first();
                    if($n_text){
                        $notification->text=$n_text->notification_text;
                    }else{
                        \Log::critical('Notification text not found of type'.$notification->type);
                    }
                });
                $view->with('notifications', $notifications);
            }
        });
        Schema::defaultStringLength(191);
    }
}
