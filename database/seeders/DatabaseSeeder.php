<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Inventory;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(InventorySeeder::class);

        $users = \App\Models\User::factory(10)->create();

        // add this user to the users array
        $users[] = \App\Models\User::factory()->create([
            'name' => 'Sora',
            'email' => 'test@test.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'share_id' => 1234567890,
            'is_dark_mode' => false,
            'remember_token' => Str::random(10),
        ]);

        foreach ($users as $user) {
            for($i = 0; $i < 9; $i++) {
                \App\Models\ShoppingList::factory()->create([
                    'title' => 'Shopping list ' . ($i + 1),
                    'content' => 'This is shopping list ' . ($i + 1),
                    'user_id' => $user->id,
                ]);
            }
        }
    }
}
