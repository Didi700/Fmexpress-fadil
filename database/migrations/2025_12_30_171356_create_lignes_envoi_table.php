<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lignes_envoi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('envoi_id')->constrained('envois')->onDelete('cascade');
            $table->string('categorie_produit'); // TELEPHONE, ORDINATEUR_PORTABLE, etc.
            $table->integer('quantite')->default(1);
            $table->decimal('poids_unitaire', 8, 2); // Poids d'un article
            $table->decimal('poids_total', 8, 2); // Poids total de la ligne
            $table->decimal('prix_unitaire', 10, 2); // Prix d'un article
            $table->decimal('prix_total', 10, 2); // Prix total de la ligne
            $table->string('description')->nullable(); // Description personnalisée
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lignes_envoi');
    }
};