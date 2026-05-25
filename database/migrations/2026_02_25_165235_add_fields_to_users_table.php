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
            $table->string('custom_id')->unique()->after('id')->nullable();
            $table->string('first_name')->after('custom_id')->nullable();
            $table->string('second_name')->after('first_name')->nullable();
            $table->string('phone_number')->unique()->after('email')->nullable();
            $table->integer('mikrotics_count')->default(0)->after('phone_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['custom_id', 'first_name', 'second_name', 'phone_number', 'mikrotics_count']);
        });
    }
};
