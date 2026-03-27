<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Str;
use App\Models\Poem;
use App\Models\Category;
use App\Models\User;
use App\Models\Tag;

class PoemSeeder extends Seeder
{
    public function run(): void
    {
        $writer = User::where('role', 'writer')->first();
        $admin = User::where('role', 'admin')->first();
        $categories = Category::all();
        $tags = Tag::all();

        $poems = [
            [
                'title' => 'The Silent Echo',
                'excerpt' => 'A poem about the unspoken feelings that linger in the air.',
                'content' => "In the quiet of the night, when shadows play,\nI find myself lost in what I couldn't say.\nWords unuttered, like ghosts in the dark,\nLeave their invisible, yet indelible mark.\n\nThe silent echo of a forgotten dream,\nPulls me closer to an endless stream\nOf memories fading, colors turning gray,\nIn the quiet of the night, when shadows play.",
                'user_id' => $writer->id,
            ],
            [
                'title' => 'Dancing with the Stars',
                'excerpt' => 'A reflection on looking up at the night sky.',
                'content' => "A million lights pierce the velvet black,\nGuiding the wanderer, showing the track.\nEach star a story, ancient and true,\nShining brightly, just for you.\n\nI reach out my hand, though they are far,\nDreaming of dancing with the brightest star.\nIn this vast universe, where do I belong?\nMaybe right here, writing this song.",
                'user_id' => $writer->id,
            ],
            [
                'title' => 'Autumn Leaves',
                'excerpt' => 'Watching the seasons change and accepting letting go.',
                'content' => "Golden and red, they flutter and fall,\nAnswering the autumn wind's gentle call.\nTrees standing bare, shedding their past,\nKnowing that winter is approaching fast.\n\nThere is beauty in learning to let things go,\nWatching the leaves drift down below.\nA promise of spring, hidden in the cold,\nA timeless story, gracefully told.",
                'user_id' => $admin->id,
            ],
            [
                'title' => 'City Lights',
                'excerpt' => 'The feeling of solitude amidst the bustling city.',
                'content' => "Neon signs blinking, the city is awake,\nA symphony of noise that it likes to make.\nMillions of souls, crossing the street,\nStrangers with stories we will never meet.\n\nAmidst the crowd, I stand alone,\nA quiet observer on a cobblestone.\nThe world moves fast, blurring the lines,\nI find my peace where the streetlamp shines.",
                'user_id' => $writer->id,
            ]
        ];

        foreach ($poems as $poemData) {
            $poem = Poem::create([
                'title' => $poemData['title'],
                'slug' => Str::slug($poemData['title']),
                'excerpt' => $poemData['excerpt'],
                'content' => $poemData['content'],
                'user_id' => $poemData['user_id'],
                'category_id' => $categories->random()->id,
                'status' => 'published',
                'published_at' => now()->subDays(rand(1, 30)),
                'views' => rand(10, 500)
            ]);

            // Attach 2 to 4 random tags
            $poem->tags()->attach(
                $tags->random(rand(2, 4))->pluck('id')->toArray()
            );
        }
    }
}
