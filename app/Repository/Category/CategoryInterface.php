<?php

namespace App\Repository\Category;

interface CategoryInterface
{
    public function getAllData();
    public function storeData($data);
    public function updateData($data);
    public function deleteData($id);
}
