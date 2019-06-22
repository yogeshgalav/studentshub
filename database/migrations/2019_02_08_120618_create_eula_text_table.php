<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEulaTextTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eula_text', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('eula_id')->unsigned();
            $table->string('locale_code')->comment('Which locale is this text in?');
            $table->text('eula_text')->comment('The actual text of the EULA (will be stored in markdown format)');
            $table->timestamps();
        });

        Schema::table('eula_text', function(Blueprint $table)
        {
            $table->foreign('eula_id')->references('id')->on('eula')->onDelete('cascade');
            //composite key
            $table->index(['eula_id', 'locale_code']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('eula_text');
    }
}
