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
            $table->string("phone")->nullable(); // Untuk menambahkan column di database
            $table->string("address")->nullable(); // Untuk menambahkan column di database
            $table->string("joining_date")->nullable(); // Untuk menambahkan column di database
            $table->string("photo")->nullable(); // Untuk menambahkan column di database
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn("phone"); // Untuk menghapus column di database
            $table->dropColumn("address"); // Untuk menghapus column di database
            $table->dropColumn("joining_date"); // Untuk menghapus column di database
            $table->dropColumn("photo"); // Untuk menghapus column di database
        });
    }
};
