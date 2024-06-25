<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebsitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('websites', function (Blueprint $table) {
            $table->id();
            $table->string('company_logo')->nullable();
            $table->string('color')->nullable();
            $table->string('caption')->nullable();
            $table->string('sub_caption')->nullable();
            $table->longText('services')->nullable();
            $table->longText('processes')->nullable();
            $table->longText('about')->nullable();
            $table->longText('partners')->nullable();
            $table->longText('testimonials')->nullable();
            $table->longText('contacts')->nullable();
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
        Schema::dropIfExists('websites');
    }
}
