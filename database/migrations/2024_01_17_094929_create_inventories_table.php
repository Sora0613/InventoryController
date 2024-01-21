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
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // 誰が追加したか。外部キー
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('name'); // 製品の名前
            $table->bigInteger('JAN'); // JANコード
            $table->integer('price')->nullable(); // 製品の価格
            $table->integer('quantity'); // 製品の在庫数
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
