<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitiesTable extends Migration
{
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('coat_of_arms_image');
            $table->text('card_text');
            $table->string('modal_id');
            $table->string('modal_title');
            $table->string('modal_text');
            $table->string('city_image');
            $table->string('wiki_url');
            $table->text('interesting_fact');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cities');
    }
}
