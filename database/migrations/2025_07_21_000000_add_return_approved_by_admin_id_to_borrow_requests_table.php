<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('borrow_requests', function (Blueprint $table) {
            $table->unsignedBigInteger('return_approved_by_admin_id')->nullable()->after('approved_by_admin_id');
        });
    }

    public function down()
    {
        Schema::table('borrow_requests', function (Blueprint $table) {
            $table->dropColumn('return_approved_by_admin_id');
        });
    }
}; 