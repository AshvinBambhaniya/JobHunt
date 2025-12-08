<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::transaction(function () {
            // First, update any existing `NULL` values to a sensible default.
            DB::table('job_applications')->whereNull('job_type')->update(['job_type' => 'onsite']);
            
            // Now, alter the table to make it non-nullable and set a default.
            Schema::table('job_applications', function (Blueprint $table) {
                $table->string('job_type')->default('onsite')->nullable(false)->change();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_applications', function (Blueprint $table) {
            $table->string('job_type')->nullable()->change();
        });
    }
};
