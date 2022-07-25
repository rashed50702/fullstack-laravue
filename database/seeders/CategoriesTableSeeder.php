<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            ["categoryName" => "Web Development"],
            ["categoryName" => "Mobile App Developement"],
            ["categoryName" => "Fullstack Development"],
            ["categoryName" => "Backend Development"],
            ["categoryName" => "Frontend Development"],
            ["categoryName" => "Project Management"],
            ["categoryName" => "Team Lead"],
        ];
        foreach ($items as $item) {
            Category::create($item);
        }
    }
}
