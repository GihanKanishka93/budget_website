<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveContactsAndContactDetailsToWebsitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('websites', function (Blueprint $table) {
            $table->dropColumn('contacts');
            $table->string('contact_name')->after('testimonials');
            $table->string('contact_phone')->after('testimonials');
            $table->string('contact_email')->after('testimonials');
            $table->longText('social_media')->nullable()->after('testimonials');
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
            $table->dropColumn('contact_name');
            $table->dropColumn('contact_phone');
            $table->dropColumn('contact_email');
            $table->dropColumn('social_media');
        });
    }
}
