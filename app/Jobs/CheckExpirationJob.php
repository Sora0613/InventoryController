<?php

namespace App\Jobs;

use App\Models\Inventory;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Lib\LineFunctions as Line;

class CheckExpirationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //賞味期限が近づいてきた時にLINEを送る。
        // expiration_dateがnullでないものを取得
        $foods = Inventory::whereNotNull('expiration_date')->whereDate('expiration_date', '<=', now()->addDays(3))->get();

        foreach ($foods as $food) {
            $user = User::find($food->user_id);
            if ($user->isLineExists) {
                $line = new Line();
                $message = "商品：" . $food->name . "の賞味期限が" . $food->expiration_date . "になります。";
                $line->sendMessage($user->line_id, $message);
            }
        }
    }
}
