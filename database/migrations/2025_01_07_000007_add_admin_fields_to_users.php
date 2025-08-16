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
            // Check if is_admin column doesn't exist before adding
            if (!Schema::hasColumn('users', 'is_admin')) {
                $table->boolean('is_admin')->default(false)->after('country');
            }
            $table->timestamp('admin_verified_at')->nullable()->after('preferences');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['admin_verified_at']);
            // Only drop is_admin if it exists and was added by this migration
            if (Schema::hasColumn('users', 'is_admin')) {
                $table->dropColumn(['is_admin']);
            }
        });
    }
};
