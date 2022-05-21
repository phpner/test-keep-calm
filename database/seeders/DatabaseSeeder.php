<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Page;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * @param Faker $faker
     * @return void
     */
    public function run(Faker $faker)
    {
        $user = User::updateOrCreate(
            ['email' => 'admin@admin.ru'],
            [
                'name' => $faker->name(),
                'email' => 'admin@admin.ru',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'avatar' => 'users/default.jpg', // password
                'remember_token' => Str::random(10),
            ]
        );

        for ($i = 0; $i < 8; $i++) {
            $page = new Page();
            $page->title = $faker->text(10);
            $page->user_id = $user->id;
            $page->status = 'open';
            $page->save();

            Comment::factory()->count(10)->create([
                'page_id' => $page->id,
                'user_id' => $user->id,
            ]);
        }
    }
}
