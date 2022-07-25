<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = [
            ["tagName" => "Laravel"],
            ["tagName" => "PHP"],
            ["tagName" => "VueJS"],
            ["tagName" => "Javascript"],
            ["tagName" => "NodeJS"],
            ["tagName" => "Python"],
            ["tagName" => "Ruby&Rails"],
            ["tagName" => "dJango"],
            ["tagName" => "C"],
            ["tagName" => "C++"],
            ["tagName" => "C#"],
            ["tagName" => "Java"],
            ["tagName" => "HTML"],
            ["tagName" => "CSS"],
            ["tagName" => "Bootstrap"],
        ];
        foreach ($tags as $tag) {
            Tag::create($tag);
        }
    }
}
