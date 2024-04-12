<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Inventory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CollaboTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 共有を削除できているか()
    {
        $user = User::factory()->create();
        $collaborator = User::factory()->create(['share_id' => $user->share_id]);

        $this->assertEquals($user->share_id, $collaborator->share_id);

        $item = Inventory::factory()->create(['share_id' => $user->share_id, 'user_id' => $collaborator->id]);

        $this->assertEquals($user->share_id, $item->share_id);

        $res = $this->actingAs($user)->delete(route('collaborators.destroy', $collaborator), ['collaborator' =>  $collaborator->id]);

        $res->assertStatus(302);

        // データベースから再びユーザーとインベントリを取得してから確認する
        $collaborator = User::find($collaborator->id);
        $item = Inventory::find($item->id);

        $this->assertNull($collaborator->share_id);
        $this->assertNull($item->share_id);
        $this->assertNotEquals($user->share_id, $collaborator->share_id);
    }

}
