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
        Schema::create('invitations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inviter_id'); // 誰が招待したか。外部キー
            $table->foreign('inviter_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('invitee_id'); // 誰を招待したか。外部キー
            $table->foreign('invitee_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('share_id')->nullable(); // 共有できる人のID
            $table->foreign('share_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('email'); // 招待された人のメールアドレス
            $table->boolean('accepted')->default(false); // 招待された人が招待を受け入れたかどうか
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invitations');
    }
};
