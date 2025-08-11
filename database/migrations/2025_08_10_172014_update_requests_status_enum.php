<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // For PostgreSQL, we need to use raw SQL to modify the enum
        DB::statement("ALTER TABLE requests DROP CONSTRAINT IF EXISTS requests_status_check");
        DB::statement("ALTER TABLE requests ALTER COLUMN status TYPE VARCHAR(50)");
        DB::statement("ALTER TABLE requests ADD CONSTRAINT requests_status_check CHECK (status IN ('pending', 'approved', 'rejected', 'completed', 'claimed'))");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE requests DROP CONSTRAINT IF EXISTS requests_status_check");
        DB::statement("ALTER TABLE requests ALTER COLUMN status TYPE VARCHAR(50)");
        DB::statement("ALTER TABLE requests ADD CONSTRAINT requests_status_check CHECK (status IN ('pending', 'approved', 'rejected', 'completed'))");
    }
};
