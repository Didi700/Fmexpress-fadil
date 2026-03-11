<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. USERS
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('prenom');
            $table->string('nom');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('telephone')->nullable();
            $table->text('adresse')->nullable();
            $table->string('ville')->nullable();
            $table->string('code_postal')->nullable();
            $table->enum('role', ['CLIENT', 'ADMIN', 'SUPER_ADMIN'])->default('CLIENT');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // 2. ENVOIS
        Schema::create('envois', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('numero_suivi')->unique();
            
            $table->string('expediteur_ville');
            $table->text('expediteur_adresse');
            $table->string('expediteur_code_postal');
            
            $table->string('destinataire_nom');
            $table->string('destinataire_telephone');
            $table->text('destinataire_adresse');
            $table->string('destinataire_ville');
            
            $table->string('type_colis');
            $table->decimal('poids_kg', 8, 2);
            $table->decimal('longueur_cm', 8, 2)->nullable();
            $table->decimal('largeur_cm', 8, 2)->nullable();
            $table->decimal('hauteur_cm', 8, 2)->nullable();
            $table->text('description_contenu')->nullable();
            $table->decimal('valeur_declaree', 10, 2)->nullable();
            
            $table->string('photo_colis_1')->nullable();
            $table->string('photo_colis_2')->nullable();
            $table->string('photo_colis_3')->nullable();
            
            $table->string('mode_livraison');
            $table->boolean('assurance')->default(false);
            
            $table->decimal('prix_base', 10, 2);
            $table->decimal('prix_assurance', 10, 2)->default(0);
            $table->decimal('prix_total', 10, 2);
            
            $table->string('statut')->default('EN_ATTENTE_CONFIRMATION');
            $table->string('statut_paiement')->default('EN_ATTENTE');
            
            $table->timestamps();
        });

        // 3. LOGS ACTIONS ADMIN
        Schema::create('logs_actions_admin', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('envoi_id')->nullable()->constrained('envois')->onDelete('cascade');
            $table->text('action_effectuee');
            $table->timestamps();
        });

        // 4. SESSIONS
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        // 5. CACHE
        Schema::create('cache', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->mediumText('value');
            $table->integer('expiration');
        });

        Schema::create('cache_locks', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->string('owner');
            $table->integer('expiration');
        });

        // 6. JOBS
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('queue')->index();
            $table->longText('payload');
            $table->unsignedTinyInteger('attempts');
            $table->unsignedInteger('reserved_at')->nullable();
            $table->unsignedInteger('available_at');
            $table->unsignedInteger('created_at');
        });

        Schema::create('job_batches', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('name');
            $table->integer('total_jobs');
            $table->integer('pending_jobs');
            $table->integer('failed_jobs');
            $table->longText('failed_job_ids');
            $table->mediumText('options')->nullable();
            $table->integer('cancelled_at')->nullable();
            $table->integer('created_at');
            $table->integer('finished_at')->nullable();
        });

        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('failed_jobs');
        Schema::dropIfExists('job_batches');
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('cache_locks');
        Schema::dropIfExists('cache');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('logs_actions_admin');
        Schema::dropIfExists('envois');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }
};