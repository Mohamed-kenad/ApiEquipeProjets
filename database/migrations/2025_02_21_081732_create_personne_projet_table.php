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
        Schema::create('personne_projet', function (Blueprint $table) {
            $table->id();
            $table->foreignId('personne_id')->constrained("personnes")->onDelete('cascade');
            $table->foreignId('projet_id')->constrained("projets")->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personne_projet');
    }
};
