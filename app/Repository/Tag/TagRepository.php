<?php

namespace App\Repository\Tag;

use App\Models\Tag;
use App\Repository\Tag\TagInterface;

class TagRepository implements TagInterface
{
    public function getAllData()
    {
        return Tag::orderBy('id', 'desc')->get();
    }

    public function storeData($data)
    {
        $data = Tag::create([
            'tagName' => $data['tagName']
        ]);

        return $data;
    }

    public function updateData($data)
    {
        $data = Tag::where('id', $data['id'])->update([
            'tagName' => $data['tagName']
        ]);

        return $data;
    }

    public function deleteData($id)
    {
        return Tag::where('id', $id)->delete();
    }

}
