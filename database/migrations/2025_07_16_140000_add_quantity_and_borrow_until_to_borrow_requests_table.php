<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('borrow_requests', function (Blueprint $table) {
            $table->integer('quantity')->default(1)->after('status');
            $table->string('borrow_until', 32)->nullable()->after('quantity');
        });
    }

    public function down()
    {
        Schema::table('borrow_requests', function (Blueprint $table) {
            $table->dropColumn('quantity');
            $table->dropColumn('borrow_until');
        });
    }
}; 