<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up()
    {
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chirp_id')->constrained('chirps')->onDelete('cascade');
            $table->string('path');
            $table->string('alt')->nullable();
            $table->timestamps();
        });
    }
};
