<?php

namespace App\Repository\Category;

use App\Models\Category;
use App\Repository\Category\CategoryInterface;

class CategoryRepository implements CategoryInterface
{
    public function getAllData()
    {
        return Category::orderBy('id', 'desc')->get();
    }
    public function storeData($data)
    {
        Category::create([
            'categoryName' => $data['categoryName'],
            'iconImage' => $data['iconImage']
        ]);
        return;
    }
    public function updateData($data)
    {
        Category::where('id', $data['id'])->update([
            'categoryName' => $data['categoryName'],
            'iconImage' => $data['iconImage']
        ]);
        return;
    }
    public function deleteData($id)
    {
        return Category::where('id', $id)->delete();
    }
}