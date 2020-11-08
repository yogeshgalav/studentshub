<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScheduledJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scheduled_jobs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->nullable()->index('queue_ix_user_id');
            $table->dateTime('run_at');
            $table->string('job_type', 100);
            $table->json('job_body')->nullable();
            $table->dateTime('sent_to_queue_at')->nullable();
            $table->json('response')->nullable();
            $table->boolean('is_completed')->default(0);
            $table->dateTime('completed_at')->nullable();
            $table->timestamps();
            $table->index(['completed_at', 'run_at'], 'queue_ix_run_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scheduled_jobs');
    }
}
