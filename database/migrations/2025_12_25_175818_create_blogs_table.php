<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->string('slug')->unique(); // ⬅️ WAJIB ADA
    $table->text('excerpt')->nullable();
    $table->longText('content');
    $table->string('author');
    $table->boolean('is_published')->default(false);
    $table->timestamps();
});

    }

    public function down()
    {
        Schema::dropIfExists('blogs');
    }
};