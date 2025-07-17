<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->integer('total_stocks')->default(0)->after('stocks');
        });

        // Set total_stocks = stocks for existing items
        DB::table('items')->update(['total_stocks' => DB::raw('stocks')]);
    }

    public function down()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn('total_stocks');
        });
    }
}; 