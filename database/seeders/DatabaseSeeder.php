<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $availableSection =  $data = Http::get("https://content.guardianapis.com/sections?api-key=9d97b471-ee1c-473a-b293-7998a92c4182");
        $availableSection = json_decode($availableSection)->response->results;

        foreach ($availableSection as $section) {
            $newSection = Section::create([
                'name' => $section->webTitle
            ]);
        }
    }
}
