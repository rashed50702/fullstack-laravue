<?php

namespace App\Repository\Tag;

interface TagInterface
{
    public function getAllData();
    public function storeData($data);
    public function updateData($data);
    public function deleteData($id);

}
