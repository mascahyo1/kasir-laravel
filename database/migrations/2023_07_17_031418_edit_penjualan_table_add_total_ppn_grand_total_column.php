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
        //
        Schema::table('penjualan', function (Blueprint $table) {
            $table->integer('total')->default(0);
            $table->integer('ppn')->default(0);
            $table->integer('grand_total')->default(0);
            $table->integer('bayar')->default(0);
            $table->integer('kembalian')->default(0);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('penjualan', function (Blueprint $table) {
            $table->dropColumn('total');
            $table->dropColumn('ppn');
            $table->dropColumn('grand_total');
            $table->dropColumn('bayar');
            $table->dropColumn('kembalian');
        });
    }
};
