<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        foreach (['pengajarans', 'bukus', 'penelitians', 'pengabdians', 'penunjangs'] as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->text('notes')->nullable()->after('approved_at');
            });
        }
    }

    public function down(): void
    {
        foreach (['pengajarans', 'bukus', 'penelitians', 'pengabdians', 'penunjangs'] as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropColumn('notes');
            });
        }
    }
};
