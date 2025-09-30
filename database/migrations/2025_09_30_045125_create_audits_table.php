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
        Schema::create('audits', function (Blueprint $table) {
            $table->id();
            
            // Información del modelo auditado
            $table->string('auditable_type'); // Nombre del modelo (Property, Seller, User)
            $table->unsignedBigInteger('auditable_id'); // ID del registro modificado
            
            // Información del usuario que hizo el cambio
            $table->string('user_type')->nullable(); // Tipo de usuario (User o Seller)
            $table->unsignedBigInteger('user_id')->nullable(); // ID del usuario
            $table->string('user_name')->nullable(); // Nombre del usuario para referencia
            
            // Información del cambio
            $table->string('event'); // created, updated, deleted
            $table->json('old_values')->nullable(); // Valores anteriores
            $table->json('new_values')->nullable(); // Valores nuevos
            $table->string('ip_address')->nullable(); // IP del usuario
            $table->text('user_agent')->nullable(); // Navegador del usuario
            
            $table->timestamps();
            
            // Índices para optimizar consultas
            $table->index(['auditable_type', 'auditable_id']);
            $table->index(['user_type', 'user_id']);
            $table->index('event');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audits');
    }
};
