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
        Schema::table('user_enrollments', function (Blueprint $table) {
            if (!Schema::hasColumn('user_enrollments', 'certificate_issued_at')) {
                $table->timestamp('certificate_issued_at')->nullable()->after('completed_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_enrollments', function (Blueprint $table) {
            if (Schema::hasColumn('user_enrollments', 'certificate_issued_at')) {
                $table->dropColumn('certificate_issued_at');
            }
        });
    }
};
