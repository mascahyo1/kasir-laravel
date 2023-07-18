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
        if(!Schema::hasColumn('penjualan', 'tanggal')) {
            Schema::table('penjualan', function (Blueprint $table) {
                $table->date('tanggal')->after('id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        if(Schema::hasColumn('penjualan', 'tanggal')) {
            Schema::table('penjualan', function (Blueprint $table) {
                $table->dropColumn('tanggal');
            });
        }
    }
};
