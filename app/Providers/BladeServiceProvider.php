<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Auth;
use View;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function ($view) 
        {
            $AuthUser=Auth::user();
            $AuthUserType=null;
            if(is_null($AuthUser)){
                $AuthUserType='guest';
            }
            else if($AuthUser->has('student')){
                $AuthUserType='student';   
            }
            else if($AuthUser->has('teacher')){
                $AuthUserType='teacher';   
            }
            //...with this variable
            $view->with('AuthUser', $AuthUser );    
            $view->with('AuthUserType', $AuthUserType );    
        }); 
        $AuthUser=Auth::user();
        $AuthUserType=null;
        if(is_null($AuthUser)){
            $AuthUserType='guest';
        }
        else if($AuthUser->has('student')){
            $AuthUserType='student';   
        }
        else if($AuthUser->has('teacher')){
            $AuthUserType='teacher';   
        }
        View::share('AuthUser',$AuthUser );
        View::share('AuthUserType',$AuthUserType);
    }
}
