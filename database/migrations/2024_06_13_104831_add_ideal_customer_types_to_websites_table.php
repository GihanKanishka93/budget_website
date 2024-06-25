<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdealCustomerTypesToWebsitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('websites', function (Blueprint $table) {
            $table->string('age_group')->nullable()->after('contact_name');
            $table->string('ethnicity')->nullable()->after('contact_name');
            $table->string('professions')->nullable()->after('contact_name');
            $table->string('interests')->nullable()->after('contact_name');
            $table->string('achievements')->nullable()->after('contact_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('websites', function (Blueprint $table) {
            $table->dropColumn('age_group');
            $table->dropColumn('ethnicity');
            $table->dropColumn('professions');
            $table->dropColumn('interests');
            $table->dropColumn('achievements');
        });
    }
}
