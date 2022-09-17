<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up()
    {
        Schema::create('chirps', function (Blueprint $table) {
            $table->id();
            $table->text('body')->nullable(); // We'll enforce the character limit at the app level
            $table->foreignId('author_id')->constrained('users');
            $table->foreignId('parent_id')->nullable()->constrained('chirps');
            $table->timestamps();
            $table->softDeletes();
        });
    }
};
