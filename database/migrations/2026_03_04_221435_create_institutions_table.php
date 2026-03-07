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
        Schema::create('institutions', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200);
            $table->string('slogan', 100)->nullable();
            $table->string('institution_code', 50)->unique()->nullable();
            $table->text('description')->nullable();
            $table->text('address')->nullable();
            $table->string('postal_code', 20)->nullable();
            $table->enum('institution_type', ['public', 'private'])->default('public');
            $table->string('logo', 255)->nullable();      // Ruta
            $table->string('favicon', 255)->nullable();   // Ruta
            $table->string('website', 255)->nullable();
            $table->string('email', 150)->unique()->nullable();
            $table->string('phone', 20)->nullable();
            
            $table->string('primary_color', 7)->default('#3b82f6');
            $table->string('secondary_color', 7)->default('#8b5cf6');
            
            $table->string('facebook_url', 255)->nullable();
            $table->string('instagram_url', 255)->nullable();
            $table->string('x_url', 255)->nullable();
            $table->string('linkedin_url', 255)->nullable();

            $table->unsignedBigInteger('province_id')->nullable();
            $table->foreign('province_id')
                ->references('id')
                ->on('provinces')
                ->onDelete('set null');

            $table->unsignedBigInteger('country_id')->nullable();
            $table->foreign('country_id')
                ->references('id')
                ->on('countries')
                ->onDelete('set null');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('institutions');
    }
};
