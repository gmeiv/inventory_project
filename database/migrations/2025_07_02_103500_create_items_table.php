<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Item;

class CreateItemsTable extends Migration
{
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->string('serial_number')->primary();
            $table->string('serial_image')->nullable();
            $table->string('name');
            $table->integer('stocks');
            $table->string('location');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('items');
    }

    public function showRequestBorrow()
    {
        $items = Item::all(); // Fetch all items from the database
        return view('user.request_borrow', compact('items'));
    }
}
