<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryOptionsTable extends Migration
{
    public function up()
    {
        Schema::create('category_options', function (Blueprint $table) {
            $table->id();
            $table->string('type', 32); // مثلاً: person_type, unit, service_type
            $table->string('title', 100);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('category_options');
    }
}
