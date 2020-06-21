<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
            $table->char('legal_country_code', 2)->default('IN');
			$table->unsignedInteger('parent_client_id')->nullable();
			$table->string('name')->comment('The public name of the consultant firm, as will be displayed to users on the site, staff dashboards, reports, etc.');
			$table->string('legal_name')->comment('The legal name of the client, to be used for contracts & invoicing');
			$table->string('legal_address_line')->comment('Street address, line 1');
			$table->string('legal_address_line_2')->nullable()->comment('Street address, line 2');
			$table->string('legal_city')->comment('City name');
			$table->string('legal_region')->nullable()->comment('Region (Province/State)');
			$table->string('legal_postal_code')->nullable()->comment('Postal/Zip Code');
			$table->string('logo_url')->nullable();
			$table->string('last_contract_signed_date')->nullable()->comment('The date this firm signed the ACP license agreement');
			$table->string('next_contract_renewal_date')->nullable()->comment('The date the firm\'s ACP license is up for renewal');
			$table->char('currency_code', 3)->nullable()->comment('Which currency do we charge this firm in? The app will be able to override for fixed price events, specials, etc.  This field really addresses credit/subscription purchasing that would be dependent on the agreement with the firm.');
			$table->date('retired_at')->nullable()->comment('The date on which this firm was no longer an Actionable partner.  If this field is NULL then this firm is an active consultant, otherwise the firm is no longer active.  This date can be used to determine if a firm was active on a specified date, using created_at as the other boundary.');
			$table->boolean('is_demo_account')->default(false)->comment('If this firm is for testing purposes (should not impact reports, stats, etc.)');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clients');
    }
}
