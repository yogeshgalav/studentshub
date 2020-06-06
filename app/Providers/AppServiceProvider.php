<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

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
                $notifications=[];
                foreach($user->notifications()->get() as $key=>$notification){
                    $n_text=\App\Models\NotificationText::where('notification_type',$notification->type)->first();
                    if($n_text){
                        $notifications[$key]['text']=$n_text->notification_text;
                        $notifications[$key]['time']=Carbon::createFromTimeStamp(strtotime($notification->created_at))->diffForHumans();
                        $notifications[$key]['data']=$notification->data;
                    }else{
                        \Log::critical('Notification text not found of type'.$notification->type);
                    }
                };
                $view->with('notifications', $notifications);
            }
        });
        Schema::defaultStringLength(191);
    }
}
