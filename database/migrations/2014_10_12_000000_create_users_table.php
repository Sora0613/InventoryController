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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique(); // TODO : 平文で保存をしているので、暗号化する必要がある。
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->bigInteger('share_id')->nullable(); // 共有できる人のID
            $table->boolean('is_dark_mode')->default(false); // ダークモードかどうか
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
