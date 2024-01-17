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
            $table->string('name'); // 製品の名前
            $table->integer('JAN'); // JANコード
            $table->string('description')->nullable(); // 製品の説明
            $table->integer('price')->nullable(); // 製品の価格
            $table->integer('RemainingAmount')->nullable(); // 製品の在庫数
            $table->integer('user_id'); // 誰が追加したか。ユーザーID
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
