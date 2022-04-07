<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

class FillUserPhoneNumbers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $users = User::whereNull('phone_no')->get();
        $no =123456789;
        foreach($users as $user){
            $user->phone_no = $no;
            $user->save();
            $no=$no+1;
        }

        Schema::table('users', function (Blueprint $table) {
            $table->string('phone_no')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
