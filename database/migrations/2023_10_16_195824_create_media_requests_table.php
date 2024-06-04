<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media_requests', function (Blueprint $table) {
            $table->id();
            $table->index('order_number');
            $table->string('file_name');
            $table->string('user_file_name');
            $table->string('category');
            $table->string('store_id');
            $table->string('store_name');
            $table->string('confirm')->default(0)->nullable();
            $table->string('edits')->default(0)->nullable();
            $table->text('edit_text')->nullable();
            $table->date('starts_at');
            $table->date('ends_at')->nullable();
            $table->tinyInteger('no_end')->default('0');
            $table->string('device');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('media_requests');
    }
};
