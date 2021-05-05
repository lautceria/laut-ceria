<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use App\Models\News;
use App\Models\Image;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $files = Storage::allFiles('public/news');
        Storage::delete($files);

        News::factory(5)
            ->has(
                Image::factory(1)->news()
            )
            ->create();
    }
}
