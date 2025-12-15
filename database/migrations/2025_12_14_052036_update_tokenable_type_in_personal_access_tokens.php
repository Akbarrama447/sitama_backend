<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update tokenable_type dari 'App\Models\User' ke 'App\Models\ModelApi\User'
        DB::table('personal_access_tokens')
            ->where('tokenable_type', 'App\Models\User')
            ->update(['tokenable_type' => 'App\Models\ModelApi\User']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Kembalikan tokenable_type dari 'App\Models\ModelApi\User' ke 'App\Models\User'
        DB::table('personal_access_tokens')
            ->where('tokenable_type', 'App\Models\ModelApi\User')
            ->update(['tokenable_type' => 'App\Models\User']);
    }
};
