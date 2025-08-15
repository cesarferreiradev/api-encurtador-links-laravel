<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('links', function (Blueprint $table) {
            $table->ulid('id_link')->primary();
            $table->text('original_url');
            $table->string('short_url');
            $table->dateTime('expires_at')->nullable();
            $table->integer('clicks_count')->default(0);
            $table->bigInteger('code_user')->unsigned()->nullable();
            $table->string('status', 120)->default('active');
            $table->timestamps();

            $table->foreign('code_user')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('links');
    }
};
