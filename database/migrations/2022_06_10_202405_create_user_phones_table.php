<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\UserPhone;
use Carbon\Carbon;

class CreateUserPhonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_phones', function (Blueprint $table) {
            $table->id();
            $table->string('otp');
            $table->char('country_code',2)->default('IN');
            $table->char('locale_code',2)->default('EN');
            $table->string('phone_no');
            $table->dateTIme('expires_at');
            $table->timestamps();
        });
        
        Schema::table('users', function (Blueprint $table) {
            $table->integer('phone_id')->unsigned();
        });

        $users = User::get();
        foreach($users as $user){
            $user_phone = new UserPhone;
            $user_phone->otp = $user->password;
            $user_phone->phone_no = $user->phone_no;
            $user_phone->expires_at = Carbon::now()->toDateTimeString();
            $user_phone->save();

            $user->phone_id = $user_phone->id;
            $user->save();
        }
        Schema::table('users', function (Blueprint $table) {
            $table->removeColumn('password');
            $table->removeColumn('phone_no');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_phones');
    }
}
