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
        Schema::create('statistique_matches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('match_id')->constrained()->onDelete('cascade');
            $table->foreignId('homme_du_match_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('femme_du_match_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('meilleur_defenseur_id')->nullable()->constrained('users')->onDelete('set null');
            $table->integer('buts_equipe_1')->default(0);
            $table->integer('buts_equipe_2')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statistique_matches');
    }
};
