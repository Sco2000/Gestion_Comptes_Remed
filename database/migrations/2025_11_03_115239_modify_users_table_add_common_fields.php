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
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('name', 'nom');
            $table->string('prenom');
            $table->string('adresse');
            $table->string('telephone')->unique();
            $table->enum('statut', ['actif', 'inactif'])->default('actif');
            $table->string('nci')->unique();
            $table->string('login')->unique()->after('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['prenom', 'telephone', 'statut', 'nci', 'login']);
            $table->renameColumn('nom', 'name');
        });
    }
};
