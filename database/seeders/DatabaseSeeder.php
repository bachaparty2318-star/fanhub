<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['Anime', 'anime', 'Japanese animated series and films'],
            ['Gaming', 'gaming', 'Video games across all platforms'],
            ['Movies', 'movies', 'Feature films and cinematic universes'],
            ['TV Shows', 'tv-shows', 'Television series and streaming shows'],
            ['K-Pop', 'k-pop', 'Korean pop music groups and artists'],
            ['Comics', 'comics', 'Western comic books and graphic novels'],
            ['Manga', 'manga', 'Japanese comic books and serialized print'],
            ['Cosplay', 'cosplay', 'Costume play community and events'],
        ];
        $tags = ['Action', 'Romance', 'Fantasy', 'Sci-Fi', 'Comedy', 'Shounen', 'Shoujo', 'Isekai', 'Open World', 'RPG', 'FPS', 'Slice of Life', 'Superhero', 'Thriller', 'Idol Group', 'Boy Group', 'Girl Group', 'Limited Edition', 'Fan Favorite', 'Trending'];

        DB::transaction(function () use ($categories, $tags): void {
            foreach ($categories as [$name, $slug, $description]) {
                DB::table('categories')->updateOrInsert(
                    ['slug' => $slug],
                    ['name' => $name, 'description' => $description],
                );
            }
            foreach ($tags as $tagName) {
                DB::table('tags')->updateOrInsert(['tag_name' => $tagName], ['tag_name' => $tagName]);
            }

            $admin = User::where('email', 'admin@fanhubplus.com')->first();
            if (! $admin) {
                $password = Str::password(24);
                $admin = new User;
                $admin->forceFill([
                    'name' => 'Fan Hub Admin',
                    'email' => 'admin@fanhubplus.com',
                    'password_hash' => Hash::make($password),
                    'role' => 'admin',
                    'email_verified_at' => now(),
                ])->save();
                $this->command?->info('Created admin@fanhubplus.com with a random password. Set a password before signing in.');
            }

            if (! DB::table('user_profiles')->where('user_id', $admin->getKey())->exists()) {
                DB::table('user_profiles')->insert(['user_id' => $admin->getKey()]);
            }
        });

        $this->call(DemoContentSeeder::class);
    }
}
