<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     */
    public function up(): void
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('main_lang')->default(localLang());
            $table->foreignId('translate_id')->nullable()->constrained('cities', 'id')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('name',225);
            $table->foreignId('country_id')->constrained('countries','id')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('code');
            $table->tinyInteger('active')->default(1);//0:inactive 1:active 
            $table->date('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     */
    public function down(): void
    {
        Schema::dropIfExists('cities');
    }
};
